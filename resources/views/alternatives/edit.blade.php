@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">
            <i class="fas fa-pen-alt text-warning me-2"></i>Edit Calon Penerima Beasiswa
        </h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('alternatives.update', $alternative->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">
                    <i class="fas fa-id-badge me-1"></i>Nama Lengkap
                </label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $alternative->name) }}" required>
            </div>

            @if (!$criterias->isEmpty())
                <h5 class="mb-3"><i class="fas fa-clipboard-check me-1"></i>Penilaian Kriteria</h5>
            @endif

            <div class="row g-4">
                @foreach ($criterias as $criteria)
                    @php
                        $name = "scores[{$criteria->id}]";
                        $lowerName = strtolower($criteria->name);
                        $scoreValue = old(
                            "scores.{$criteria->id}",
                            $alternative->scores->where('criteria_id', $criteria->id)->first()?->value,
                        );
                    @endphp

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            {{ $criteria->name }}
                            <span class="text-muted">({{ ucfirst($criteria->type) }})</span>
                        </label>

                        @if (Str::contains($lowerName, ['penghasilan', 'ekonomi']))
                            <select name="{{ $name }}" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="1" {{ $scoreValue == 1 ? 'selected' : '' }}>&lt; Rp.2.500.000</option>
                                <option value="2" {{ $scoreValue == 2 ? 'selected' : '' }}>Rp 2.500.000 - Rp.5.000.000
                                </option>
                                <option value="3" {{ $scoreValue == 3 ? 'selected' : '' }}>&gt; Rp.5.000.000</option>
                            </select>
                        @elseif(Str::contains($lowerName, ['3t', 'difabel']))
                            <select name="{{ $name }}" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="0" {{ $scoreValue == 0 ? 'selected' : '' }}>Tidak</option>
                                <option value="1" {{ $scoreValue == 1 ? 'selected' : '' }}>Ya</option>
                            </select>
                        @else
                            <input type="number" step="any" name="{{ $name }}" class="form-control"
                                value="{{ $scoreValue }}" required>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('alternatives.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Data
                </button>
            </div>
        </form>
    </div>
@endsection
