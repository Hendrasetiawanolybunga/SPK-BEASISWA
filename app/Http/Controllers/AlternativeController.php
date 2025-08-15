<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Pemenang;
use App\Models\PemenangMairca;
use App\Models\PemenangMoora;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AlternativeController extends Controller
{
    private function mapCriteriaValue($criteriaName, $inputValue)
    {
        $lowerName = Str::lower($criteriaName);
        if (Str::contains($lowerName, 'prestasi akademik')) {
            switch ($inputValue) {
                case 'juara_olimpiade':
                    return 4;
                case 'juara_kelas':
                    return 3;
                case 'juara_lainnya':
                    return 2;
                case 'tidak_ada_akademik':
                    return 1;
                default:
                    return 0;
            }
        } elseif (Str::contains($lowerName, 'prestasi non-akademik')) {
            return ($inputValue == 'ada') ? 1 : 0;
        } elseif (Str::contains($lowerName, 'keterlibatan masyarakat')) {
            switch ($inputValue) {
                case 'ketua':
                    return 4;
                case 'pengurus':
                    return 3;
                case 'anggota':
                    return 2;
                case 'tidak_ada_keterlibatan':
                    return 1;
                default:
                    return 0;
            }
        } elseif (Str::contains($lowerName, 'kondisi ekonomi')) {
            switch ($inputValue) {
                case 'sangat_buruk':
                    return 5;
                case 'buruk':
                    return 4;
                case 'cukup':
                    return 3;
                case 'baik':
                    return 2;
                case 'sangat_baik':
                    return 1;
                default:
                    return 0;
            }
        } elseif (Str::contains($lowerName, 'penghasilan orang tua')) {
            switch ($inputValue) {
                case '<_1jt':
                    return 1;
                case '1jt_1.5jt':
                    return 2;
                case '1.5jt_2jt':
                    return 3;
                case '2jt_2.5jt':
                    return 4;
                case '2.5jt_3jt':
                    return 5;
                case '3jt_4jt':
                    return 6;
                case '4jt_5jt':
                    return 7;
                case '5jt_6jt':
                    return 8;
                case '6jt_8jt':
                    return 9;
                case '8jt_10jt':
                    return 10;
                case '>_10jt':
                    return 11;
                default:
                    return null;
            }
        } elseif (Str::contains($lowerName, ['domisili 3t', 'difabel'])) {
            return (int) $inputValue;
        } else {
            return (float) $inputValue;
        }
    }

    public function index()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();
        return view('alternatives.index', compact('alternatives', 'criterias'));
    }

    public function create()
    {
        $allCriterias = Criteria::all();
        $kondisiEkonomiCriteria = $allCriterias->firstWhere('name', 'Kondisi Ekonomi');
        $penghasilanOrtuCriteria = $allCriterias->firstWhere('name', 'Penghasilan Orang Tua');
        $otherCriterias = $allCriterias->filter(function ($criteria) {
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
                    if (!$criteria) {
                        continue;
                    }

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
        $kondisiEkonomiCriteria = $allCriterias->firstWhere(fn($c) => Str::lower($c->name) === 'kondisi ekonomi');
        $penghasilanOrtuCriteria = $allCriterias->firstWhere(fn($c) => Str::lower($c->name) === 'penghasilan orang tua');

        $otherCriterias = $allCriterias->filter(function ($criteria) {
            $lowerName = Str::lower($criteria->name);
            return !Str::contains($lowerName, ['kondisi ekonomi', 'penghasilan orang tua']);
        });

        if (!$kondisiEkonomiCriteria || !$penghasilanOrtuCriteria) {
            return redirect()->route('alternatives.index')->with('error', 'Kriteria wajib tidak ditemukan.');
        }

        return view('alternatives.edit', compact(
            'alternative',
            'kondisiEkonomiCriteria',
            'penghasilanOrtuCriteria',
            'otherCriterias'
        ));
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
                    if (!$criteria) {
                        continue;
                    }

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

    // =========================================================================
    // IMPLEMENTASI METODE PENGAMBILAN KEPUTUSAN (DENGAN DETAIL PROSES)
    // =========================================================================

    /**
     * Menghitung hasil Naive Bayes dan mengembalikan detail proses.
     */
    private function calculateBayes($alternatives, $criterias, $priorLayak = 0.5, $priorTidakLayak = 0.5, $smoothing = 1e-9)
    {
        $bayesScores = [];
        $layakAlternatives = [];
        $tidakLayakAlternatives = [];
        $detailPerhitungan = [];

        foreach ($alternatives as $alt) {
            $scores = $alt->scores->keyBy('criteria_id');
            $probGivenLayak = 1.0;
            $probGivenTidakLayak = 1.0;
            $isDataComplete = true;
            $stepDetails = ['alternative' => $alt->name, 'probabilities' => []];

            foreach ($criterias as $criteria) {
                if (!$scores->has($criteria->id)) {
                    $isDataComplete = false;
                    break;
                }
            }
            if (!$isDataComplete) {
                continue;
            }

            foreach ($criterias as $criteria) {
                $featureValue = $scores[$criteria->id]->value;
                $bayesProb = $criteria->bayes_probability;
                $p_feature_given_layak = 0.5;
                $p_feature_given_tidak_layak = 0.5;
                $lowerName = Str::lower($criteria->name);

                if (Str::contains($lowerName, 'prestasi akademik')) {
                    if ($featureValue >= 2) {
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'prestasi non-akademik')) {
                    if ($featureValue == 1) {
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'keterlibatan masyarakat')) {
                    if ($featureValue >= 2) {
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'kondisi ekonomi')) {
                    if ($featureValue == 5) {
                        $p_feature_given_layak = $bayesProb * 0.9;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.9);
                    } elseif ($featureValue == 4) {
                        $p_feature_given_layak = $bayesProb * 0.9;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.7);
                    } elseif ($featureValue == 3) {
                        $p_feature_given_layak = $bayesProb * 0.5;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.5);
                    } elseif ($featureValue == 2) {
                        $p_feature_given_layak = $bayesProb * 0.3;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.3);
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'penghasilan orang tua')) {
                    if ($featureValue == 1) {
                        $p_feature_given_layak = $bayesProb * 0.9;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.9);
                    } elseif ($featureValue == 2) {
                        $p_feature_given_layak = $bayesProb * 0.7;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.7);
                    } elseif ($featureValue == 3) {
                        $p_feature_given_layak = $bayesProb * 0.3;
                        $p_feature_given_tidak_layak = 1 - ($bayesProb * 0.3);
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'domisili 3t') || Str::contains($lowerName, 'difabel')) {
                    if ($featureValue == 1) {
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                } elseif (Str::contains($lowerName, 'jumlah tanggungan orang tua')) {
                    if ($featureValue >= 3) {
                        $p_feature_given_layak = $bayesProb;
                        $p_feature_given_tidak_layak = 1 - $bayesProb;
                    } else {
                        $p_feature_given_layak = 1 - $bayesProb;
                        $p_feature_given_tidak_layak = $bayesProb;
                    }
                }

                $probGivenLayak *= ($p_feature_given_layak + $smoothing);
                $probGivenTidakLayak *= ($p_feature_given_tidak_layak + $smoothing);

                $stepDetails['probabilities'][] = [
                    'criteria' => $criteria->name,
                    'value' => $featureValue,
                    'p_given_layak' => $p_feature_given_layak,
                    'p_given_tidak_layak' => $p_feature_given_tidak_layak
                ];
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

            $stepDetails['final_prob_layak'] = $finalProbLayak;
            $stepDetails['final_prob_tidak_layak'] = $finalProbTidakLayak;
            $stepDetails['keputusan'] = $keputusan;
            $detailPerhitungan[] = $stepDetails;

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
            'proses_lengkap' => $detailPerhitungan, // Menambahkan detail proses
        ];
    }

    /**
     * Menghitung hasil MOORA dan mengembalikan detail proses.
     */
    private function calculateMoora($alternatives, $criterias)
    {
        $matrix = [];
        $validAlternativesForMoora = [];
        $rawMatrix = [];

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
                $rawMatrix[$alt->name] = $row;
            }
        }

        if (empty($matrix)) {
            return ['rankings' => [], 'proses_lengkap' => []];
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
        $normalizedMatrix = [];
        foreach ($matrix as $i => $row) {
            $normRow = [];
            foreach ($row as $j => $val) {
                $normalizedValue = $denominators[$j] != 0 ? $val / $denominators[$j] : 0;
                $norm[$i][$j] = $normalizedValue;
                $normRow[] = $normalizedValue;
            }
            $normalizedMatrix[$validAlternativesForMoora[$i]->name] = $normRow;
        }

        $mooraScores = [];
        $finalScores = [];
        foreach ($norm as $i => $row) {
            $score = 0;
            $benefitScore = 0;
            $costScore = 0;
            foreach ($row as $j => $val) {
                $weight = $criterias[$j]->weight;
                if ($criterias[$j]->type === 'benefit') {
                    $benefitScore += $val * $weight;
                } else {
                    $costScore += $val * $weight;
                }
            }
            $score = $benefitScore - $costScore;
            $mooraScores[] = ['alt' => $validAlternativesForMoora[$i], 'score' => $score];
            $finalScores[$validAlternativesForMoora[$i]->name] = [
                'benefit_score' => $benefitScore,
                'cost_score' => $costScore,
                'final_score' => $score,
            ];
        }

        usort($mooraScores, fn($a, $b) => $b['score'] <=> $a['score']);

        // Simpan semua nama sesuai urutan ranking
        if (!empty($mooraScores)) {
            // Hapus data sebelumnya
            PemenangMoora::truncate();

            foreach ($mooraScores as $rank => $item) {
                PemenangMoora::create([
                    'name' => $item['alt']->name,
                ]);
            }
        }

        $prosesLengkap = [
            'raw_matrix' => $rawMatrix,
            'denominators' => $denominators,
            'normalized_matrix' => $normalizedMatrix,
            'final_scores' => $finalScores
        ];

        return [
            'rankings' => $mooraScores,
            'proses_lengkap' => $prosesLengkap, // Menambahkan detail proses
        ];
    }

    /**
     * Menghitung hasil MAIRCA dan mengembalikan detail proses.
     */
    private function calculateMairca($alternatives, $criterias)
    {
        $matrix = [];
        $validAlternatives = [];
        $rawMatrix = [];

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
                $validAlternatives[] = $alt;
                $matrix[] = $row;
                $rawMatrix[$alt->name] = $row;
            }
        }

        if (empty($matrix)) {
            return ['rankings' => [], 'proses_lengkap' => []];
        }

        $n = count($validAlternatives);
        $norm = [];
        $normalizedMatrix = [];

        foreach ($criterias as $j => $c) {
            $column = array_column($matrix, $j);
            $max = max($column);
            $min = min($column);

            foreach ($matrix as $i => $row) {
                $normalizedValue = 0;
                if ($c->type === 'benefit') {
                    $normalizedValue = $max != 0 ? $row[$j] / $max : 0;
                } else {
                    $normalizedValue = $row[$j] != 0 ? $min / $row[$j] : 0;
                }
                $norm[$i][$j] = $normalizedValue;
                $normalizedMatrix[$validAlternatives[$i]->name][$c->name] = $normalizedValue;
            }
        }

        $Q = [];
        $idealWeights = [];
        foreach ($validAlternatives as $i => $alt) {
            foreach ($criterias as $j => $c) {
                $idealWeight = $c->weight / $n;
                $Q[$i][$j] = $idealWeight;
                $idealWeights[$alt->name][$c->name] = $idealWeight;
            }
        }

        $deviation = [];
        $finalScores = [];
        foreach ($norm as $i => $row) {
            $total = 0;
            $deviationDetails = [];
            foreach ($row as $j => $val) {
                $diff = abs($Q[$i][$j] - $val);
                $total += $diff;
                $deviationDetails[$criterias[$j]->name] = $diff;
            }
            $deviation[] = ['alt' => $validAlternatives[$i], 'score' => $total];
            $finalScores[$validAlternatives[$i]->name] = [
                'deviation_details' => $deviationDetails,
                'final_deviation' => $total
            ];
        }

        usort($deviation, fn($a, $b) => $a['score'] <=> $b['score']);

        // Simpan semua nama sesuai urutan ranking
        if (!empty($deviation)) {
            // Hapus data sebelumnya
            PemenangMairca::truncate();

            foreach ($deviation as $rank => $item) {
                PemenangMairca::create([
                    'name' => $item['alt']->name,
                ]);
            }
        }

        $prosesLengkap = [
            'raw_matrix' => $rawMatrix,
            'normalized_matrix' => $normalizedMatrix,
            'ideal_weights' => $idealWeights,
            'final_scores' => $finalScores
        ];

        return [
            'rankings' => $deviation,
            'proses_lengkap' => $prosesLengkap, // Menambahkan detail proses
        ];
    }

    /**
     * Menampilkan hasil kombinasi Naive Bayes (sebagai filtering) dan MOORA (sebagai ranking).
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
                'bayesProses' => [],
                'mooraProses' => [],
                'criterias' => collect([]),
            ]);
        }

        $bayesOutput = $this->calculateBayes($alternatives, $criterias);
        $layakAlternatives = $bayesOutput['layak_alternatives'];
        $mooraOutput = $this->calculateMoora($layakAlternatives, $criterias);

        return view('alternatives.result-bayes-moora', [
            'bayesResults' => $bayesOutput['bayes_scores'],
            'mooraRankings' => $mooraOutput['rankings'],
            'totalAlternatives' => $alternatives->count(),
            'layakCount' => $layakAlternatives->count(),
            'tidakLayakCount' => $bayesOutput['tidak_layak_alternatives']->count(),
            'layakAlternatives' => $layakAlternatives,
            'tidakLayakAlternatives' => $bayesOutput['tidak_layak_alternatives'],
            'bayesProses' => $bayesOutput['proses_lengkap'],
            'mooraProses' => $mooraOutput['proses_lengkap'],
            'criterias' => $criterias,
        ]);
    }

    /**
     * Menampilkan hasil kombinasi Naive Bayes (sebagai filtering) dan MAIRCA (sebagai ranking).
     *
     * @return \Illuminate\View\View
     */
    public function result_bayes_mairca()
    {
        $criterias = Criteria::all();
        $alternatives = Alternative::with('scores')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return view('alternatives.result-bayes-mairca', [
                'bayesResults' => [],
                'maircaRankings' => [],
                'totalAlternatives' => 0,
                'layakCount' => 0,
                'tidakLayakCount' => 0,
                'layakAlternatives' => collect([]),
                'tidakLayakAlternatives' => collect([]),
                'bayesProses' => [],
                'maircaProses' => [],
                'criterias' => collect([]),
            ]);
        }

        $bayesOutput = $this->calculateBayes($alternatives, $criterias);
        $layakAlternatives = $bayesOutput['layak_alternatives'];
        $maircaOutput = $this->calculateMairca($layakAlternatives, $criterias);

        return view('alternatives.result-bayes-mairca', [
            'bayesResults' => $bayesOutput['bayes_scores'],
            'maircaRankings' => $maircaOutput['rankings'],
            'totalAlternatives' => $alternatives->count(),
            'layakCount' => $layakAlternatives->count(),
            'tidakLayakCount' => $bayesOutput['tidak_layak_alternatives']->count(),
            'layakAlternatives' => $layakAlternatives,
            'tidakLayakAlternatives' => $bayesOutput['tidak_layak_alternatives'],
            'bayesProses' => $bayesOutput['proses_lengkap'],
            'maircaProses' => $maircaOutput['proses_lengkap'],
            'criterias' => $criterias,
        ]);
    }

    /**
     * Menampilkan halaman cetak hasil analisis beasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function printResults()
    {
        $criterias = Criteria::all();
        $alternatives = Alternative::with('scores')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return view('alternatives.print-results', [
                'mooraRankings' => [],
                'maircaRankings' => [],
            ]);
        }

        // Hitung hasil Bayes untuk mendapatkan alternatif yang layak
        $bayesOutput = $this->calculateBayes($alternatives, $criterias);
        $layakAlternatives = $bayesOutput['layak_alternatives'];

        // Hitung hasil MOORA dan MAIRCA untuk alternatif yang layak
        $mooraOutput = $this->calculateMoora($layakAlternatives, $criterias);
        $maircaOutput = $this->calculateMairca($layakAlternatives, $criterias);

        return view('alternatives.print-results', [
            'mooraRankings' => $mooraOutput['rankings'],
            'maircaRankings' => $maircaOutput['rankings'],
            'mooraProses' => $mooraOutput['proses_lengkap'],
            'maircaProses' => $maircaOutput['proses_lengkap'],
            'criterias' => $criterias,
        ]);
    }
}
