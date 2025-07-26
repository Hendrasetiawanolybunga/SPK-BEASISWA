    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SPK Beasiswa</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome Free CDN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

        <!-- FontAwesome CDN (Pastikan ini tidak duplikat dengan yang di atas jika sudah ada di 6.5.0) -->
        {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
        {{-- Jika Anda sudah menggunakan 6.5.0, baris di atas mungkin tidak perlu --}}

        <style>
            body {
                background-color: #f8f9fa;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            main {
                flex: 1;
            }

            footer {
                background-color: #f1f1f1;
                color: #555;
                font-size: 0.9rem;
            }

            /* Menambahkan sedikit gaya untuk dropdown agar terlihat lebih baik */
            .dropdown-menu {
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .dropdown-item {
                padding: 0.75rem 1rem;
            }

            .dropdown-item:hover {
                background-color: #f0f0f0;
            }
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-5">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-1"></i> SPK Beasiswa
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="{{ route('alternatives.index') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-user-graduate"></i> Alternatif
                </a>

                <a href="{{ route('criteria.index') }}" class="btn btn-outline-success me-2">
                    <i class="fas fa-clipboard-list"></i> Kriteria
                </a>

                <div class="dropdown me-2">
                    <button class="btn btn-info dropdown-toggle" type="button" id="lihatHasilDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-line"></i> Lihat Hasil
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="lihatHasilDropdown">
                        {{-- Link ke hasil kombinasi Bayes-MOORA --}}
                        <li><a class="dropdown-item" href="{{ route('alternatives.result-bayes-moora') }}">
                                <i class="fas fa-chart-pie me-2"></i> BAYES-MOORA
                            </a></li>
                        {{-- Link ke hasil kombinasi Bayes-MAIRCA --}}
                        <li><a class="dropdown-item" href="{{ route('alternatives.result-bayes-mairca') }}">
                                <i class="fas fa-chart-pie me-2"></i> BAYES-MAIRCA
                            </a></li>
                    </ul>
                </div>

                <div class="dropdown me-5">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="lihatHasilDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-tools me-1"></i> Admin
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="lihatHasilDropdown">
                        {{-- Link ke Kelola Profil Admin --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i> Kelola Profil Admin
                            </a>
                        </li>

                        {{-- Link ke Ubah Password --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.password.change.form') }}">
                                <i class="fas fa-key me-2"></i> Ubah Password
                            </a>
                        </li>

                        {{-- Tombol Logout --}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout dari Sistem
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Konten -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center py-3 border-top mt-auto">
            <div>
                <i class="far fa-copyright"></i>
                <span class="ms-1">2025 SPK Beasiswa — Dibuat oleh Tim <strong>TCP</strong></span>
            </div>
        </footer>

        <!-- Bootstrap JS (opsional, jika ingin interaktivitas) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
