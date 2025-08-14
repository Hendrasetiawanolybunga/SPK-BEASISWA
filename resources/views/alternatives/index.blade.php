@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center"><i class="fas fa-user-graduate me-2"></i> Kandidat Penerima Beasiswa</h2>

        @if (session('success'))
            <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($alternatives->isEmpty())
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="alert alert-warning d-flex flex-column align-items-center px-5 py-4">
                        <div class="mb-3 fs-5">
                            <em>Belum ada data alternatif yang terdaftar.</em>
                        </div>
                        <a href="{{ route('alternatives.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Calon Penerima Beasiswa
                        </a>
                    </div>
                    @if ($criterias->isEmpty())
                        <div class="alert alert-info d-flex flex-column align-items-center px-5 py-4 mt-4">
                            <div class="mb-3 fs-5">
                                <em>Perhatian: Belum ada data kriteria yang bisa digunakan untuk penilaian.</em>
                            </div>
                            <a href="{{ route('criteria.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Kriteria
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info text-center mt-4 py-3">
                            <em>Anda sudah memiliki <strong>{{ $criterias->count() }}</strong> kriteria yang siap
                                digunakan.</em>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 text-primary">Daftar Kandidat Penerima Beasiswa</h5>
                        <a href="{{ route('alternatives.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Alternatif
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th class="text-nowrap align-middle">
                                        <i class="fas fa-user"></i> Nama
                                    </th>

                                    @foreach ($criterias as $criteria)
                                        <th class="text-nowrap align-middle">
                                            {{ $criteria->name }}
                                            @if ($criteria->type == 'benefit')
                                                <small class="d-block text-success">({{ ucfirst($criteria->type) }})</small>
                                            @else
                                                <small class="d-block text-danger">({{ ucfirst($criteria->type) }})</small>
                                            @endif
                                        </th>
                                    @endforeach

                                    <th class="text-nowrap align-middle">
                                        <i class="fas fa-tools"></i> Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach ($alternatives as $alt)
                                    <tr class="align-middle">
                                        <td class="fw-semibold text-start text-nowrap">{{ $alt->name }}</td>

                                        {{-- Tampilkan nilai sesuai jumlah kriteria --}}
                                        @foreach ($criterias as $criteria)
                                            @php
                                                $score = $alt->scores->where('criteria_id', $criteria->id)->first();
                                                $displayValue = '-'; // Default
                                                $lowerName = strtolower($criteria->name);

                                                if ($score) {
                                                    if (Str::contains($lowerName, 'prestasi akademik')) {
                                                        switch ($score->value) {
                                                            case 4:
                                                                $displayValue = 'Juara Olimpiade';
                                                                break;
                                                            case 3:
                                                                $displayValue = 'Juara Kelas';
                                                                break;
                                                            case 2:
                                                                $displayValue = 'Juara Lainnya';
                                                                break;
                                                            case 1:
                                                                $displayValue = 'Tidak Ada';
                                                                break;
                                                            default:
                                                                $displayValue = $score->value;
                                                                break;
                                                        }
                                                    } elseif (Str::contains($lowerName, 'prestasi non-akademik')) {
                                                        $displayValue = $score->value == 1 ? 'Ada' : 'Tidak Ada';
                                                    } elseif (Str::contains($lowerName, 'keterlibatan masyarakat')) {
                                                        switch ($score->value) {
                                                            case 4:
                                                                $displayValue = 'Ketua';
                                                                break;
                                                            case 3:
                                                                $displayValue = 'Pengurus';
                                                                break;
                                                            case 2:
                                                                $displayValue = 'Anggota Aktif';
                                                                break;
                                                            case 1:
                                                                $displayValue = 'Tidak Ada';
                                                                break;
                                                            default:
                                                                $displayValue = $score->value;
                                                                break;
                                                        }
                                                    } elseif (Str::contains($lowerName, 'kondisi ekonomi')) {
                                                        switch ($score->value) {
                                                            case 5:
                                                                $displayValue = 'Sangat Buruk';
                                                                break;
                                                            case 4:
                                                                $displayValue = 'Buruk';
                                                                break;
                                                            case 3:
                                                                $displayValue = 'Cukup';
                                                                break;
                                                            case 2:
                                                                $displayValue = 'Baik';
                                                                break;
                                                            case 1:
                                                                $displayValue = 'Sangat Baik';
                                                                break;
                                                            default:
                                                                $displayValue = $score->value;
                                                                break;
                                                        }
                                                    } elseif (Str::contains($lowerName, 'penghasilan orang tua')) {
                                                        switch ($score->value) {
                                                            case 1:
                                                                $displayValue = '< Rp 1.000.000';
                                                                break;
                                                            case 2:
                                                                $displayValue = 'Rp 1.000.000 - Rp 1.500.000';
                                                                break;
                                                            case 3:
                                                                $displayValue = 'Rp 1.500.000 - Rp 2.000.000';
                                                                break;
                                                            case 4:
                                                                $displayValue = 'Rp 2.000.000 - Rp 2.500.000';
                                                                break;
                                                            case 5:
                                                                $displayValue = 'Rp 2.500.000 - Rp 3.000.000';
                                                                break;
                                                            case 6:
                                                                $displayValue = 'Rp 3.000.000 - Rp 4.000.000';
                                                                break;
                                                            case 7:
                                                                $displayValue = 'Rp 4.000.000 - Rp 5.000.000';
                                                                break;
                                                            case 8:
                                                                $displayValue = 'Rp 5.000.000 - Rp 6.000.000';
                                                                break;
                                                            case 9:
                                                                $displayValue = 'Rp 6.000.000 - Rp 8.000.000';
                                                                break;
                                                            case 10:
                                                                $displayValue = 'Rp 8.000.000 - Rp 10.000.000';
                                                                break;
                                                            case 11:
                                                                $displayValue = '> Rp 10.000.000';
                                                                break;
                                                            default:
                                                                $displayValue = 'Tidak Diketahui';
                                                                break;
                                                        }
                                                    } elseif (Str::contains($lowerName, ['domisili 3t', 'difabel'])) {
                                                        $displayValue = $score->value == 1 ? 'Ya' : 'Tidak';
                                                    } elseif (
                                                        Str::contains($lowerName, 'jumlah tanggungan orang tua')
                                                    ) {
                                                        $displayValue = $score->value . ' orang';
                                                    } else {
                                                        $displayValue = $score->value;
                                                    }
                                                }
                                            @endphp
                                            <td class="text-nowrap">{{ $displayValue }}</td>
                                        @endforeach

                                        {{-- Kolom aksi --}}
                                        <td class="text-center text-nowrap">
                                            <a href="{{ route('alternatives.edit', $alt->id) }}"
                                                class="btn btn-sm btn-warning me-1" title="Edit Data">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('alternatives.destroy', $alt->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
