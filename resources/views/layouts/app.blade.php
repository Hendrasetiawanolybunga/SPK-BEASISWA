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

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

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
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-5">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('alternatives.index') }}">
            <i class="fas fa-graduation-cap me-1"></i> SPK Beasiswa
        </a>
        <div class="ms-auto d-flex">
            <a href="{{ route('criteria.index') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-list"></i> Kriteria
            </a>

            <div class="dropdown">
                <button class="btn btn-info text-white dropdown-toggle" type="button" id="lihatHasilDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chart-line"></i> Lihat Hasil
                </button>
                <ul class="dropdown-menu" aria-labelledby="lihatHasilDropdown">
                    <li><a class="dropdown-item" href="{{ route('alternatives.result-bayes') }}">BAYES</a></li>
                    <li><a class="dropdown-item" href="{{ route('alternatives.result-moora') }}">MOORA</a></li>
                    <li><a class="dropdown-item" href="{{ route('alternatives.result-mairca') }}">MAIRCA</a></li>
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
            <span class="ms-1">2025 SPK Beasiswa — Dibuat oleh Tim <strong>BlueCode46</strong></span>
        </div>
    </footer>

    <!-- Bootstrap JS (opsional, jika ingin interaktivitas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
