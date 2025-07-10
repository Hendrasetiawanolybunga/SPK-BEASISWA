@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">
            <i class="fas fa-user-plus text-primary me-2"></i>Tambah Calon Penerima Beasiswa
        </h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('alternatives.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">
                    <i class="fas fa-id-badge me-1"></i>Nama Lengkap
                </label>
                <input type="text" name="name" id="name" class="form-control"
                    placeholder="Contoh: Ahmad Rofiudin" required>
            </div>

            <h5 class="mb-3"><i class="fas fa-clipboard-check me-1"></i>Penilaian Kriteria</h5>

            <div class="row g-4">
                @foreach ($criterias as $criteria)
                    @php
                        $name = "scores[{$criteria->id}]";
                        $lowerName = strtolower($criteria->name);
                    @endphp

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ $criteria->name }} <span
                                class="text-muted">({{ ucfirst($criteria->type) }})</span></label>

                        @if (Str::contains($lowerName, ['penghasilan', 'ekonomi']))
                            <select name="{{ $name }}" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="1">Kategori A (penghasilan rendah)</option>
                                <option value="2">Kategori B (penghasilan menengah)</option>
                                <option value="3">Kategori C (penghasilan tinggi)</option>
                            </select>
                        @elseif(Str::contains($lowerName, ['3t', 'difabel']))
                            <select name="{{ $name }}" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        @else
                            <input type="number" step="any" name="{{ $name }}" class="form-control"
                                placeholder="Masukkan nilai (misal: 85)" required>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('alternatives.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
@endsection
