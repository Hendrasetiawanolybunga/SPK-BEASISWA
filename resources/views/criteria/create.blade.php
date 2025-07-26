@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">
            <i class="fas fa-plus-circle text-success me-2"></i>Tambah Kriteria
        </h2>

        <form action="{{ route('criteria.store') }}" method="POST" id="criteriaForm">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-tag me-1"></i>Nama Kriteria
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Prestasi Akademik"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-layer-group me-1"></i>Jenis Kriteria
                    </label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="benefit">Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost">Cost (Semakin rendah semakin baik)</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-balance-scale me-1"></i>Bobot (0 - 1)
                    </label>

                    <div class="d-flex align-items-center gap-3">
                        <input type="range" step="0.01" min="0" max="1" value="0" id="weightSlider"
                            class="form-range w-50">
                        <input type="number" name="weight" step="0.01" min="0" max="1" id="weightInput"
                            class="form-control w-25" readonly>
                    </div>
                    <div class="form-text text-muted mt-1">
                        Bobot disarankan agar total semua kriteria = 1. Akan diisi otomatis dengan sisa bobot.
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('criteria.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan Kriteria
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('weightSlider');
            const input = document.getElementById('weightInput');
            const form = document.getElementById('criteriaForm');

            // Ambil total bobot saat ini dari server
            const existingTotal = {{ \App\Models\Criteria::sum('weight') }};
            const remaining = (1 - existingTotal).toFixed(2);

            // Set nilai default
            slider.value = remaining;
            input.value = remaining;

            // Update input number saat slider digeser
            slider.addEventListener('input', function() {
                input.value = this.value;
            });

            // Cegah submit jika total > 1
            form.addEventListener('submit', function(e) {
                const newWeight = parseFloat(input.value);
                if ((existingTotal + newWeight) > 1.001) {
                    e.preventDefault();
                    alert(
                        `Total bobot akan melebihi 1! Silakan kurangi bobot atau hapus kriteria lain terlebih dahulu.`
                        );
                }
            });
        });
    </script>
@endsection
