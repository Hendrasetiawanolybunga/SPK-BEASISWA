<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();
        return view('alternatives.index', compact('alternatives', 'criterias'));
    }

    public function create()
    {
        $criterias = Criteria::all();
        return view('alternatives.create', compact('criterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'scores.*' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $alt = Alternative::create(['name' => $request->name]);

            foreach ($request->scores as $criteria_id => $value) {
                Score::create([
                    'alternative_id' => $alt->id,
                    'criteria_id' => $criteria_id,
                    'value' => $value
                ]);
            }

            DB::commit();
            return redirect()->route('alternatives.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function edit(Alternative $alternative)
    {
        $criterias = Criteria::all();
        return view('alternatives.edit', compact('alternative', 'criterias'));
    }

    public function update(Request $request, Alternative $alternative)
    {
        $request->validate([
            'name' => 'required|string',
            'scores.*' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $alternative->update(['name' => $request->name]);

            foreach ($request->scores as $criteria_id => $value) {
                $score = $alternative->scores()->where('criteria_id', $criteria_id)->first();
                if ($score) {
                    $score->update(['value' => $value]);
                } else {
                    Score::create([
                        'alternative_id' => $alternative->id,
                        'criteria_id' => $criteria_id,
                        'value' => $value
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('alternatives.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('alternatives.index')->with('success', 'Data berhasil dihapus.');
    }

    public function result_bayes()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();

        $scores = [];

        return view('alternatives.result-bayes', compact('scores'));
    }

    public function result_moora()
    {
        $criterias = Criteria::all();
        $totalCriteria = $criterias->count();

        $alternatives = Alternative::with('scores')->get();

        $validAlternatives = [];
        $matrix = [];

        // Filter hanya alternatif yang memiliki skor lengkap
        foreach ($alternatives as $alt) {
            $scores = $alt->scores->keyBy('criteria_id');

            // Jika skor yang dimiliki tidak sebanyak kriteria, skip alternatif ini
            if ($scores->count() < $totalCriteria) {
                continue;
            }

            $row = [];
            $isComplete = true;

            foreach ($criterias as $criteria) {
                if (!$scores->has($criteria->id)) {
                    $isComplete = false;
                    break;
                }
                $row[] = $scores[$criteria->id]->value;
            }

            if ($isComplete) {
                $validAlternatives[] = $alt;
                $matrix[] = $row;
            }
        }

        // Hitung denominator untuk normalisasi
        $denominators = [];
        foreach ($criterias as $j => $c) {
            $sumSquares = 0;
            foreach ($matrix as $i => $row) {
                $sumSquares += pow($row[$j], 2);
            }
            $denominators[$j] = sqrt($sumSquares);
        }

        // Normalisasi
        $norm = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                $norm[$i][$j] = $denominators[$j] != 0 ? $val / $denominators[$j] : 0;
            }
        }

        // Hitung skor MOORA
        $scores = [];
        foreach ($norm as $i => $row) {
            $score = 0;
            foreach ($row as $j => $val) {
                $weight = $criterias[$j]->weight;
                if ($criterias[$j]->type === 'benefit') {
                    $score += $val * $weight;
                } else {
                    $score -= $val * $weight;
                }
            }

            $scores[] = ['alt' => $validAlternatives[$i], 'score' => $score];
        }

        // Urutkan dari skor tertinggi ke terendah
        usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('alternatives.result-moora', compact('scores'));
    }

    public function result_mairca()
    {
        $criterias = Criteria::all();
        $totalCriteria = $criterias->count();

        $alternatives = Alternative::with('scores')->get();

        $validAlternatives = [];
        $matrix = [];

        // 1. Filter alternatif dengan skor lengkap
        foreach ($alternatives as $alt) {
            $scores = $alt->scores->keyBy('criteria_id');

            if ($scores->count() < $totalCriteria) {
                continue;
            }

            $row = [];
            $isComplete = true;

            foreach ($criterias as $criteria) {
                if (!$scores->has($criteria->id)) {
                    $isComplete = false;
                    break;
                }
                $row[] = $scores[$criteria->id]->value;
            }

            if ($isComplete) {
                $validAlternatives[] = $alt;
                $matrix[] = $row;
            }
        }

        $n = count($validAlternatives);
        if ($n === 0) {
            return view('alternatives.result-mairca', ['scores' => []]);
        }

        // 2. Normalisasi matriks (R) berdasarkan tipe kriteria
        $norm = [];
        foreach ($criterias as $j => $c) {
            $column = array_column($matrix, $j);
            $max = max($column);
            $min = min($column);

            foreach ($matrix as $i => $row) {
                if ($c->type === 'benefit') {
                    $norm[$i][$j] = $max != 0 ? $row[$j] / $max : 0;
                } else {
                    $norm[$i][$j] = $row[$j] != 0 ? $min / $row[$j] : 0;
                }
            }
        }

        // 3. Buat matriks Q: bobot / jumlah alternatif valid
        $Q = [];
        foreach ($validAlternatives as $i => $alt) {
            foreach ($criterias as $j => $c) {
                $Q[$i][$j] = $c->weight / $n;
            }
        }

        // 4. Hitung deviasi |Q - R|
        $deviasi = [];
        foreach ($norm as $i => $row) {
            $total = 0;
            foreach ($row as $j => $val) {
                $diff = abs($Q[$i][$j] - $val);
                $total += $diff;
            }
            $deviasi[] = ['alt' => $validAlternatives[$i], 'score' => $total];
        }

        // 5. Urutkan berdasarkan total deviasi terkecil
        usort($deviasi, fn($a, $b) => $a['score'] <=> $b['score']);

        return view('alternatives.result-mairca', ['scores' => $deviasi]);
    }
}
