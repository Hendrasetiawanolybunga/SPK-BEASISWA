@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">
            <i class="fas fa-pen-alt text-warning me-2"></i>Edit Calon Penerima Beasiswa
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

        <form action="{{ route('alternatives.update', $alternative->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">
                    <i class="fas fa-id-badge me-1"></i>Nama Lengkap
                </label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $alternative->name) }}" required>
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
                        $scoreValue = old(
                            $name,
                            $alternative->scores->where('criteria_id', $kondisiEkonomiCriteria->id)->first()?->value,
                        );
                        // Convert numeric value back to string for select box
                        $displayValueForKondisiEkonomi = '';
                        switch ($scoreValue) {
                            case 5:
                                $displayValueForKondisiEkonomi = 'sangat_buruk';
                                break;
                            case 4:
                                $displayValueForKondisiEkonomi = 'buruk';
                                break;
                            case 3:
                                $displayValueForKondisiEkonomi = 'cukup';
                                break;
                            case 2:
                                $displayValueForKondisiEkonomi = 'baik';
                                break;
                            case 1:
                                $displayValueForKondisiEkonomi = 'sangat_baik';
                                break;
                        }
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
                                <option value="sangat_buruk"
                                    {{ $displayValueForKondisiEkonomi == 'sangat_buruk' ? 'selected' : '' }}>Sangat Buruk
                                </option>
                                <option value="buruk" {{ $displayValueForKondisiEkonomi == 'buruk' ? 'selected' : '' }}>
                                    Buruk</option>
                                <option value="cukup" {{ $displayValueForKondisiEkonomi == 'cukup' ? 'selected' : '' }}>
                                    Cukup</option>
                                <option value="baik" {{ $displayValueForKondisiEkonomi == 'baik' ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="sangat_baik"
                                    {{ $displayValueForKondisiEkonomi == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik
                                </option>
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
                        $scoreValue = old(
                            $name,
                            $alternative->scores->where('criteria_id', $penghasilanOrtuCriteria->id)->first()?->value,
                        );
                        // Convert numeric value back to string for select box
                        $displayValueForPenghasilan = '';
                        switch ($scoreValue) {
                            case 1:
                                $displayValueForPenghasilan = '<_1jt';
                                break;
                            case 2:
                                $displayValueForPenghasilan = '1jt_2.5jt';
                                break;
                            case 3:
                                $displayValueForPenghasilan = '2.5jt_5jt';
                                break;
                            case 4:
                                $displayValueForPenghasilan = '5jt_10jt';
                                break;
                            case 5:
                                $displayValueForPenghasilan = '>_10jt';
                                break;
                        }
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
                        $scoreValue = old(
                            $name,
                            $alternative->scores->where('criteria_id', $criteria->id)->first()?->value,
                        );
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
                                    <option value="juara_olimpiade" {{ $scoreValue == 5 ? 'selected' : '' }}>Juara
                                        Olimpiade (Nasional/Internasional)</option>
                                    <option value="juara_kelas" {{ $scoreValue == 4 ? 'selected' : '' }}>Juara Kelas (Top
                                        3)</option>
                                    <option value="juara_lainnya" {{ $scoreValue == 3 ? 'selected' : '' }}>Juara Lainnya di
                                        Bidang Akademik</option>
                                    <option value="tidak_ada_akademik" {{ $scoreValue == 1 ? 'selected' : '' }}>Tidak Ada
                                    </option>
                                </select>
                            @elseif(Str::contains($lowerName, 'prestasi non-akademik'))
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ $name }}"
                                        id="{{ Str::slug($criteria->name) }}_ada" value="ada"
                                        {{ $scoreValue == 1 ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ Str::slug($criteria->name) }}_ada">Ada</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ $name }}"
                                        id="{{ Str::slug($criteria->name) }}_tidak_ada" value="tidak_ada"
                                        {{ $scoreValue == 0 ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ Str::slug($criteria->name) }}_tidak_ada">Tidak
                                        Ada</label>
                                </div>
                            @elseif(Str::contains($lowerName, 'keterlibatan masyarakat'))
                                <select name="{{ $name }}" id="{{ Str::slug($criteria->name) }}"
                                    class="form-select @error($name) is-invalid @enderror" required>
                                    <option value="">-- Pilih Tingkat Keterlibatan --</option>
                                    <option value="ketua" {{ $scoreValue == 4 ? 'selected' : '' }}>Ketua
                                        Organisasi/Komunitas</option>
                                    <option value="pengurus" {{ $scoreValue == 3 ? 'selected' : '' }}>Pengurus
                                        Organisasi/Komunitas</option>
                                    <option value="anggota" {{ $scoreValue == 2 ? 'selected' : '' }}>Anggota Aktif
                                        Organisasi/Komunitas</option>
                                    <option value="tidak_ada_keterlibatan" {{ $scoreValue == 1 ? 'selected' : '' }}>Tidak
                                        Ada</option>
                                </select>
                            @elseif(Str::contains($lowerName, ['domisili 3t', 'difabel']))
                                <select name="{{ $name }}" id="{{ Str::slug($criteria->name) }}"
                                    class="form-select @error($name) is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="0" {{ $scoreValue == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ $scoreValue == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                            @else
                                {{-- Default untuk kriteria lain (misal: Jumlah Tanggungan) --}}
                                <input type="number" step="any" name="{{ $name }}"
                                    id="{{ Str::slug($criteria->name) }}"
                                    class="form-control @error($name) is-invalid @enderror"
                                    placeholder="Masukkan nilai (misal: 3 untuk tanggungan, 85 untuk nilai)"
                                    value="{{ $scoreValue }}" required>
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
                    <i class="fas fa-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Data
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
                'sangat_buruk': [{
                        value: '<_1jt',
                        text: '< Rp 1.000.000'
                    },
                    {
                        value: '1jt_1.5jt',
                        text: 'Rp 1.000.000 - Rp 1.500.000'
                    }
                ],
                'buruk': [{
                        value: '1.5jt_2jt',
                        text: 'Rp 1.500.000 - Rp 2.000.000'
                    },
                    {
                        value: '2jt_2.5jt',
                        text: 'Rp 2.000.000 - Rp 2.500.000'
                    }
                ],
                'cukup': [{
                        value: '2.5jt_3jt',
                        text: 'Rp 2.500.000 - Rp 3.000.000'
                    },
                    {
                        value: '3jt_4jt',
                        text: 'Rp 3.000.000 - Rp 4.000.000'
                    }
                ],
                'baik': [{
                        value: '4jt_5jt',
                        text: 'Rp 4.000.000 - Rp 5.000.000'
                    },
                    {
                        value: '5jt_6jt',
                        text: 'Rp 5.000.000 - Rp 6.000.000'
                    }
                ],
                'sangat_baik': [{
                        value: '6jt_8jt',
                        text: 'Rp 6.000.000 - Rp 8.000.000'
                    },
                    {
                        value: '8jt_10jt',
                        text: 'Rp 8.000.000 - Rp 10.000.000'
                    },
                    {
                        value: '>_10jt',
                        text: '> Rp 10.000.000'
                    }
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

            // Handle old input or existing data on page load
            const initialKondisiEkonomi = kondisiEkonomiSelect.value;
            // Dapatkan nilai Penghasilan Orang Tua yang sudah ada dari PHP
            const initialPenghasilanValue = "{{ $displayValueForPenghasilan ?? '' }}";

            if (initialKondisiEkonomi) {
                updatePenghasilanOptions(initialKondisiEkonomi, initialPenghasilanValue);
            }
        });
    </script>
@endsection
