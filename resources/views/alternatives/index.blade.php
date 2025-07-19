@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center"><i class="fas fa-users me-2"></i>Data Alternatif</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">
                <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif

        @if ($alternatives->isEmpty())
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="alert alert-warning d-flex flex-column align-items-center px-5">
                        <div class="mb-3">
                            <em>Belum ada data alternatif.</em>
                        </div>
                        <a href="{{ route('alternatives.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Tambah Alternatif
                        </a>
                    </div>
                    @if ($criterias->isEmpty())
                        <div class="alert alert-warning d-flex flex-column align-items-center px-5">
                            <div class="mb-3">
                                <em>Belum ada data kriteria yang bisa digunakan.</em>
                            </div>
                            <a href="{{ route('criteria.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Kriteria
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <em>Sudah ada data kriteria yang bisa digunakan.</em>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light text-primary">
                                <tr>
                                    <th class="text-nowrap">
                                        <i class="fas fa-user"></i> Nama
                                    </th>

                                    @foreach ($criterias as $criteria)
                                        <th class="text-nowrap">
                                            {{ $criteria->name }}
                                        </th>
                                    @endforeach

                                    <th class="text-nowrap">
                                        <i class="fas fa-tools"></i> Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatives as $alt)
                                    <tr>
                                        <td class="fw-semibold text-start">{{ $alt->name }}</td>

                                        {{-- Tampilkan nilai sesuai jumlah kriteria --}}
                                        @foreach ($criterias as $criteria)
                                            @php
                                                $score = $alt->scores->where('criteria_id', $criteria->id)->first();
                                            @endphp
                                            @if ($score)
                                                @if ($score->value == 0)
                                                    <td>Tidak</td>
                                                @elseif ($score->value == 1)
                                                    <td>Ya</td
                                                @else
                                                    <td>{{ $score->value }}</td>
                                                @endif
                                            @else
                                                <td>-</td>
                                            @endif
                                        @endforeach

                                        {{-- Kolom aksi --}}
                                        <td class="text-center text-nowrap">
                                            <a href="{{ route('alternatives.edit', $alt->id) }}"
                                                class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('alternatives.destroy', $alt->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($criterias->isEmpty())
                        <div class="alert alert-warning d-flex flex-column align-items-center px-5">
                            <div class="mb-3">
                                Belum ada data kriteria yang bisa digunakan.
                            </div>
                            <a href="{{ route('criteria.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Kriteria
                            </a>
                        </div>
                    @else
                        <div class="text-end mt-3">
                            <a href="{{ route('alternatives.create') }}" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Tambah Alternatif
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
