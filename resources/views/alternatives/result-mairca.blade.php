@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">📊 Hasil Perhitungan MAIRCA</h2>

        @if (empty($scores))
            <div class="alert alert-warning text-center">
                <strong>⚠️ Tidak ada data alternatif untuk ditampilkan.</strong>
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
                                        📈 <span class="d-none d-md-inline">Skor Akhir</span><br>
                                        <small class="text-muted fst-italic">(semakin rendah semakin baik)</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scores as $index => $item)
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
                        <p class="fs-5 mb-0">{{ $scores[0]['alt']->name }}<br>
                            <span class="text-muted">Skor Terendah: {{ number_format($scores[0]['score'], 4) }}</span>
                        </p>
                    </div>
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
