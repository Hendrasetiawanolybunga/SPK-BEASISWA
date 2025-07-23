<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Pastikan font Poppins tersedia atau ganti dengan font sistem */
            background-color: #f8f9fa;
            display: flex; /* Menggunakan flexbox untuk centering */
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            min-height: 100vh; /* Minimum height of viewport */
            margin: 0; /* Remove default body margin */
        }
        .login-card {
            background-color: #ffffff;
            padding: 2.5rem; /* Increased padding */
            border-radius: 0.75rem; /* More rounded corners */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Stronger shadow */
            width: 100%;
            max-width: 420px; /* Slightly wider card */
        }
        .form-control:focus {
            border-color: #0d6efd; /* Bootstrap primary color */
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
            transform: translateY(-2px); /* Slight lift effect on hover */
        }
        .alert {
            border-radius: 0.5rem; /* Rounded alerts */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="login-card">
                    <h3 class="text-center mb-5 fw-bold text-dark">Login Admin</h3>

                    <!-- Pesan Error Validasi -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 list-unstyled"> {{-- list-unstyled untuk menghilangkan bullet --}}
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Pesan Sukses/Error dari session (jika ada) --}}
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

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="username" class="form-label fw-semibold text-muted">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                   class="form-control form-control-lg" {{-- form-control-lg untuk ukuran lebih besar --}}
                                   required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-muted">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control form-control-lg"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-muted" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            {{-- Link lupa password akan ditambahkan nanti --}}
                            <a href="#" class="text-primary text-decoration-none fw-semibold">Lupa Password?</a>
                        </div>

                        <div class="d-grid gap-2"> {{-- d-grid untuk button full width --}}
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
