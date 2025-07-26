@extends('layouts.app')

@section('content')
    <style>
        .summary-card {
            background-color: #e9f7ff;
            /* Light blue background */
            border-left: 5px solid #007bff;
            /* Blue border */
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .summary-card h4 {
            color: #0056b3;
            font-weight: bold;
        }

        .summary-item {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .summary-item strong {
            color: #333;
        }

        .badge-lg {
            font-size: 0.9em;
            padding: 0.5em 0.8em;
            border-radius: 0.5rem;
        }

        .table-responsive {
            margin-top: 1.5rem;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table-success {
            background-color: #d4edda !important;
            color: #155724 !important;
        }

        .table-danger-bayes {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }

        .accordion-button {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            border-radius: 0.5rem;
            transition: background-color 0.2s ease;
        }

        .accordion-button:not(.collapsed) {
            background-color: #e2e6ea;
            color: #000;
        }

        .accordion-body {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
    </style>

    <div class="container mt-4">
        <h2 class="mb-4 text-center">📊 Hasil Rekomendasi Penerima Beasiswa</h2>
        <p class="text-center lead text-muted">Kombinasi Metode Naive Bayes & MAIRCA</p>

        @if ($totalAlternatives === 0)
            <div class="alert alert-warning text-center">
                <strong>⚠️ Tidak ada data alternatif untuk ditampilkan.</strong> Silakan tambahkan data alternatif dan skor
                kriteria.
            </div>
        @else
            {{-- Ringkasan Proses Filtering Bayes --}}
            <div class="summary-card text-center">
                <h4 class="mb-3">Ringkasan Proses Seleksi Awal (Naive Bayes)</h4>
                <div class="row justify-content-center">
                    <div class="col-md-4 summary-item">
                        <strong>Total Kandidat Awal:</strong> <br><span
                            class="badge bg-primary badge-lg">{{ $totalAlternatives }}</span>
                    </div>
                    <div class="col-md-4 summary-item">
                        <strong>Lolos Penyaringan (LAYAK):</strong><br> <span
                            class="badge bg-success badge-lg">{{ $layakCount }}</span>
                    </div>
                    <div class="col-md-4 summary-item">
                        <strong>Tidak Lolos Penyaringan (TIDAK LAYAK):</strong> <br><span
                            class="badge bg-danger badge-lg">{{ $tidakLayakCount }}</span>
                    </div>
                </div>
            </div>

            @if (empty($maircaRankings))
                <div class="alert alert-info text-center">
                    <strong>ℹ️ Tidak ada alternatif yang lolos penyaringan Naive Bayes untuk dihitung dengan MAIRCA.</strong>
                </div>
            @else
                <h3 class="mb-3 mt-5 text-center">Ranking Akhir (MAIRCA) untuk Kandidat LAYAK</h3>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-nowrap">🏆 Peringkat</th>
                                        <th class="text-nowrap">👤 Nama Alternatif</th>
                                        <th class="text-nowrap">📈 Skor MAIRCA Akhir<br>
                                            <small class="text-white-50 fst-italic">(semakin rendah semakin baik)</small>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($maircaRankings as $index => $item)
                                        <tr @if ($index == 0) class="table-success fw-bold" @endif>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['alt']->name }}</td>
                                            <td>{{ number_format($item['score'], 4) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-success mt-4 text-center">
                            <h5 class="mb-2">🏅 <strong>Alternatif Terbaik:</strong></h5>
                            <p class="fs-5 mb-0">{{ $maircaRankings[0]['alt']->name }}<br>
                                <span class="text-muted">Skor MAIRCA Terendah:
                                    {{ number_format($maircaRankings[0]['score'], 4) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Bagian Alternatif TIDAK LAYAK (Collapsible) --}}
            @if (!$tidakLayakAlternatives->isEmpty())
                <div class="accordion mt-5" id="accordionTidakLayak">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <i class="fas fa-times-circle me-2 text-danger"></i> Lihat Alternatif TIDAK LAYAK (Hasil
                                Bayes)
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionTidakLayak">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle text-center">
                                        <thead class="table-danger">
                                            <tr>
                                                <th class="text-nowrap">👤 Nama Alternatif</th>
                                                <th class="text-nowrap">📈 Probabilitas LAYAK</th>
                                                <th class="text-nowrap">📉 Probabilitas TIDAK LAYAK</th>
                                                <th class="text-nowrap">❌ Keputusan Bayes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bayesResults as $item)
                                                @if ($item['keputusan'] == 'TIDAK LAYAK')
                                                    <tr class="table-danger-bayes">
                                                        <td>{{ $item['alt']->name }}</td>
                                                        <td>{{ number_format($item['score_layak'], 4) }}</td>
                                                        <td>{{ number_format($item['score_tidak_layak'], 4) }}</td>
                                                        <td><span class="badge bg-danger">TIDAK LAYAK</span></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @endif {{-- End if totalAlternatives empty check --}}

        <div class="text-center mt-5 mb-4">
            <a href="{{ route('alternatives.index') }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Data Alternatif
            </a>
        </div>
    </div>
@endsection
