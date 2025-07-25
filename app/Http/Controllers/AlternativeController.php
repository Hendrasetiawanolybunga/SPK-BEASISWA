<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlternativeController extends Controller
{
    // Fungsi pembantu untuk memetakan nilai input string/nominal ke nilai numerik untuk MOORA/Bayes
    private function mapCriteriaValue($criteriaName, $inputValue)
    {
        $lowerName = Str::lower($criteriaName);

        // Handle Prestasi Akademik
        if (Str::contains($lowerName, 'prestasi akademik')) {
            switch ($inputValue) {
                case 'juara_olimpiade': return 5;
                case 'juara_kelas': return 4;
                case 'juara_lainnya': return 3;
                case 'tidak_ada_akademik': return 1;
                default: return 0;
            }
        }
        // Handle Prestasi Non-Akademik
        elseif (Str::contains($lowerName, 'prestasi non-akademik')) {
            return ($inputValue == 'ada') ? 1 : 0;
        }
        // Handle Keterlibatan Masyarakat
        elseif (Str::contains($lowerName, 'keterlibatan masyarakat')) {
            switch ($inputValue) {
                case 'ketua': return 4;
                case 'pengurus': return 3;
                case 'anggota': return 2;
                case 'tidak_ada_keterlibatan': return 1;
                default: return 0;
            }
        }
        // Handle Kondisi Ekonomi (input string, output kategori numerik)
        elseif (Str::contains($lowerName, 'kondisi ekonomi')) {
            switch ($inputValue) {
                case 'sangat_buruk': return 5;
                case 'buruk': return 4;
                case 'cukup': return 3;
                case 'baik': return 2;
                case 'sangat_baik': return 1;
                default: return 0;
            }
        }
        // Handle Penghasilan Orang Tua (input string rentang, output kategori numerik)
        elseif (Str::contains($lowerName, 'penghasilan orang tua')) {
            switch ($inputValue) {
                case '<_1jt': return 1; // < Rp 1.000.000
                case '1jt_2.5jt': return 2; // Rp 1.000.000 - Rp 2.500.000
                case '2.5jt_5jt': return 3; // Rp 2.500.000 - Rp 5.000.000
                case '5jt_10jt': return 4; // Rp 5.000.000 - Rp 10.000.000
                case '>_10jt': return 5; // > Rp 10.000.000
                default: return 0;
            }
        }
        // Handle Domisili 3T dan Difabel (input 0 atau 1)
        elseif (Str::contains($lowerName, ['domisili 3t', 'difabel'])) {
            return (int) $inputValue;
        }
        // Default untuk kriteria lain (misal: Jumlah Tanggungan) yang sudah numerik
        else {
            return (float) $inputValue;
        }
    }


    public function index()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all(); // Tetap ambil semua kriteria untuk tabel index
        return view('alternatives.index', compact('alternatives', 'criterias'));
    }

    public function create()
    {
        $allCriterias = Criteria::all();
        // Pisahkan kriteria Kondisi Ekonomi dan Penghasilan Orang Tua
        $kondisiEkonomiCriteria = $allCriterias->firstWhere('name', 'Kondisi Ekonomi');
        $penghasilanOrtuCriteria = $allCriterias->firstWhere('name', 'Penghasilan Orang Tua');
        // Filter kriteria lainnya
        $otherCriterias = $allCriterias->filter(function($criteria) {
            return !Str::contains(Str::lower($criteria->name), ['kondisi ekonomi', 'penghasilan orang tua']);
        });

        return view('alternatives.create', compact('kondisiEkonomiCriteria', 'penghasilanOrtuCriteria', 'otherCriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $alt = Alternative::create([
                'name' => $request->name
            ]);

            if ($request->has('scores') && is_array($request->scores)) {
                foreach ($request->scores as $criteria_id => $inputValue) {
                    $criteria = Criteria::find($criteria_id);
                    if (!$criteria) { continue; }

                    $valueToStore = $this->mapCriteriaValue($criteria->name, $inputValue);

                    if ($valueToStore !== null && $valueToStore !== '') {
                        Score::create([
                            'alternative_id' => $alt->id,
                            'criteria_id' => $criteria_id,
                            'value' => $valueToStore
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('alternatives.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Alternative $alternative)
    {
        $allCriterias = Criteria::all();
        // Pisahkan kriteria Kondisi Ekonomi dan Penghasilan Orang Tua
        $kondisiEkonomiCriteria = $allCriterias->firstWhere('name', 'Kondisi Ekonomi');
        $penghasilanOrtuCriteria = $allCriterias->firstWhere('name', 'Penghasilan Orang Tua');
        // Filter kriteria lainnya
        $otherCriterias = $allCriterias->filter(function($criteria) {
            return !Str::contains(Str::lower($criteria->name), ['kondisi ekonomi', 'penghasilan orang tua']);
        });

        return view('alternatives.edit', compact('alternative', 'kondisiEkonomiCriteria', 'penghasilanOrtuCriteria', 'otherCriterias'));
    }

    public function update(Request $request, Alternative $alternative)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $alternative->update(['name' => $request->name]);

            if ($request->has('scores') && is_array($request->scores)) {
                foreach ($request->scores as $criteria_id => $inputValue) {
                    $criteria = Criteria::find($criteria_id);
                    if (!$criteria) { continue; }

                    $valueToStore = $this->mapCriteriaValue($criteria->name, $inputValue);

                    if ($valueToStore !== null && $valueToStore !== '') {
                        $score = $alternative->scores()->where('criteria_id', $criteria_id)->first();

                        if ($score) {
                            $score->update(['value' => $valueToStore]);
                        } else {
                            Score::create([
                                'alternative_id' => $alternative->id,
                                'criteria_id' => $criteria_id,
                                'value' => $valueToStore
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('alternatives.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('alternatives.index')->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Menghitung hasil Naive Bayes untuk klasifikasi "LAYAK" atau "TIDAK LAYAK".
     *
     * @param \Illuminate\Support\Collection $alternatives Koleksi alternatif yang akan diproses.
     * @return array Array asosiatif berisi 'layak_alternatives', 'tidak_layak_alternatives', 'bayes_scores'.
     */
    private function calculateBayes(
        $alternatives,
        $criterias,
        $priorLayak = 0.5,
        $priorTidakLayak = 0.5,
        $smoothing = 1e-9 // Laplace smoothing untuk menghindari probabilitas nol
    ) {
        $bayesScores = [];
        $layakAlternatives = [];
        $tidakLayakAlternatives = [];

        foreach ($alternatives as $alt) {
            $scores = $alt->scores->keyBy('criteria_id');
            $probGivenLayak = 1.0; // P(X|Layak)
            $probGivenTidakLayak = 1.0; // P(X|Tidak Layak)

            foreach ($criterias as $criteria) {
                $featureValue = $scores->has($criteria->id) ? $scores[$criteria->id]->value : null;

                if ($featureValue === null) {
                    continue 2;
                }

                $bayesProb = $criteria->bayes_probability;

                $p_feature_given_layak = 0.5;
                $p_feature_given_tidak_layak = 0.5;

                $lowerName = Str::lower($criteria->name);

                if (Str::contains($lowerName, 'prestasi akademik')) {
                    if ($featureValue >= 3) { // Favorable: 5,4,3
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else { // Unfavorable: 1
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'prestasi non-akademik')) {
                    if ($featureValue == 1) { // Favorable: 1 (Ada)
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else { // Unfavorable: 0 (Tidak Ada)
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'keterlibatan masyarakat')) {
                    if ($featureValue >= 2) { // Favorable: 4,3,2
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else { // Unfavorable: 1
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'kondisi ekonomi')) {
                    // COST criteria. Favorable: 5 (Sangat Buruk) -> 0.95
                    if ($featureValue == 5) { // Sangat Buruk
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } elseif ($featureValue == 4) { // Buruk
                        $p_feature_given_layak = $bayesProb * 0.9;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.9);
                    } elseif ($featureValue == 3) { // Cukup
                        $p_feature_given_layak = $bayesProb * 0.5;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.5);
                    } else { // Baik (2), Sangat Baik (1) = Unfavorable
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'penghasilan orang tua')) {
                    // COST criteria. Favorable: 1 (< Rp 1jt) -> 0.98
                    if ($featureValue == 1) { // < Rp 1.000.000
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } elseif ($featureValue == 2) { // Rp 1.000.000 - Rp 2.500.000
                        $p_feature_given_layak = $bayesProb * 0.9;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.9);
                    } elseif ($featureValue == 3) { // Rp 2.500.000 - Rp 5.000.000
                        $p_feature_given_layak = $bayesProb * 0.7;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.7);
                    } else { // 4, 5 (Unfavorable)
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'domisili 3t')) {
                    if ($featureValue == 1) { // Favorable: 1 (Ya)
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else { // Unfavorable: 0 (Tidak)
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'difabel')) {
                    if ($featureValue == 1) { // Favorable: 1 (Ya)
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else { // Unfavorable: 0 (Tidak)
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'jumlah tanggungan orang tua')) {
                    // BENEFIT criteria. Favorable: >= 3 tanggungan (asumsi)
                    if ($featureValue >= 3) {
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else { // Unfavorable: < 3 tanggungan
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                }

                $probGivenLayak *= ($p_feature_given_layak + $smoothing);
                $probGivenTidakLayak *= ($p_feature_given_tidak_layak + $smoothing);
            }

            $probLayakFinal = $priorLayak * $probGivenLayak;
            $probTidakLayakFinal = $priorTidakLayak * $probGivenTidakLayak;

            $totalPosterior = $probLayakFinal + $probTidakLayakFinal;

            $finalProbLayak = $totalPosterior != 0 ? $probLayakFinal / $totalPosterior : 0;
            $finalProbTidakLayak = $totalPosterior != 0 ? $probTidakLayakFinal / $totalPosterior : 0;

            $keputusan = ($finalProbLayak > $finalProbTidakLayak) ? 'LAYAK' : 'TIDAK LAYAK';

            $bayesScores[] = [
                'alt' => $alt,
                'score_layak' => $finalProbLayak,
                'score_tidak_layak' => $finalProbTidakLayak,
                'keputusan' => $keputusan,
            ];

            if ($keputusan === 'LAYAK') {
                $layakAlternatives[] = $alt;
            } else {
                $tidakLayakAlternatives[] = $alt;
            }
        }

        usort($bayesScores, fn($a, $b) => $b['score_layak'] <=> $a['score_layak']);

        return [
            'bayes_scores' => $bayesScores,
            'layak_alternatives' => collect($layakAlternatives),
            'tidak_layak_alternatives' => collect($tidakLayakAlternatives),
        ];
    }

    /**
     * Menghitung hasil MOORA.
     *
     * @param \Illuminate\Support\Collection $alternatives Koleksi alternatif yang akan diproses.
     * @param \Illuminate\Support\Collection $criterias Koleksi kriteria.
     * @return array Array asosiatif berisi skor MOORA yang sudah diurutkan.
     */
    private function calculateMoora($alternatives, $criterias)
    {
        $totalCriteria = $criterias->count();
        $matrix = [];
        $validAlternativesForMoora = [];

        foreach ($alternatives as $alt) {
            $scores = $alt->scores->keyBy('criteria_id');
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
                $validAlternativesForMoora[] = $alt;
                $matrix[] = $row;
            }
        }

        if (empty($matrix)) {
            return [];
        }

        $denominators = [];
        foreach ($criterias as $j => $c) {
            $sumSquares = 0;
            foreach ($matrix as $i => $row) {
                $sumSquares += pow($row[$j], 2);
            }
            $denominators[$j] = sqrt($sumSquares);
        }

        $norm = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                $norm[$i][$j] = $denominators[$j] != 0 ? $val / $denominators[$j] : 0;
            }
        }

        $mooraScores = [];
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
            $mooraScores[] = ['alt' => $validAlternativesForMoora[$i], 'score' => $score];
        }

        usort($mooraScores, fn($a, $b) => $b['score'] <=> $a['score']);

        return $mooraScores;
    }

    /**
     * Menampilkan hasil kombinasi Naive Bayes (filtering) dan MOORA (ranking).
     *
     * @return \Illuminate\View\View
     */
    public function result_bayes_moora()
    {
        $criterias = Criteria::all();
        $alternatives = Alternative::with('scores')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return view('alternatives.result-bayes-moora', [
                'bayesResults' => [],
                'mooraRankings' => [],
                'totalAlternatives' => 0,
                'layakCount' => 0,
                'tidakLayakCount' => 0,
                'layakAlternatives' => collect([]),
                'tidakLayakAlternatives' => collect([]),
            ]);
        }

        // 1. Lakukan perhitungan Naive Bayes untuk klasifikasi awal
        $bayesOutput = $this->calculateBayes($alternatives, $criterias);

        $bayesScores = $bayesOutput['bayes_scores'];
        $layakAlternatives = $bayesOutput['layak_alternatives'];
        $tidakLayakAlternatives = $bayesOutput['tidak_layak_alternatives'];

        // 2. Lakukan perhitungan MOORA hanya untuk alternatif yang "LAYAK"
        $mooraRankings = $this->calculateMoora($layakAlternatives, $criterias);

        return view('alternatives.result-bayes-moora', [
            'bayesResults' => $bayesScores,
            'mooraRankings' => $mooraRankings,
            'totalAlternatives' => $alternatives->count(),
            'layakCount' => $layakAlternatives->count(),
            'tidakLayakCount' => $tidakLayakAlternatives->count(),
            'layakAlternatives' => $layakAlternatives,
            'tidakLayakAlternatives' => $tidakLayakAlternatives,
        ]);
    }

    // Metode result_mairca() tetap seperti sebelumnya
    public function result_mairca()
    {
        $criterias = Criteria::all();
        $totalCriteria = $criterias->count();

        $alternatives = Alternative::with('scores')->get();

        $validAlternatives = [];
        $matrix = [];

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

        $Q = [];
        foreach ($validAlternatives as $i => $alt) {
            foreach ($criterias as $j => $c) {
                $Q[$i][$j] = $c->weight / $n;
            }
        }

        $deviasi = [];
        foreach ($norm as $i => $row) {
            $total = 0;
            foreach ($row as $j => $val) {
                $diff = abs($Q[$i][$j] - $val);
                $total += $diff;
            }
            $deviasi[] = ['alt' => $validAlternatives[$i], 'score' => $total];
        }

        usort($deviasi, fn($a, $b) => $a['score'] <=> $b['score']);

        return view('alternatives.result-mairca', ['scores' => $deviasi]);
    }
}
