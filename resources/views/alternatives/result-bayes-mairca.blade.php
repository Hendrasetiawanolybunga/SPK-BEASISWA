@extends('layouts.app')

@section('title', 'Hasil Kombinasi Bayes - MAIRCA')

@section('content')
<div class="container my-4">
    <!-- Intro Section with Explanation -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 bg-light shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="display-6 fw-bold"><i class="fas fa-brain me-2 text-primary"></i>Hasil Analisis Beasiswa</h1>
                        <a href="{{ route('alternatives.print-results') }}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Cetak Laporan PDF
                        </a>
                    </div>
                    <p class="lead mb-0">Halaman ini menampilkan hasil analisis kelayakan beasiswa menggunakan kombinasi dua metode:</p>
                    <div class="d-flex flex-wrap mt-3 gap-3">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-3 flex-grow-1">
                            <h5 class="fw-bold text-primary"><i class="fas fa-filter me-2"></i>Naive Bayes</h5>
                            <p class="mb-0">Metode ini <strong>memfilter kandidat</strong> berdasarkan probabilitas kelayakan dari data historis.</p>
                        </div>
                        <div class="p-3 bg-warning bg-opacity-10 rounded-3 flex-grow-1">
                            <h5 class="fw-bold text-warning"><i class="fas fa-sort-amount-up me-2"></i>MAIRCA</h5>
                            <p class="mb-0">Metode ini <strong>mengurutkan kandidat yang layak</strong> berdasarkan perhitungan multi-kriteria.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-4 text-center">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                        <div class="p-3">
                            <h6 class="text-muted mb-1">Total Kandidat</h6>
                            <h2 class="fw-bold mb-0">{{ $totalAlternatives }}</h2>
                            <p class="small text-muted mb-0">Jumlah seluruh kandidat beasiswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-4 text-center">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div class="p-3">
                            <h6 class="text-muted mb-1">Kandidat Layak</h6>
                            <h2 class="fw-bold mb-0">{{ $layakCount }}</h2>
                            <p class="small text-muted mb-0">Kandidat yang memenuhi syarat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 p-4 text-center">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                        <div class="p-3">
                            <h6 class="text-muted mb-1">Kandidat Tidak Layak</h6>
                            <h2 class="fw-bold mb-0">{{ $tidakLayakCount }}</h2>
                            <p class="small text-muted mb-0">Kandidat yang belum memenuhi syarat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Naive Bayes --}}
    <section class="mb-5">
        <div class="card border-0 bg-primary bg-opacity-10 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3"><i class="fas fa-filter me-2 text-primary"></i>Hasil <span class="text-primary">Naive Bayes</span></h2>
                <p class="lead mb-0">Metode <strong>Naive Bayes</strong> digunakan untuk memfilter kandidat berdasarkan probabilitas kelayakan. Metode ini menggunakan data historis untuk memprediksi apakah seorang kandidat layak atau tidak layak menerima beasiswa.</p>
            </div>
        </div>

        @if(count($bayesResults) > 0)
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Hasil Perhitungan Probabilitas Kandidat</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3"><i class="fas fa-user me-1"></i> Alternatif</th>
                                <th class="py-3"><i class="fas fa-arrow-up text-success me-1"></i> Probabilitas Layak</th>
                                <th class="py-3"><i class="fas fa-arrow-down text-danger me-1"></i> Probabilitas Tidak Layak</th>
                                <th class="py-3"><i class="fas fa-gavel text-primary me-1"></i> Keputusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bayesResults as $result)
                            <tr class="{{ $result['keputusan'] == 'LAYAK' ? 'table-success' : 'table-danger' }} bg-opacity-10">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle {{ $result['keputusan'] == 'LAYAK' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-user {{ $result['keputusan'] == 'LAYAK' ? 'text-success' : 'text-danger' }}"></i>
                                        </div>
                                        <strong>{{ $result['alt']->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width: {{ $result['score_layak'] * 100 }}%" 
                                                aria-valuenow="{{ $result['score_layak'] * 100 }}" 
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ number_format($result['score_layak'], 6) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-danger" role="progressbar" 
                                                style="width: {{ $result['score_tidak_layak'] * 100 }}%" 
                                                aria-valuenow="{{ $result['score_tidak_layak'] * 100 }}" 
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{ number_format($result['score_tidak_layak'], 6) }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($result['keputusan'] == 'LAYAK')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>LAYAK
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                            <i class="fas fa-times-circle me-1"></i>TIDAK LAYAK
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-primary bg-opacity-10 p-3">
                <h3 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>Detail Proses Perhitungan Bayes</h3>
                <p class="text-muted mb-0 mt-2">Berikut adalah detail perhitungan probabilitas untuk setiap alternatif menggunakan metode Naive Bayes.</p>
            </div>
            <div class="card-body p-4">
                <div class="accordion" id="bayesProcessAccordion">
                    @foreach($bayesProses as $index => $process)
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="headingBayes{{$index}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBayes{{$index}}" aria-expanded="false" aria-controls="collapseBayes{{$index}}">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div>
                                        <i class="fas fa-user-circle fa-fw me-2 {{ $process['keputusan'] === 'LAYAK' ? 'text-success' : 'text-danger' }}"></i>
                                        <span class="fw-bold">{{ $process['alternative'] }}</span>
                                    </div>
                                    <div class="ms-auto d-flex align-items-center">
                                        <span class="badge {{ $process['keputusan'] === 'LAYAK' ? 'bg-success' : 'bg-danger' }} me-3">
                                            {{ $process['keputusan'] }}
                                        </span>
                                        <div class="d-none d-md-flex align-items-center">
                                            <small class="text-muted me-2">P(Layak):</small>
                                            <div class="progress" style="width: 100px; height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $process['final_prob_layak'] * 100 }}%" aria-valuenow="{{ $process['final_prob_layak'] * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseBayes{{$index}}" class="accordion-collapse collapse" aria-labelledby="headingBayes{{$index}}" data-bs-parent="#bayesProcessAccordion">
                            <div class="accordion-body bg-white">
                                <div class="table-responsive mb-4">
                                    <table class="table table-sm table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th><i class="fas fa-balance-scale text-primary me-1"></i> Kriteria</th>
                                                <th><i class="fas fa-calculator text-primary me-1"></i> Nilai</th>
                                                <th>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-check-circle text-success me-1"></i>
                                                        <span>P(Feature|Layak)</span>
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-times-circle text-danger me-1"></i>
                                                        <span>P(Feature|Tidak Layak)</span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($process['probabilities'] as $prob)
                                            <tr>
                                                <td class="fw-medium">{{ $prob['criteria'] }}</td>
                                                <td>{{ $prob['value'] }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $prob['p_given_layak'] * 100 }}%" aria-valuenow="{{ $prob['p_given_layak'] * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span>{{ number_format($prob['p_given_layak'], 6) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $prob['p_given_tidak_layak'] * 100 }}%" aria-valuenow="{{ $prob['p_given_tidak_layak'] * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span>{{ number_format($prob['p_given_tidak_layak'], 6) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="row g-3 mb-2">
                                    <div class="col-md-6">
                                        <div class="card h-100 border-0 bg-success bg-opacity-10 rounded-3">
                                            <div class="card-body p-3">
                                                <h5 class="card-title text-success"><i class="fas fa-check-circle me-2"></i>Probabilitas Layak</h5>
                                                <div class="progress mb-2" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $process['final_prob_layak'] * 100 }}%" aria-valuenow="{{ $process['final_prob_layak'] * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <p class="h4 fw-bold text-success mb-0">{{ number_format($process['final_prob_layak'], 6) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100 border-0 bg-danger bg-opacity-10 rounded-3">
                                            <div class="card-body p-3">
                                                <h5 class="card-title text-danger"><i class="fas fa-times-circle me-2"></i>Probabilitas Tidak Layak</h5>
                                                <div class="progress mb-2" style="height: 10px;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $process['final_prob_tidak_layak'] * 100 }}%" aria-valuenow="{{ $process['final_prob_tidak_layak'] * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <p class="h4 fw-bold text-danger mb-0">{{ number_format($process['final_prob_tidak_layak'], 6) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert {{ $process['keputusan'] === 'LAYAK' ? 'alert-success' : 'alert-danger' }} mt-4 mb-0">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-white p-2 me-3">
                                            <i class="fas fa-gavel {{ $process['keputusan'] === 'LAYAK' ? 'text-success' : 'text-danger' }}"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0">Kesimpulan: {{ $process['keputusan'] }}</h5>
                                            <p class="mb-0 mt-1">
                                                @if($process['keputusan'] === 'LAYAK')
                                                Berdasarkan perhitungan probabilitas, alternatif ini <strong>memenuhi syarat</strong> untuk dipertimbangkan dalam perankingan MAIRCA.
                                                @else
                                                Berdasarkan perhitungan probabilitas, alternatif ini <strong>tidak memenuhi syarat</strong> untuk dipertimbangkan dalam perankingan MAIRCA.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <p class="text-muted fs-5"><i class="fas fa-info-circle me-2"></i>Belum ada data hasil Naive Bayes.</p>
        @endif
    </section>

    <hr class="my-5">

    {{-- Bagian MAIRCA --}}
    <section>
        <div class="card border-0 bg-warning bg-opacity-10 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3"><i class="fas fa-sort-amount-up me-2 text-warning"></i>Ranking <span class="text-warning">MAIRCA</span></h2>
                <p class="mb-0">Metode MAIRCA (Multi-Attributive Ideal-Real Comparative Analysis) mengurutkan alternatif yang telah dinyatakan layak oleh Naive Bayes. Semakin kecil nilai deviasi, semakin baik peringkat alternatif.</p>
            </div>
        </div>

        @if(count($maircaRankings) > 0)
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 100px;"><i class="fas fa-trophy me-1"></i> Ranking</th>
                                <th><i class="fas fa-user me-1"></i> Alternatif</th>
                                <th><i class="fas fa-chart-line me-1"></i> Skor Deviasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $rankNo = 1; @endphp
                            @foreach($maircaRankings as $ranking)
                            <tr class="{{ $rankNo <= 3 ? 'table-warning bg-opacity-25' : '' }}">
                                <td class="text-center">
                                    @if($rankNo == 1)
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="fas fa-crown me-1"></i> {{ $rankNo++ }}</span>
                                    @elseif($rankNo <= 3)
                                        <span class="badge bg-info text-dark rounded-pill px-3 py-2">{{ $rankNo++ }}</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $rankNo++ }}</span>
                                    @endif
                                </td>
                                <td><strong>{{ $ranking['alt']->name }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" role="progressbar" 
                                                style="width: {{ min(($ranking['score'] * 100), 100) }}%" 
                                                aria-valuenow="{{ $ranking['score'] * 100 }}" 
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-nowrap">{{ number_format($ranking['score'], 6) }}</span>
                                    </div>
                                    <small class="text-muted">Semakin kecil nilai, semakin baik peringkat</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-warning bg-opacity-10 p-3">
                <h3 class="mb-0"><i class="fas fa-book-reader me-2 text-warning"></i>Detail Proses Perhitungan MAIRCA</h3>
                <p class="text-muted mb-0 mt-2">Berikut adalah detail perhitungan untuk metode MAIRCA yang digunakan untuk menentukan peringkat alternatif.</p>
            </div>
            <div class="card-body p-4">
                <div class="accordion" id="maircaProcessAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="headingRawMatrix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRawMatrix" aria-expanded="false" aria-controls="collapseRawMatrix">
                                <i class="fas fa-th-list me-2 text-warning"></i>
                                <span class="fw-bold">Raw Matrix</span>
                            </button>
                        </h2>
                        <div id="collapseRawMatrix" class="accordion-collapse collapse" aria-labelledby="headingRawMatrix" data-bs-parent="#maircaProcessAccordion">
                            <div class="accordion-body bg-white">
                                <p class="text-muted mb-3">Matriks awal berisi nilai asli dari setiap alternatif untuk setiap kriteria sebelum normalisasi.</p>
                                
                                @php
                                    // Extract criteria names from the first alternative (if available)
                                    $criteriaNames = [];
                                    if (!empty($maircaProses['raw_matrix'])) {
                                        $firstAlt = array_key_first($maircaProses['raw_matrix']);
                                        $criteriaCount = count($maircaProses['raw_matrix'][$firstAlt]);
                                        
                                        // First try to get criteria names directly from the matrix data
                                        // This is more reliable as it matches the actual data being displayed
                                        if (isset($criterias) && $criterias->isNotEmpty()) {
                                            // Create a map of criteria IDs to names for easier lookup
                                            $criteriaMap = $criterias->pluck('name', 'id')->toArray();
                                            
                                            // Get criteria names based on the order they appear in the calculation
                                            // This assumes the criteria are in the same order as in the matrix
                                            $i = 0;
                                            foreach($criterias as $criteria) {
                                                if ($i < $criteriaCount) {
                                                    $criteriaNames[] = $criteria->name;
                                                    $i++;
                                                }
                                            }
                                        }
                                        
                                        // If we couldn't get names from the database, use generic names
                                        if (empty($criteriaNames)) {
                                            for ($i = 0; $i < $criteriaCount; $i++) {
                                                $criteriaNames[] = 'Kriteria ' . ($i + 1);
                                            }
                                        }
                                    }
                                @endphp
                                
                                <x-matrix-table 
                                    title="Raw Matrix" 
                                    description="Nilai asli dari setiap alternatif untuk setiap kriteria" 
                                    :matrix="$maircaProses['raw_matrix']" 
                                    :criteria_names="$criteriaNames" 
                                />
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="headingNormalizedMatrix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNormalizedMatrix" aria-expanded="false" aria-controls="collapseNormalizedMatrix">
                                <i class="fas fa-balance-scale me-2 text-warning"></i>
                                <span class="fw-bold">Normalized Matrix</span>
                            </button>
                        </h2>
                        <div id="collapseNormalizedMatrix" class="accordion-collapse collapse" aria-labelledby="headingNormalizedMatrix" data-bs-parent="#maircaProcessAccordion">
                            <div class="accordion-body bg-white">
                                <p class="text-muted mb-3">Matriks yang telah dinormalisasi untuk menyamakan skala nilai dari berbagai kriteria.</p>
                                
                                <x-matrix-table 
                                    title="Normalized Matrix" 
                                    description="Nilai yang telah dinormalisasi untuk menyamakan skala" 
                                    :matrix="$maircaProses['normalized_matrix']" 
                                    :criteria_names="$criteriaNames" 
                                />
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="headingIdealWeights">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIdealWeights" aria-expanded="false" aria-controls="collapseIdealWeights">
                                <i class="fas fa-weight-hanging me-2 text-warning"></i>
                                <span class="fw-bold">Ideal Weights</span>
                            </button>
                        </h2>
                        <div id="collapseIdealWeights" class="accordion-collapse collapse" aria-labelledby="headingIdealWeights" data-bs-parent="#maircaProcessAccordion">
                            <div class="accordion-body bg-white">
                                <p class="text-muted mb-3">Bobot ideal yang digunakan untuk menghitung deviasi dari setiap alternatif.</p>
                                
                                <x-ideal-weights-table 
                                    title="Ideal Weights" 
                                    description="Bobot ideal untuk setiap kriteria dan alternatif" 
                                    :weights="$maircaProses['ideal_weights']" 
                                    :criteria_names="$criteriaNames" 
                                />
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="headingFinalScores">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFinalScores" aria-expanded="false" aria-controls="collapseFinalScores">
                                <i class="fas fa-chart-bar me-2 text-warning"></i>
                                <span class="fw-bold">Final Scores (Deviasi)</span>
                            </button>
                        </h2>
                        <div id="collapseFinalScores" class="accordion-collapse collapse" aria-labelledby="headingFinalScores" data-bs-parent="#maircaProcessAccordion">
                            <div class="accordion-body bg-white">
                                <p class="text-muted mb-3">Skor akhir yang menunjukkan deviasi setiap alternatif dari nilai ideal. Semakin kecil nilai deviasi, semakin baik peringkat alternatif.</p>
                                
                                <x-final-scores-table 
                                    title="Final Scores (Deviasi)" 
                                    description="Skor akhir yang menentukan peringkat alternatif" 
                                    :scores="$maircaProses['final_scores']" 
                                    method="mairca" 
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-body p-4 text-center">
                <div class="py-5">
                    <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                    <h4 class="fw-bold text-muted">Belum Ada Data</h4>
                    <p class="text-muted mb-0">Belum ada data untuk perhitungan MAIRCA, atau semua alternatif tidak layak berdasarkan hasil filtering Naive Bayes.</p>
                </div>
            </div>
        </div>
        @endif
    </section>
</div>
@endsection
