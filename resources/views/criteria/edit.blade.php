@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">
            <i class="fas fa-pen-alt text-warning me-2"></i>Edit Kriteria {{ $criteria->name }}
        </h2>

        <form action="{{ route('criteria.update', $criteria->id) }}" method="POST" id="editCriteriaForm">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-tag me-1"></i>Nama Kriteria
                    </label>
                    <input type="text" name="name" class="form-control" value="{{ $criteria->name }}" required>
                </div> --}}

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-layer-group me-1"></i>Jenis Kriteria
                    </label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="benefit" {{ $criteria->type == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ $criteria->type == 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-balance-scale me-1"></i>Bobot (0 - 1)
                    </label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="range" step="0.01" min="0" max="1" value="{{ $criteria->weight }}"
                            id="weightSlider" class="form-range w-50">
                        <input type="number" name="weight" step="0.01" min="0" max="1" id="weightInput"
                            value="{{ $criteria->weight }}" class="form-control w-25" required>
                    </div>
                    <div class="form-text text-muted mt-1">
                        Pastikan total bobot semua kriteria tidak melebihi 1.
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('criteria.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Kriteria
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('weightSlider');
            const input = document.getElementById('weightInput');
            const form = document.getElementById('editCriteriaForm');

            const otherTotal = {{ \App\Models\Criteria::where('id', '!=', $criteria->id)->sum('weight') }};
            const currentWeight = parseFloat("{{ $criteria->weight }}");

            // Sinkronisasi slider dan input
            slider.addEventListener('input', function() {
                input.value = this.value;
            });

            form.addEventListener('submit', function(e) {
                const newWeight = parseFloat(input.value);

                if ((otherTotal + newWeight) > 1.001) {
                    e.preventDefault();
                    alert(
                        `Total bobot akan melebihi 1!\n\nSaat ini bobot dari kriteria lain sudah ${otherTotal.toFixed(2)}.\nSilakan kurangi bobot atau edit kriteria lain terlebih dahulu.`);
                }
            });
        });
    </script>
@endsection
