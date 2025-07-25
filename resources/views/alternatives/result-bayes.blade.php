@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📊 Hasil Perhitungan BAYES</h2>

        @if (empty($scores))
            <div class="alert alert-warning text-center">
                <strong>⚠️ Tidak ada data alternatif untuk ditampilkan.</strong> Pastikan Anda memiliki alternatif dengan skor lengkap.
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr class="table-primary text-center align-middle">
                                    <th class="text-nowrap">
                                        🏆 <span class="d-none d-md-inline">Peringkat</span>
                                    </th>
                                    <th class="text-nowrap">
                                        👤 <span class="d-none d-md-inline">Nama Alternatif</span>
                                    </th>
                                    <th class="text-nowrap">
                                        📈 <span class="d-none d-md-inline">Probabilitas LAYAK</span><br>
                                        <small class="text-muted fst-italic">(semakin tinggi semakin baik)</small>
                                    </th>
                                    <th class="text-nowrap">
                                        📉 <span class="d-none d-md-inline">Probabilitas TIDAK LAYAK</span>
                                    </th>
                                    <th class="text-nowrap">
                                        ✅ <span class="d-none d-md-inline">Keputusan</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scores as $index => $item)
                                    <tr class="{{ $item['keputusan'] == 'LAYAK' ? 'table-success fw-bold' : '' }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item['alt']->name }}</td>
                                        <td>{{ number_format($item['score_layak'], 4) }}</td>
                                        <td>{{ number_format($item['score_tidak_layak'], 4) }}</td>
                                        <td>
                                            @if ($item['keputusan'] == 'LAYAK')
                                                <span class="badge bg-success">LAYAK</span>
                                            @else
                                                <span class="badge bg-danger">TIDAK LAYAK</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @php
                        $topLayak = collect($scores)->firstWhere('keputusan', 'LAYAK');
                    @endphp

                    @if ($topLayak)
                        <div class="alert alert-info mt-4 text-center">
                            <h5 class="mb-2">✨ <strong>Rekomendasi Utama:</strong></h5>
                            <p class="fs-5 mb-0">{{ $topLayak['alt']->name }}<br>
                                <span class="text-muted">Dengan probabilitas LAYAK: {{ number_format($topLayak['score_layak'], 4) }}</span>
                            </p>
                        </div>
                    @else
                        <div class="alert alert-secondary mt-4 text-center">
                            <p class="mb-0">Tidak ada alternatif yang diklasifikasikan sebagai LAYAK berdasarkan perhitungan Bayes.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('alternatives.index') }}" class="btn btn-outline-secondary">
                ⬅️ Kembali ke Data Alternatif
            </a>
        </div>
    </div>
@endsection
