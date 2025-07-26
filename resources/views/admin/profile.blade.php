    @extends('layouts.app') {{-- Menggunakan layout utama Anda --}}

    @section('content')
        <style>
            /* CSS kustom ini bisa dipindahkan ke file CSS terpisah jika diinginkan */
            .card-custom {
                background-color: #ffffff;
                padding: 2.5rem;
                border-radius: 0.75rem;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 600px;
                /* Lebar card disesuaikan untuk satu kolom */
                margin: auto;
                /* Untuk centering di dalam container */
            }

            .form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }

            .btn-primary {
                background-color: #0d6efd;
                border-color: #0d6efd;
                transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out, transform 0.2s ease-in-out;
            }

            .btn-primary:hover {
                background-color: #0b5ed7;
                border-color: #0a58ca;
                transform: translateY(-2px);
            }

            .alert {
                border-radius: 0.5rem;
            }

            /* Penyesuaian untuk border antara kolom (tidak lagi relevan tapi bisa disimpan jika akan digunakan lagi) */
            .border-right-md {
                border-right: none;
                /* Dihapus karena tidak ada kolom samping */
            }

            @media (max-width: 767.98px) {
                .border-right-md {
                    border-right: none;
                    border-bottom: none;
                    padding-bottom: 0;
                    margin-bottom: 0;
                }
            }
        </style>

        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6"> {{-- Lebar kolom disesuaikan untuk satu kolom --}}
                    <div class="card-custom">
                        <h3 class="text-center mb-5 fw-bold text-dark">Kelola Profil Admin</h3>

                        <!-- Pesan Error Validasi Global -->
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

                        {{-- Pesan Sukses/Error dari session --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Kolom Utama: Username & Email --}}
                                <div class="col-12"> {{-- Menggunakan col-12 untuk satu kolom penuh --}}
                                    <h4 class="mb-4 text-dark">Informasi Dasar</h4>

                                    {{-- Input Username --}}
                                    <div class="mb-4">
                                        <label for="username" class="form-label fw-semibold text-muted">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control form-control-lg @error('username') is-invalid @enderror"
                                            value="{{ old('username', Auth::guard('admin')->user()->username) }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Input Email --}}
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold text-muted">Email</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            value="{{ old('email', Auth::guard('admin')->user()->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Kolom Kanan (Password) dihapus sepenuhnya --}}
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg mt-2">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
