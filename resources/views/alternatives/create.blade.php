@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">
            <i class="fas fa-user-plus text-primary me-2"></i>Tambah Calon Penerima Beasiswa
        </h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('alternatives.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">
                    <i class="fas fa-id-badge me-1"></i>Nama Lengkap
                </label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Contoh: Ahmad Rofiudin" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if (!empty($kondisiEkonomiCriteria) || !empty($penghasilanOrtuCriteria) || !$otherCriterias->isEmpty())
                <h5 class="mb-3"><i class="fas fa-clipboard-check me-1"></i>Penilaian Kriteria</h5>
            @endif

            <div class="row g-4">
                {{-- Kondisi Ekonomi --}}
                @if ($kondisiEkonomiCriteria)
                    @php
                        $name = "scores[{$kondisiEkonomiCriteria->id}]";
                        $oldValue = old($name);
                    @endphp
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kondisi_ekonomi_select" class="form-label fw-semibold">
                                {{ $kondisiEkonomiCriteria->name }}
                                <span class="text-muted">({{ ucfirst($kondisiEkonomiCriteria->type) }})</span>
                            </label>
                            <select name="{{ $name }}" id="kondisi_ekonomi_select"
                                class="form-select @error($name) is-invalid @enderror" required>
                                <option value="">-- Pilih Kondisi Ekonomi --</option>
                                <option value="sangat_buruk" {{ $oldValue == 'sangat_buruk' ? 'selected' : '' }}>Sangat Buruk</option>
                                <option value="buruk" {{ $oldValue == 'buruk' ? 'selected' : '' }}>Buruk</option>
                                <option value="cukup" {{ $oldValue == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="baik" {{ $oldValue == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="sangat_baik" {{ $oldValue == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                            </select>
                            @error($name)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- Penghasilan Orang Tua (Dynamic) --}}
                @if ($penghasilanOrtuCriteria)
                    @php
                        $name = "scores[{$penghasilanOrtuCriteria->id}]";
                        // Ambil old value untuk penghasilan ortu
                        $oldPenghasilanValue = old($name);
                    @endphp
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="penghasilan_ortu_select" class="form-label fw-semibold">
                                {{ $penghasilanOrtuCriteria->name }}
                                <span class="text-muted">({{ ucfirst($penghasilanOrtuCriteria->type) }})</span>
                            </label>
                            <select name="{{ $name }}" id="penghasilan_ortu_select"
                                class="form-select @error($name) is-invalid @enderror" required disabled>
                                <option value="">-- Pilih Kondisi Ekonomi Dulu --</option>
                            </select>
                            <small class="form-text text-muted">
                                *Pilihan ini akan muncul setelah memilih Kondisi Ekonomi.
                            </small>
                            @error($name)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- Other Criterias --}}
                @foreach ($otherCriterias as $criteria)
                    @php
                        $name = "scores[{$criteria->id}]";
                        $lowerName = strtolower($criteria->name);
                        $oldValue = old($name);
                    @endphp

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="{{ Str::slug($criteria->name) }}" class="form-label fw-semibold">
                                {{ $criteria->name }}
                                <span class="text-muted">({{ ucfirst($criteria->type) }})</span>
                            </label>

                            @if (Str::contains($lowerName, 'prestasi akademik'))
                                <select name="{{ $name }}" id="{{ Str::slug($criteria->name) }}"
                                    class="form-select @error($name) is-invalid @enderror" required>
                                    <option value="">-- Pilih Prestasi --</option>
                                    <option value="juara_olimpiade" {{ $oldValue == 'juara_olimpiade' ? 'selected' : '' }}>Juara Olimpiade (Nasional/Internasional)</option>
                                    <option value="juara_kelas" {{ $oldValue == 'juara_kelas' ? 'selected' : '' }}>Juara Kelas (Top 3)</option>
                                    <option value="juara_lainnya" {{ $oldValue == 'juara_lainnya' ? 'selected' : '' }}>Juara Lainnya di Bidang Akademik</option>
                                    <option value="tidak_ada_akademik" {{ $oldValue == 'tidak_ada_akademik' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                            @elseif(Str::contains($lowerName, 'prestasi non-akademik'))
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ $name }}"
                                        id="{{ Str::slug($criteria->name) }}_ada" value="ada"
                                        {{ $oldValue == 'ada' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ Str::slug($criteria->name) }}_ada">Ada</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ $name }}"
                                        id="{{ Str::slug($criteria->name) }}_tidak_ada" value="tidak_ada"
                                        {{ $oldValue == 'tidak_ada' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ Str::slug($criteria->name) }}_tidak_ada">Tidak Ada</label>
                                </div>
                            @elseif(Str::contains($lowerName, 'keterlibatan masyarakat'))
                                <select name="{{ $name }}" id="{{ Str::slug($criteria->name) }}"
                                    class="form-select @error($name) is-invalid @enderror" required>
                                    <option value="">-- Pilih Tingkat Keterlibatan --</option>
                                    <option value="ketua" {{ $oldValue == 'ketua' ? 'selected' : '' }}>Ketua Organisasi/Komunitas</option>
                                    <option value="pengurus" {{ $oldValue == 'pengurus' ? 'selected' : '' }}>Pengurus Organisasi/Komunitas</option>
                                    <option value="anggota" {{ $oldValue == 'anggota' ? 'selected' : '' }}>Anggota Aktif Organisasi/Komunitas</option>
                                    <option value="tidak_ada_keterlibatan" {{ $oldValue == 'tidak_ada_keterlibatan' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                            @elseif(Str::contains($lowerName, ['domisili 3t', 'difabel']))
                                <select name="{{ $name }}" id="{{ Str::slug($criteria->name) }}"
                                    class="form-select @error($name) is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="0" {{ $oldValue == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ $oldValue == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                            @else {{-- Default untuk kriteria lain (misal: Jumlah Tanggungan) --}}
                                <input type="number" step="any" name="{{ $name }}" id="{{ Str::slug($criteria->name) }}"
                                    class="form-control @error($name) is-invalid @enderror"
                                    placeholder="Masukkan nilai (misal: 3 untuk tanggungan, 85 untuk nilai)"
                                    value="{{ $oldValue }}" required>
                            @endif

                            @error($name)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kondisiEkonomiSelect = document.getElementById('kondisi_ekonomi_select');
            const penghasilanOrtuSelect = document.getElementById('penghasilan_ortu_select');

            // Definisi opsi penghasilan berdasarkan kondisi ekonomi
            const penghasilanOptions = {
                'sangat_buruk': [
                    { value: '<_1jt', text: '< Rp 1.000.000' },
                    { value: '1jt_2.5jt', text: 'Rp 1.000.000 - Rp 2.500.000' }
                ],
                'buruk': [
                    { value: '1jt_2.5jt', text: 'Rp 1.000.000 - Rp 2.500.000' },
                    { value: '2.5jt_5jt', text: 'Rp 2.500.000 - Rp 5.000.000' }
                ],
                'cukup': [
                    { value: '2.5jt_5jt', text: 'Rp 2.500.000 - Rp 5.000.000' },
                    { value: '5jt_10jt', text: 'Rp 5.000.000 - Rp 10.000.000' }
                ],
                'baik': [
                    { value: '5jt_10jt', text: 'Rp 5.000.000 - Rp 10.000.000' },
                    { value: '>_10jt', text: '> Rp 10.000.000' }
                ],
                'sangat_baik': [
                    { value: '>_10jt', text: '> Rp 10.000.000' }
                ]
            };

            function updatePenghasilanOptions(selectedKondisiEkonomi, currentPenghasilanValue = null) {
                penghasilanOrtuSelect.innerHTML = '<option value="">-- Pilih Nominal Penghasilan --</option>';
                const options = penghasilanOptions[selectedKondisiEkonomi];

                if (options) {
                    options.forEach(optionData => {
                        const option = document.createElement('option');
                        option.value = optionData.value;
                        option.textContent = optionData.text;
                        if (currentPenghasilanValue && currentPenghasilanValue == optionData.value) {
                            option.selected = true;
                        }
                        penghasilanOrtuSelect.appendChild(option);
                    });
                    // FIX: Typo corrected here
                    penghasilanOrtuSelect.disabled = false;
                } else {
                    penghasilanOrtuSelect.disabled = true;
                }
            }

            // Event listener untuk Kondisi Ekonomi
            kondisiEkonomiSelect.addEventListener('change', function() {
                updatePenghasilanOptions(this.value);
            });

            // Handle old input on page load (for validation errors)
            const initialKondisiEkonomi = kondisiEkonomiSelect.value;
            // FIX: Correctly pass oldPenghasilanValue from PHP to JS
            const initialPenghasilanValue = "{{ $oldPenghasilanValue ?? '' }}";

            if (initialKondisiEkonomi) {
                updatePenghasilanOptions(initialKondisiEkonomi, initialPenghasilanValue);
            }
        });
    </script>
@endsection
