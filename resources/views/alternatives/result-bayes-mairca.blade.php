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

   

        <!-- Dashboard Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Total Kandidat</h5>
                        </div>
                        <p class="display-6 fw-bold text-info mb-0">{{ $totalAlternatives }}</p>
                        <p class="text-muted small mb-0">Jumlah total kandidat yang dianalisis</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Kandidat Layak</h5>
                        </div>
                        <p class="display-6 fw-bold text-success mb-0">{{ $layakCount }}</p>
                        <p class="text-muted small mb-0">Kandidat yang memenuhi kriteria kelayakan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Kandidat Tidak Layak</h5>
                        </div>
                        <p class="display-6 fw-bold text-danger mb-0">{{ $tidakLayakCount }}</p>
                        <p class="text-muted small mb-0">Kandidat yang belum memenuhi kriteria</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Naive Bayes --}}
        <section class="mb-5">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary p-2 me-3">
                            <i class="fas fa-filter text-white"></i>
                        </div>
                        <h2 class="h4 fw-bold text-primary mb-0">Tahap 1: Penyaringan Kandidat dengan Naive Bayes</h2>
                    </div>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Metode Naive Bayes menganalisis data historis untuk menentukan probabilitas
                        kelayakan setiap kandidat berdasarkan kriteria yang telah ditetapkan.</p>

                    @if (count($bayesResults) > 0)
                        <div class="table-responsive rounded">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0"><i class="fas fa-user text-primary me-2"></i>Nama Kandidat</th>
                                        <th class="border-0 text-center"><i
                                                class="fas fa-check-circle text-success me-2"></i>Probabilitas Layak</th>
                                        <th class="border-0 text-center"><i
                                                class="fas fa-times-circle text-danger me-2"></i>Probabilitas Tidak Layak
                                        </th>
                                        <th class="border-0 text-center"><i class="fas fa-award me-2"></i>Hasil Penyaringan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bayesResults as $result)
                                        <tr
                                            class="@if ($result['keputusan'] == 'LAYAK') border-start border-success border-5 @else border-start border-danger border-5 @endif">
                                            <td class="fw-medium">{{ $result['alt']->name }}</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $result['score_layak'] * 100 }}%"
                                                            aria-valuenow="{{ $result['score_layak'] * 100 }}"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span
                                                        class="ms-2 text-success fw-bold">{{ number_format($result['score_layak'], 4) }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="progress flex-grow-1" style="height: 8px;">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: {{ $result['score_tidak_layak'] * 100 }}%"
                                                            aria-valuenow="{{ $result['score_tidak_layak'] * 100 }}"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span
                                                        class="ms-2 text-danger fw-bold">{{ number_format($result['score_tidak_layak'], 4) }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($result['keputusan'] == 'LAYAK')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-medium"><i
                                                            class="fas fa-check-circle me-1"></i>Layak</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-medium"><i
                                                            class="fas fa-times-circle me-1"></i>Tidak Layak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-calculator text-primary"></i>
                                </div>
                                <h3 class="h5 fw-bold mb-0">Detail Perhitungan Naive Bayes</h3>
                            </div>
                            <p class="text-muted mb-4">Berikut adalah rincian perhitungan probabilitas untuk setiap kandidat
                                berdasarkan kriteria yang telah ditetapkan.</p>
                        </div>

                        <div class="accordion" id="bayesProcessAccordion">
                            @foreach ($bayesProses as $index => $process)
                                <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                                    <h2 class="accordion-header" id="headingBayes{{ $index }}">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseBayes{{ $index }}"
                                            aria-expanded="false" aria-controls="collapseBayes{{ $index }}">
                                            <div class="d-flex align-items-center w-100">
                                                <div
                                                    class="rounded-circle {{ $process['keputusan'] === 'LAYAK' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 p-2 me-3">
                                                    <i
                                                        class="fas fa-user {{ $process['keputusan'] === 'LAYAK' ? 'text-success' : 'text-danger' }}"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium">{{ $process['alternative'] }}</span>
                                                    <span
                                                        class="ms-2 badge {{ $process['keputusan'] === 'LAYAK' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $process['keputusan'] === 'LAYAK' ? 'text-success' : 'text-danger' }} rounded-pill">{{ $process['keputusan'] }}</span>
                                                </div>
                                                <div class="d-none d-md-flex align-items-center">
                                                    <div class="me-4">
                                                        <small class="text-muted d-block">Probabilitas Layak</small>
                                                        <span
                                                            class="fw-bold text-success">{{ number_format($process['final_prob_layak'], 4) }}</span>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Probabilitas Tidak Layak</small>
                                                        <span
                                                            class="fw-bold text-danger">{{ number_format($process['final_prob_tidak_layak'], 4) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapseBayes{{ $index }}" class="accordion-collapse collapse"
                                        aria-labelledby="headingBayes{{ $index }}"
                                        data-bs-parent="#bayesProcessAccordion">
                                        <div class="accordion-body bg-white">
                                            <div class="alert alert-light border-0 rounded-3 mb-4">
                                                <h5 class="fw-bold mb-3"><i
                                                        class="fas fa-info-circle text-primary me-2"></i>Bagaimana Naive
                                                    Bayes Bekerja?</h5>
                                                <p class="mb-0">Metode ini menghitung probabilitas setiap kriteria
                                                    berdasarkan data historis, kemudian mengkombinasikannya untuk menentukan
                                                    kelayakan kandidat.</p>
                                            </div>

                                            <div class="table-responsive rounded">
                                                <table class="table table-sm table-hover mb-3 align-middle">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="border-0"><i
                                                                    class="fas fa-tag text-primary me-1"></i> Kriteria</th>
                                                            <th class="border-0 text-center"><i
                                                                    class="fas fa-list-ol text-primary me-1"></i> Nilai
                                                            </th>
                                                            <th class="border-0 text-center"><i
                                                                    class="fas fa-check-circle text-success me-1"></i>
                                                                Probabilitas Jika Layak</th>
                                                            <th class="border-0 text-center"><i
                                                                    class="fas fa-times-circle text-danger me-1"></i>
                                                                Probabilitas Jika Tidak Layak</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($process['probabilities'] as $prob)
                                                            <tr>
                                                                <td class="fw-medium">{{ $prob['criteria'] }}</td>
                                                                <td class="text-center">{{ $prob['value'] }}</td>
                                                                <td class="text-center">
                                                                    <div class="progress" style="height: 6px;">
                                                                        <div class="progress-bar bg-success"
                                                                            role="progressbar"
                                                                            style="width: {{ $prob['p_given_layak'] * 100 }}%"
                                                                            aria-valuenow="{{ $prob['p_given_layak'] * 100 }}"
                                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <small
                                                                        class="d-block mt-1">{{ number_format($prob['p_given_layak'], 4) }}</small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="progress" style="height: 6px;">
                                                                        <div class="progress-bar bg-danger"
                                                                            role="progressbar"
                                                                            style="width: {{ $prob['p_given_tidak_layak'] * 100 }}%"
                                                                            aria-valuenow="{{ $prob['p_given_tidak_layak'] * 100 }}"
                                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <small
                                                                        class="d-block mt-1">{{ number_format($prob['p_given_tidak_layak'], 4) }}</small>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row g-3 mt-2">
                                                <div class="col-md-6">
                                                    <div class="card h-100 border-0 bg-success bg-opacity-10 rounded-3">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                                <h5 class="fw-bold text-success mb-0">Probabilitas Layak
                                                                </h5>
                                                            </div>
                                                            <div class="progress mb-2" style="height: 10px;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: {{ $process['final_prob_layak'] * 100 }}%"
                                                                    aria-valuenow="{{ $process['final_prob_layak'] * 100 }}"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <p class="h4 fw-bold text-success mb-0">
                                                                {{ number_format($process['final_prob_layak'], 6) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card h-100 border-0 bg-danger bg-opacity-10 rounded-3">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-times-circle text-danger me-2"></i>
                                                                <h5 class="fw-bold text-danger mb-0">Probabilitas Tidak
                                                                    Layak</h5>
                                                            </div>
                                                            <div class="progress mb-2" style="height: 10px;">
                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                    style="width: {{ $process['final_prob_tidak_layak'] * 100 }}%"
                                                                    aria-valuenow="{{ $process['final_prob_tidak_layak'] * 100 }}"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <p class="h4 fw-bold text-danger mb-0">
                                                                {{ number_format($process['final_prob_tidak_layak'], 6) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="alert {{ $process['keputusan'] === 'LAYAK' ? 'alert-success' : 'alert-danger' }} mt-4 mb-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-white p-2 me-3">
                                                        <i
                                                            class="fas fa-gavel {{ $process['keputusan'] === 'LAYAK' ? 'text-success' : 'text-danger' }}"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="fw-bold mb-0">Kesimpulan: {{ $process['keputusan'] }}
                                                        </h5>
                                                        <p class="mb-0 mt-1">
                                                            @if ($process['keputusan'] === 'LAYAK')
                                                                Kandidat ini memenuhi kriteria kelayakan berdasarkan
                                                                perhitungan probabilitas.
                                                            @else
                                                                Kandidat ini belum memenuhi kriteria kelayakan berdasarkan
                                                                perhitungan probabilitas.
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
                    @else
                        <p class="text-muted fs-5"><i class="fas fa-info-circle me-2"></i>Belum ada data hasil Naive
                            Bayes.</p>
                    @endif
        </section>

        <hr class="my-5">

        {{-- Bagian MAIRCA --}}
        <section>
            <div class="card border-0 bg-warning bg-opacity-10 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-3"><i class="fas fa-sort-amount-down me-2 text-warning"></i>Ranking <span
                            class="text-warning">MAIRCA</span></h2>
                    <p class="lead mb-0">Metode <strong>Multi-Attributive Ideal-Real Comparative Analysis (MAIRCA)</strong>
                        mengurutkan alternatif yang telah dinyatakan layak oleh Naive Bayes. Semakin kecil nilai deviasi,
                        semakin baik peringkat alternatif.</p>
                </div>
            </div>

            @if (count($maircaRankings) > 0)
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Peringkat Kandidat Beasiswa (MAIRCA)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3"><i class="fas fa-medal me-1"></i> Ranking</th>
                                        <th class="py-3"><i class="fas fa-user me-1"></i> Alternative</th>
                                        <th class="py-3"><i class="fas fa-chart-line text-primary me-1"></i> Final
                                            Deviation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $rankNo = 1; @endphp
                                    @foreach ($maircaRankings as $ranking)
                                        @php
                                            $altName = $ranking['alt']->name;
                                        @endphp
                                        <tr class="{{ $rankNo <= 3 ? 'table-warning' : '' }}">
                                            <td>
                                                @if ($rankNo == 1)
                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i
                                                            class="fas fa-crown me-1"></i> {{ $rankNo++ }}</span>
                                                @elseif($rankNo <= 3)
                                                    <span
                                                        class="badge bg-info text-dark rounded-pill px-3 py-2">{{ $rankNo++ }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary rounded-pill px-3 py-2">{{ $rankNo++ }}</span>
                                                @endif
                                            </td>
                                            <td><strong>{{ $altName }}</strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: {{ min($ranking['score'] * 100, 100) }}%"
                                                            aria-valuenow="{{ $ranking['score'] * 100 }}"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span
                                                        class="text-nowrap">{{ number_format($ranking['score'], 6) }}</span>
                                                </div>
                                                <small class="text-muted">Semakin kecil nilai, semakin baik
                                                    peringkat</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                    <div class="card-header bg-warning bg-opacity-10 py-3">
                        <h3 class="mb-0 fw-bold"><i class="fas fa-book-reader me-2"></i>Detail Proses Perhitungan MAIRCA
                        </h3>
                        <p class="text-muted mt-2 mb-0">Berikut adalah langkah-langkah perhitungan metode MAIRCA untuk
                            menentukan peringkat kandidat beasiswa.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading">Cara Membaca Hasil Perhitungan</h5>
                                    <p class="mb-0">Metode MAIRCA menggunakan beberapa tahapan perhitungan:</p>
                                    <ol class="mb-0 mt-2">
                                        <li><strong>Raw Matrix</strong> - Nilai asli dari setiap alternatif untuk setiap
                                            kriteria</li>
                                        <li><strong>Normalized Matrix</strong> - Nilai yang telah dinormalisasi (dibagi
                                            dengan denominator)</li>
                                        <li><strong>Ideal Weights</strong> - Bobot ideal untuk setiap kriteria</li>
                                        <li><strong>Final Scores</strong> - Skor akhir yang menentukan peringkat (hasil
                                            perhitungan deviasi)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion" id="maircaProcessAccordion">
                            <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                                <h2 class="accordion-header" id="headingRawMatrix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseRawMatrix" aria-expanded="false"
                                        aria-controls="collapseRawMatrix">
                                        <i class="fas fa-th-list me-2 text-primary"></i>
                                        <strong>Langkah 1: Raw Matrix</strong> - Nilai Asli Setiap Alternatif
                                    </button>
                                </h2>
                                <div id="collapseRawMatrix" class="accordion-collapse collapse"
                                    aria-labelledby="headingRawMatrix" data-bs-parent="#maircaProcessAccordion">
                                    <div class="accordion-body bg-light">
                                        <p class="text-muted mb-3">Matriks ini berisi nilai asli dari setiap alternatif
                                            untuk setiap kriteria sebelum dinormalisasi.</p>

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
                                                    foreach ($criterias as $criteria) {
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

                                        <x-matrix-table title="Raw Matrix"
                                            description="Nilai asli dari setiap alternatif untuk setiap kriteria"
                                            :matrix="$maircaProses['raw_matrix']" :criteria_names="$criteriaNames" />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                                <h2 class="accordion-header" id="headingNormalizedMatrix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseNormalizedMatrix" aria-expanded="false"
                                        aria-controls="collapseNormalizedMatrix">
                                        <i class="fas fa-balance-scale me-2 text-warning"></i>
                                        <strong>Langkah 2: Normalized Matrix</strong> - Nilai yang Telah Dinormalisasi
                                    </button>
                                </h2>
                                <div id="collapseNormalizedMatrix" class="accordion-collapse collapse"
                                    aria-labelledby="headingNormalizedMatrix" data-bs-parent="#maircaProcessAccordion">
                                    <div class="accordion-body bg-light">
                                        <p class="text-muted mb-3">Matriks yang telah dinormalisasi untuk menyamakan skala
                                            nilai dari berbagai kriteria.</p>

                                        <x-matrix-table title="Normalized Matrix"
                                            description="Matriks yang telah dinormalisasi untuk menyamakan skala nilai dari berbagai kriteria"
                                            :matrix="$maircaProses['normalized_matrix']" :criteria_names="$criteriaNames" />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                                <h2 class="accordion-header" id="headingNormalizedMatrix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseIdealWeights" aria-expanded="false"
                                        aria-controls="collapseIdealWeights">
                                        <i class="fas fa-weight-hanging me-2 text-success"></i>
                                        <strong>Langkah 3: Ideal Weights</strong> - Bobot Ideal untuk Setiap Kriteria
                                    </button>
                                </h2>
                                <div id="collapseIdealWeights" class="accordion-collapse collapse"
                                    aria-labelledby="headingIdealWeights" data-bs-parent="#maircaProcessAccordion">
                                    <div class="accordion-body bg-light">
                                        <p class="text-muted mb-3">Bobot ideal yang digunakan untuk menghitung deviasi dari
                                            setiap alternatif.</p>

                                        <x-ideal-weights-table title="Ideal Weights"
                                            description="Bobot ideal untuk setiap kriteria dan alternatif"
                                            :weights="$maircaProses['ideal_weights']" :criteria_names="$criteriaNames" />
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                                <h2 class="accordion-header" id="headingFinalScores">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFinalScores" aria-expanded="false"
                                        aria-controls="collapseFinalScores">
                                        <i class="fas fa-star me-2 text-danger"></i>
                                        <strong>Langkah 4: Final Scores (Deviasi)</strong> - Skor Akhir dan Peringkat
                                    </button>
                                </h2>
                                <div id="collapseFinalScores" class="accordion-collapse collapse"
                                    aria-labelledby="headingFinalScores" data-bs-parent="#maircaProcessAccordion">
                                    <div class="accordion-body bg-light">
                                        <p class="text-muted mb-3">Skor akhir yang menunjukkan deviasi setiap alternatif
                                            dari nilai ideal. Semakin kecil nilai deviasi, semakin baik peringkat
                                            alternatif.</p>

                                        <x-final-scores-table title="Final Scores (Deviasi)"
                                            description="Skor akhir yang menentukan peringkat alternatif" :scores="$maircaProses['final_scores']"
                                            method="mairca" />
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
                            <p class="text-muted mb-0">Belum ada data untuk perhitungan MAIRCA, atau semua alternatif tidak
                                layak berdasarkan hasil filtering Naive Bayes.</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
