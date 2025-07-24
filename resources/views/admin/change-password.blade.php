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
        max-width: 500px; /* Lebar card yang sedikit lebih besar */
        margin: auto; /* Untuk centering di dalam container */
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
</style>

<div class="container mt-5 mb-5"> {{-- Menambahkan margin-bottom agar tidak terlalu mepet --}}
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <div class="card-custom">
                <h3 class="text-center mb-5 fw-bold text-dark">Ubah Password Admin</h3>

                <!-- Pesan Error Validasi -->
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
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.password.update') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="current_password" class="form-label fw-semibold text-muted">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                               class="form-control form-control-lg @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="form-label fw-semibold text-muted">Password Baru</label>
                        <input type="password" id="new_password" name="new_password"
                               class="form-control form-control-lg @error('new_password') is-invalid @enderror" required>
                        @error('new_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="new_password_confirmation" class="form-label fw-semibold text-muted">Konfirmasi Password Baru</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                               class="form-control form-control-lg" required>
                    </div>

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
@endsection
