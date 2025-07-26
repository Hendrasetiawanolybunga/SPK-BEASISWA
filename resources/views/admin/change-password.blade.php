@extends('layouts.app')

@section('content')
    <style>
        .card-custom {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: auto;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            transform: translateY(-2px);
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        .alert {
            border-radius: 0.5rem;
        }
    </style>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <div class="card-custom">
                    <h3 class="text-center mb-5 fw-bold text-dark">Ubah Password Admin</h3>

                    {{-- Validasi Error --}}
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

                    {{-- Session Messages --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf

                        {{-- Password Saat Ini --}}
                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-semibold text-muted">Password Saat
                                Ini</label>
                            <div class="input-group password-input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control form-control-lg @error('current_password') is-invalid @enderror"
                                    placeholder="Masukkan Password Saat Ini" autocomplete="off" required>
                                <span class="password-toggle" id="toggleCurrentPassword">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                                @error('current_password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Password Baru --}}
                        <div class="mb-4">
                            <label for="new_password" class="form-label fw-semibold text-muted">Password Baru</label>
                            <div class="input-group password-input-group">
                                <input type="password" id="new_password" name="new_password"
                                    class="form-control form-control-lg @error('new_password') is-invalid @enderror"
                                    placeholder="Masukkan Password Baru" required>
                                <span class="password-toggle" id="toggleNewPassword">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                                @error('new_password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Konfirmasi Password Baru --}}
                        <div class="mb-5">
                            <label for="new_password_confirmation" class="form-label fw-semibold text-muted">Konfirmasi
                                Password Baru</label>
                            <div class="input-group password-input-group">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="form-control form-control-lg" placeholder="Masukkan Ulang Password Baru"
                                    required>
                                <span class="password-toggle" id="toggleNewPasswordConfirm">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Ubah Password
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

    {{-- Toggle Show/Hide Password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = [{
                    toggleId: 'toggleCurrentPassword',
                    inputId: 'current_password'
                },
                {
                    toggleId: 'toggleNewPassword',
                    inputId: 'new_password'
                },
                {
                    toggleId: 'toggleNewPasswordConfirm',
                    inputId: 'new_password_confirmation'
                }
            ];

            toggles.forEach(item => {
                const toggle = document.getElementById(item.toggleId);
                const input = document.getElementById(item.inputId);

                if (toggle && input) {
                    toggle.addEventListener('click', function() {
                        const type = input.type === 'password' ? 'text' : 'password';
                        input.type = type;

                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    });
                }
            });
        });
    </script>
@endsection
