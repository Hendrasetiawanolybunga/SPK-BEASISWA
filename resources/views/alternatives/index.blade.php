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
                <div class="alert alert-warning d-flex flex-column align-items-center px-5">
                    <div class="mb-3">
                        Belum ada data alternatif.
                    </div>
                    <a href="{{ route('alternatives.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Tambah Alternatif
                    </a>
                </div>
            @endif
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light text-primary">
                                <tr>
                                    <th><i class="fas fa-user"></i> Nama</th>
                                    @foreach ($alternatives[0]->scores as $score)
                                        <th>{{ $score->criteria->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatives as $alt)
                                    <tr>
                                        <td class="fw-semibold text-start">{{ $alt->name }}</td>
                                        @foreach ($alt->scores as $score)
                                            <td>{{ $score->value }}</td>
                                        @endforeach
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
