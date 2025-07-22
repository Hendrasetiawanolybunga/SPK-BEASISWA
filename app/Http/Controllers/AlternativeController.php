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
        // Validasi dasar: name wajib, scores opsional
        $request->validate([
            'name' => 'required|string',
            'scores.*' => 'nullable|numeric'
        ]);

        DB::beginTransaction();

        try {
            // Simpan nama alternatif
            $alt = Alternative::create([
                'name' => $request->name
            ]);

            // Cek apakah ada data skor dan proses jika ada
            if ($request->has('scores') && is_array($request->scores)) {
                foreach ($request->scores as $criteria_id => $value) {
                    if ($value !== null && $value !== '') {
                        Score::create([
                            'alternative_id' => $alt->id,
                            'criteria_id' => $criteria_id,
                            'value' => $value
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('alternatives.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
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
        // Validasi dasar
        $request->validate([
            'name' => 'required|string',
            'scores.*' => 'nullable|numeric'  // skor boleh kosong
        ]);

        DB::beginTransaction();

        try {
            // Update nama
            $alternative->update(['name' => $request->name]);

            // Jika skor dikirim dan berupa array
            if ($request->has('scores') && is_array($request->scores)) {
                foreach ($request->scores as $criteria_id => $value) {
                    if ($value !== null && $value !== '') {
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
                }
            }

            DB::commit();

            return redirect()->route('alternatives.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('alternatives.index')->with('success', 'Data berhasil dihapus.');
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

    public function result_bayes()
    {
        $criterias = Criteria::all()->keyBy('code');
        $totalCriteria = $criterias->count();
        $alternatives = Alternative::with('scores')->get();

        $validAlternatives = [];
        $matrix = [];

        foreach ($alternatives as $alt) {
            $scores = $alt->scores->keyBy('criteria.code');

            if ($scores->count() < $totalCriteria) continue;

            $row = [];
            $isComplete = true;

            foreach ($criterias as $code => $criteria) {
                if (!$scores->has($code)) {
                    $isComplete = false;
                    break;
                }

                $val = $scores[$code]->value;

                // Normalisasi manual berdasarkan jenis data
                switch (strtolower($code)) {
                    case 'penghasilan':
                        if (str_contains($val, '<')) {
                            $val = 1;
                        } elseif (str_contains($val, '>')) {
                            $val = 3;
                        } else {
                            $val = 2;
                        }
                        break;

                    case 'domisili':
                    case 'difabel':
                        $val = strtolower($val) === 'ya' ? 1 : 0;
                        break;

                    default:
                        $val = is_numeric($val) ? (float) $val : 0;
                        break;
                }

                // Simpan raw value
                $row[$code] = $val;
            }

            if ($isComplete) {
                $validAlternatives[] = $alt;
                $matrix[] = $row;
            }
        }

        if (count($validAlternatives) === 0) {
            return view('alternatives.result-bayes', ['scores' => []]);
        }

        // Prior probability
        $priorLayak = 0.5;
        $priorTidakLayak = 0.5;

        // Bayes probabilitas dari database
        $probLayak = [];
        foreach ($criterias as $code => $c) {
            $probLayak[$code] = max(min($c->bayes_probability ?? 0.5, 0.99), 0.01);
        }

        $scores = [];

        foreach ($matrix as $i => $data) {
            $logLayak = log($priorLayak);
            $logTidak = log($priorTidakLayak);

            foreach ($data as $code => $val) {
                $c = $criterias[$code];
                $p = $probLayak[$code];
                $p_neg = 1 - $p;

                // Normalisasi ke [0.01, 1] (dengan skala kasar)
                if (is_numeric($val)) {
                    if ($val > 100) $valNorm = 1; // misal data salah input
                    elseif ($val > 1) $valNorm = $val / 100;
                    else $valNorm = $val;
                } else {
                    $valNorm = 0.01;
                }

                $valNorm = max(min($valNorm, 1), 0.01); // clamp

                // Perhitungan likelihood
                if ($c->type === 'cost') {
                    $valNorm = 1 - $valNorm; // cost dibalik
                }

                $likelihood_layak = max(min($valNorm * $p, 0.99), 0.01);
                $likelihood_tidak = max(min($valNorm * $p_neg, 0.99), 0.01);

                $logLayak += log($likelihood_layak) * $c->weight;
                $logTidak += log($likelihood_tidak) * $c->weight;
            }

            $expLayak = exp($logLayak);
            $expTidak = exp($logTidak);
            $total = $expLayak + $expTidak;

            $probLayakFinal = $total > 0 ? $expLayak / $total : 0;
            $probTidakLayakFinal = $total > 0 ? $expTidak / $total : 0;

            $scores[] = [
                'alt' => $validAlternatives[$i],
                'score' => round($probLayakFinal, 4),
                'score_tidak' => round($probTidakLayakFinal, 4),
                'keputusan' => $probLayakFinal > $probTidakLayakFinal ? 'LAYAK' : 'TIDAK LAYAK',
            ];
        }

        usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('alternatives.result-bayes', ['scores' => $scores]);
    }
}
