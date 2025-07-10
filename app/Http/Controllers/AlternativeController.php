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

    public function result_bayes()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();

        $scores = [];

        return view('alternatives.result-bayes', compact('scores'));
    }

    public function result_moora()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();

        // Buat matriks keputusan
        $matrix = [];
        foreach ($alternatives as $alt) {
            $row = [];
            foreach ($criterias as $c) {
                $score = $alt->scores->where('criteria_id', $c->id)->first();
                $row[] = $score ? $score->value : 0;
            }
            $matrix[] = $row;
        }

        // Normalisasi
        $norm = [];
        $denominators = [];
        foreach ($criterias as $j => $c) {
            $sumSquares = 0;
            foreach ($matrix as $i => $row) {
                $sumSquares += pow($row[$j], 2);
            }
            $denominators[$j] = sqrt($sumSquares);
        }

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
            $scores[] = ['alt' => $alternatives[$i], 'score' => $score];
        }

        // Urutkan skor
        usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('alternatives.result-moora', compact('scores'));
    }

    public function result_mairca()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();

        // 1. Buat matriks keputusan (X)
        $matrix = [];
        foreach ($alternatives as $alt) {
            $row = [];
            foreach ($criterias as $c) {
                $score = $alt->scores->where('criteria_id', $c->id)->first();
                $row[] = $score ? $score->value : 0;
            }
            $matrix[] = $row;
        }

        // 2. Normalisasi matriks (R) menggunakan tipe 'benefit' atau 'cost'
        $norm = [];
        foreach ($criterias as $j => $c) {
            $column = array_column($matrix, $j);
            $max = max($column);
            $min = min($column);
            foreach ($matrix as $i => $row) {
                if ($c->type === 'benefit') {
                    $norm[$i][$j] = $max != 0 ? $row[$j] / $max : 0;
                } else { // cost
                    $norm[$i][$j] = $min != 0 ? $min / $row[$j] : 0;
                }
            }
        }

        // 3. Buat matriks Q: bobot / jumlah alternatif
        $n = count($alternatives);
        $Q = [];
        foreach ($alternatives as $i => $alt) {
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
            $deviasi[] = ['alt' => $alternatives[$i], 'score' => $total];
        }

        // 5. Urutkan berdasarkan total deviasi terkecil (semakin kecil = semakin baik)
        usort($deviasi, fn($a, $b) => $a['score'] <=> $b['score']);

        return view('alternatives.result-mairca', ['scores' => $deviasi]);
    }
}
