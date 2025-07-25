<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SPK Beasiswa</title>
    <!-- Google Fonts: Poppins (for modern typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0f2f7 0%, #cce7f5 100%);
            display: flex;
            flex-direction: column; /* Changed to column to place marquee at bottom */
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative; /* For absolute positioning of marquee */
        }
        .login-card {
            background-color: #ffffff;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.8s ease-out;
            z-index: 1; /* Ensure card is above marquee */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-card h3 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 2.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        /* Input group styling for icons */
        .input-group .form-control {
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }
        .input-group .input-group-text {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-right: none;
            border-radius: 0.5rem 0 0 0.5rem; /* Rounded left side */
            padding: 0.75rem 1rem;
            color: #495057;
        }
        .input-group:focus-within .input-group-text {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
            z-index: 1; /* Ensure it's above the input border */
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        /* Password toggle icon styling */
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10; /* Ensure it's clickable */
        }
        .password-input-group {
            position: relative; /* Needed for absolute positioning of toggle icon */
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #003f7f);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
        }
        .alert {
            border-radius: 0.75rem;
            font-size: 0.95rem;
            padding: 1rem 1.25rem;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .form-check-label {
            color: #6c757d;
        }

        /* Running Text (Marquee) Styling */
        .running-text-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 123, 255, 0.8); /* Semi-transparent primary blue */
            color: white;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            font-weight: 500;
            overflow: hidden;
            white-space: nowrap;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 0; /* Ensure it's behind the login card */
        }

        .running-text-content {
            display: inline-block;
            padding-left: 100%; /* Start off-screen */
            animation: marquee 15s linear infinite; /* Adjust duration as needed */
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        /* Adjust for smaller screens if necessary */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem;
                margin: 1rem; /* Add some margin on small screens */
            }
            .login-card h3 {
                font-size: 1.75rem;
                margin-bottom: 2rem;
            }
            .form-control-lg {
                padding: 0.65rem 0.85rem;
                font-size: 0.9rem;
            }
            .btn-primary {
                padding: 0.65rem 1.25rem;
                font-size: 1rem;
            }
            .running-text-container {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="login-card">
                    <h3 class="text-center mb-5 fw-bold">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>Login Admin
                    </h3>

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
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                                    placeholder="Masukkan Username Anda" required autofocus>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group password-input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password Anda" required>
                                <span class="password-toggle" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            {{-- Link lupa password bisa ditambahkan di sini jika ada rutenya --}}
                            {{-- <a href="{{ route('admin.password.request') }}" class="text-primary text-decoration-none fw-semibold">Lupa Password?</a> --}}
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Running Text at the bottom -->
    <div class="running-text-container">
        <div class="running-text-content">
            "Jika anda ingin berjalan cepat, maka jalanlah sendiri, tapi jika anda ingin berjalan jauh, maka jalanlah bersama-sama, salam titik koma <strong>;</strong> - TCP"
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the eye icon
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>
