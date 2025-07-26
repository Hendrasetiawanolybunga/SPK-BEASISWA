@extends('layouts.app')

@section('content')
    <style>
        /* Custom CSS for Dashboard Enhancements (UI/UX Focused) */

        /* Global Animations & Transitions */
        body {
            background-color: #f0f2f5;
            /* Lighter, modern background */
        }

        .card,
        .btn,
        .list-group-item {
            transition: all 0.3s ease-in-out;
            /* Smooth transitions for all interactive elements */
        }

        /* Dashboard Header Section */
        .dashboard-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            /* Deeper, more vibrant gradient */
            color: white;
            padding: 3rem 0;
            /* More vertical padding */
            border-radius: 1rem;
            /* More rounded corners */
            margin-bottom: 2.5rem;
            /* More space below header */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
            /* Stronger, softer shadow */
            position: relative;
            overflow: hidden;
            animation: fadeInDown 0.8s ease-out;
            /* Subtle fade-in from top */
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.08);
            /* More visible overlay */
            transform: rotate(45deg);
            pointer-events: none;
        }

        .dashboard-header h3 {
            font-size: 3.2rem;
            /* Even larger font for strong impact */
            margin-bottom: 0.75rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            /* More defined text shadow */
            font-weight: 700;
            /* Bolder */
        }

        .dashboard-header p {
            font-size: 1.3rem;
            /* Larger lead text */
            opacity: 0.95;
        }

        .dashboard-header .fa-3x {
            font-size: 4em;
            /* Very large icon for hero section */
            color: rgba(255, 255, 255, 0.9);
            animation: pulse 2s infinite ease-in-out;
            /* Gentle pulse animation */
        }

        /* Stat Cards */
        .card-stat {
            border-radius: 1rem;
            /* Consistent rounded corners */
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            /* Initial subtle shadow */
            animation: fadeInUp 0.8s ease-out forwards;
            /* Fade in from bottom */
            opacity: 0;
            /* Start invisible for animation */
        }

        .card-stat:nth-child(1) {
            animation-delay: 0.2s;
        }

        /* Stagger animation */
        .card-stat:nth-child(2) {
            animation-delay: 0.4s;
        }

        .card-stat:nth-child(3) {
            animation-delay: 0.6s;
        }


        .card-stat:hover {
            transform: translateY(-12px) scale(1.03);
            /* More pronounced lift and enlarge */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            /* Deeper, more dramatic shadow */
        }

        .card-stat .card-body {
            padding: 2rem;
            /* More padding inside cards */
        }

        .card-stat .card-footer {
            background-color: rgba(0, 0, 0, 0.05);
            /* Slightly darker footer for contrast */
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .card-stat .fa-3x {
            font-size: 3.5em;
            /* Larger icons within cards */
        }

        .card-stat .h3 {
            font-size: 2.5rem;
            /* Larger numbers */
        }

        /* Quick Links Card Styling */
        .card-quick-links {
            border-radius: 1rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            animation-delay: 0.8s;
            /* Stagger animation */
        }

        .card-quick-links .card-body {
            padding: 2rem;
        }

        .card-quick-links .list-group-item {
            border: none;
            padding: 1rem 1.25rem;
            /* More padding */
            transition: background-color 0.2s ease-in-out, transform 0.15s ease-in-out;
            border-radius: 0.75rem;
            /* More rounded list items */
            margin-bottom: 0.5rem;
            /* More space between items */
            font-weight: 500;
            /* Slightly bolder text */
        }

        .card-quick-links .list-group-item:last-child {
            margin-bottom: 0;
        }

        .card-quick-links .list-group-item:hover {
            background-color: #f0f2f5;
            /* Lighter hover background */
            transform: translateX(8px);
            /* More pronounced slide effect */
        }

        .card-quick-links .list-group-item i {
            width: 30px;
            /* Wider fixed width for icons */
            text-align: center;
            font-size: 1.2em;
            /* Slightly larger icons */
        }

        /* Info System Card Styling */
        .card-info-system {
            border-radius: 1rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            animation-delay: 1s;
            /* Stagger animation */
        }

        .card-info-system .card-header {
            background: linear-gradient(45deg, #6c757d 0%, #495057 100%);
            /* Darker gradient header */
            color: white;
            border-bottom: none;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            font-size: 1.2rem;
            /* Larger header text */
            font-weight: 600;
            padding: 1.25rem 1.5rem;
        }

        .card-info-system .card-body {
            background-color: #ffffff;
            /* White background for body */
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            padding: 1.5rem;
        }

        /* Logout Button Styling */
        .btn-logout-dashboard {
            background-color: #dc3545;
            /* Red */
            border-color: #dc3545;
            font-weight: bold;
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            border-radius: 0.75rem;
            box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
            /* Red shadow */
        }

        .btn-logout-dashboard:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-5px);
            /* More pronounced lift */
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
            /* Stronger shadow on hover */
        }

        /* Keyframe Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <div class="container mt-5">
        {{-- Dynamic Welcome Header (Hero Section) --}}
        <div class="dashboard-header text-center py-5 px-4 mb-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-auto">
                    <i class="fas fa-hand-sparkles fa-3x mb-3 d-block mx-auto"></i> {{-- Larger, central icon with pulse --}}
                </div>
                <div class="col-12 col-md-auto">
                    <h3 class="fw-bold">Selamat Datang di Dashboard Admin</h3>
                    <p class="lead">Halo, {{ Auth::guard('admin')->user()->username }}! Mari kelola sistem beasiswa Anda.
                    </p>
                </div>
            </div>
            {{-- Logout button moved to navbar for better UX consistency --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- Card Total Alternatif --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ route('alternatives.index') }}" class="text-decoration-none">
                    <div class="card card-stat h-100 border-start border-primary border-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-3x text-primary"></i> {{-- Icon lebih relevan --}}
                                </div>
                                <div class="col">
                                    <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Alternatif</div>
                                    <div class="h3 mb-0 fw-bold text-gray-800" data-target="{{ $totalAlternatives }}">0
                                    </div> {{-- Data target untuk counter --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-end">
                            <span class="text-primary small fw-bold">Lihat Detail <i
                                    class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Total Kriteria --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ route('criteria.index') }}" class="text-decoration-none">
                    <div class="card card-stat h-100 border-start border-success border-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-3x text-success"></i> {{-- Icon lebih relevan --}}
                                </div>
                                <div class="col">
                                    <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Kriteria</div>
                                    <div class="h3 mb-0 fw-bold text-gray-800" data-target="{{ $totalCriterias }}">0</div>
                                    {{-- Data target untuk counter --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-end">
                            <span class="text-success small fw-bold">Lihat Detail <i
                                    class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Card Aksi Cepat --}}
            <div class="col-md-12 col-lg-4 mb-4">
                <div class="card card-quick-links shadow-sm h-100 border-start border-warning border-4">
                    <div class="card-body">
                        <h5 class="card-title text-warning fw-bold mb-3">
                            <i class="fas fa-tools me-1"></i> Aksi Cepat
                        </h5>
                        <div class="list-group list-group-flush"> {{-- Menggunakan list-group-flush untuk borderless --}}
                            <a href="{{ route('admin.profile.edit') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-user-edit me-3 text-secondary"></i> Kelola Profil Admin
                            </a>
                            <a href="{{ route('admin.password.change.form') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="fas fa-key me-3 text-dark"></i> Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Informasi Sistem --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-info-system shadow-sm">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i> Informasi Sistem SPK Beasiswa
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Sistem Pendukung Keputusan (SPK) Beasiswa ini dirancang untuk membantu dalam
                            proses pengambilan keputusan pemberian beasiswa berdasarkan kriteria yang telah ditentukan.</p>
                        <p class="mb-0">Pastikan data alternatif dan kriteria selalu diperbarui untuk hasil perhitungan
                            yang akurat dan relevan. Gunakan menu navigasi di atas untuk mengakses berbagai fitur.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-center mt-5 mb-5">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-logout-dashboard btn-lg"
                    onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout dari Sistem
                </button>
            </form>
        </div>

    </div>

    <script>
        // JavaScript for Counter Animation (Intersection Observer for better performance)
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.h3[data-target]');

            const animateCounter = (counter) => {
                const target = +counter.getAttribute('data-target');
                const speed = 200; // The lower the speed, the faster the counter
                const increment = target / speed;

                let current = 0;
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.innerText = Math.ceil(current);
                        setTimeout(updateCounter, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCounter();
            };

            // Use Intersection Observer for animation when elements enter viewport
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounter(entry.target);
                            observer.unobserve(entry.target); // Stop observing once animated
                        }
                    });
                }, {
                    threshold: 0.5
                }); // Trigger when 50% of element is visible

                counters.forEach(counter => {
                    observer.observe(counter);
                });
            } else {
                // Fallback for browsers that don't support Intersection Observer
                counters.forEach(animateCounter);
            }
        });
    </script>
@endsection
