@extends('layouts.app')

@section('title', 'Hasil Kombinasi Bayes - MOORA')

@section('content')
<div class="container my-4">
    <h1 class="mb-4"><i class="fas fa-brain me-2"></i>Hasil Kombinasi <span class="text-primary">Naive Bayes</span> dan <span class="text-success">MOORA</span></h1>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-th-list fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title mb-0">Total Alternatif</h5>
                        <p class="card-text fs-4 fw-bold">{{ $totalAlternatives }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title mb-0">Alternatif <span class="badge bg-light text-success">Layak</span></h5>
                        <p class="card-text fs-4 fw-bold">{{ $layakCount }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-times-circle fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title mb-0">Alternatif <span class="badge bg-light text-danger">Tidak Layak</span></h5>
                        <p class="card-text fs-4 fw-bold">{{ $tidakLayakCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Naive Bayes --}}
    <section class="mb-5">
        <h2 class="mb-3"><i class="fas fa-filter me-2"></i>Hasil <span class="text-primary">Naive Bayes</span> (Filtering)</h2>
        @if(count($bayesResults) > 0)
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-user"></i> Alternatif</th>
                        <th><i class="fas fa-arrow-up"></i> Probabilitas Layak</th>
                        <th><i class="fas fa-arrow-down"></i> Probabilitas Tidak Layak</th>
                        <th><i class="fas fa-gavel"></i> Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bayesResults as $result)
                    <tr>
                        <td><i class="fas fa-user-check text-primary me-1"></i>{{ $result['alt']->name }}</td>
                        <td>{{ number_format($result['score_layak'], 6) }}</td>
                        <td>{{ number_format($result['score_tidak_layak'], 6) }}</td>
                        <td>
                            @if($result['keputusan'] == 'LAYAK')
                                <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>LAYAK</span>
                            @else
                                <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i>TIDAK LAYAK</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3 class="mt-5"><i class="fas fa-book-open me-2"></i>Detail Proses Perhitungan Bayes</h3>
        <div class="accordion" id="bayesProcessAccordion">
            @foreach($bayesProses as $index => $process)
            <div class="accordion-item shadow-sm mb-2 rounded">
                <h2 class="accordion-header" id="headingBayes{{$index}}">
                    <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBayes{{$index}}" aria-expanded="false" aria-controls="collapseBayes{{$index}}">
                        <i class="fas fa-user fa-fw me-2"></i>Alternatif {{ $process['alternative'] }}
                    </button>
                </h2>
                <div id="collapseBayes{{$index}}" class="accordion-collapse collapse" aria-labelledby="headingBayes{{$index}}" data-bs-parent="#bayesProcessAccordion">
                    <div class="accordion-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-3 align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th><i class="fas fa-balance-scale"></i> Kriteria</th>
                                        <th><i class="fas fa-calculator"></i> Nilai</th>
                                        <th><i class="fas fa-percent"></i> P(Feature|Layak)</th>
                                        <th><i class="fas fa-percent"></i> P(Feature|Tidak Layak)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($process['probabilities'] as $prob)
                                    <tr>
                                        <td>{{ $prob['criteria'] }}</td>
                                        <td>{{ $prob['value'] }}</td>
                                        <td>{{ number_format($prob['p_given_layak'], 6) }}</td>
                                        <td>{{ number_format($prob['p_given_tidak_layak'], 6) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="badge bg-primary fs-6 p-3 flex-grow-1">
                                <i class="fas fa-check-circle me-2"></i>
                                Final P(Layak): <strong>{{ number_format($process['final_prob_layak'], 6) }}</strong>
                            </div>
                            <div class="badge bg-warning text-dark fs-6 p-3 flex-grow-1">
                                <i class="fas fa-times-circle me-2"></i>
                                Final P(Tidak Layak): <strong>{{ number_format($process['final_prob_tidak_layak'], 6) }}</strong>
                            </div>
                            <div class="badge {{ $process['keputusan'] === 'LAYAK' ? 'bg-success' : 'bg-danger' }} fs-6 p-3 flex-grow-1">
                                <i class="fas fa-gavel me-2"></i>
                                Keputusan: <strong>{{ $process['keputusan'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted fs-5"><i class="fas fa-info-circle me-2"></i>Belum ada data hasil Naive Bayes.</p>
        @endif
    </section>

    <hr>

    {{-- Bagian MOORA --}}
    <section>
        <h2 class="mb-3"><i class="fas fa-tasks me-2"></i>Ranking <span class="text-success">MOORA</span> (Hanya Alternatif Layak)</h2>

        @if(count($mooraRankings) > 0)
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-striped table-hover align-middle mb-4">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-sort-numeric-down"></i> Ranking</th>
                        <th><i class="fas fa-user"></i> Alternatif</th>
                        <th><i class="fas fa-plus-circle"></i> Benefit Score</th>
                        <th><i class="fas fa-minus-circle"></i> Cost Score</th>
                        <th><i class="fas fa-equals"></i> Final Score</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rankNo = 1; @endphp
                    @foreach($mooraRankings as $ranking)
                    @php
                        $altName = $ranking['alt']->name;
                        $finalScores = $mooraProses['final_scores'][$altName] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $rankNo++ }}</td>
                        <td>{{ $altName }}</td>
                        <td>{{ isset($finalScores) ? number_format($finalScores['benefit_score'], 6) : '-' }}</td>
                        <td>{{ isset($finalScores) ? number_format($finalScores['cost_score'], 6) : '-' }}</td>
                        <td>{{ isset($finalScores) ? number_format($finalScores['final_score'], 6) : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3 class="mb-3"><i class="fas fa-book-reader me-2"></i>Detail Proses Perhitungan MOORA</h3>

        <div class="row g-3">
            <div class="col-md-6">
                <h5><i class="fas fa-th-list me-1"></i> Raw Matrix</h5>
                <pre class="bg-light p-3 rounded shadow-sm" style="max-height:300px; overflow:auto;">{{ print_r($mooraProses['raw_matrix'], true) }}</pre>
            </div>
            <div class="col-md-6">
                <h5><i class="fas fa-calculator me-1"></i> Denominators (Root of Sum of Squares)</h5>
                <pre class="bg-light p-3 rounded shadow-sm" style="max-height:300px; overflow:auto;">{{ print_r($mooraProses['denominators'], true) }}</pre>
            </div>
            <div class="col-md-6">
                <h5><i class="fas fa-balance-scale me-1"></i> Normalized Matrix</h5>
                <pre class="bg-light p-3 rounded shadow-sm" style="max-height:300px; overflow:auto;">{{ print_r($mooraProses['normalized_matrix'], true) }}</pre>
            </div>
            <div class="col-md-6">
                <h5><i class="fas fa-star me-1"></i> Final Scores</h5>
                <pre class="bg-light p-3 rounded shadow-sm" style="max-height:300px; overflow:auto;">{{ print_r($mooraProses['final_scores'], true) }}</pre>
            </div>
        </div>

        @else
        <p class="text-muted fs-5"><i class="fas fa-info-circle me-2"></i>Belum ada data untuk perhitungan MOORA, atau semua alternatif tidak layak.</p>
        @endif
    </section>
</div>
@endsection
