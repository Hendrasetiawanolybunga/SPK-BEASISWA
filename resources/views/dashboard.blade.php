    @extends('layouts.app')

    @section('content')
    <div class="container mt-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold text-primary">Dashboard Admin</h3>
                <p class="lead text-muted">Selamat datang kembali, {{ Auth::guard('admin')->user()->username }}!</p>
            </div>
            <div class="col-md-4 text-md-end">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- Card Total Alternatif --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100 border-start border-primary border-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div class="col">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Alternatif</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalAlternatives }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <a href="{{ route('alternatives.index') }}" class="text-primary text-decoration-none small">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            {{-- Card Total Kriteria --}}
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100 border-start border-success border-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-success"></i>
                            </div>
                            <div class="col">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Kriteria</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalCriterias }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <a href="{{ route('criteria.index') }}" class="text-success text-decoration-none small">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            {{-- Card Informasi Tambahan / Quick Links --}}
            <div class="col-md-12 col-lg-4 mb-4">
                <div class="card shadow-sm h-100 border-start border-info border-4">
                    <div class="card-body">
                        <h5 class="card-title text-info fw-bold mb-3">Aksi Cepat</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><a href="{{ route('admin.profile.edit') }}" class="text-decoration-none text-dark"><i class="fas fa-user-edit me-2"></i> Kelola Profil Admin</a></li>
                            <li class="mb-2"><a href="{{ route('admin.password.change.form') }}" class="text-decoration-none text-dark"><i class="fas fa-key me-2"></i> Ubah Password</a></li>
                            <li><a href="{{ route('alternatives.result-moora') }}" class="text-decoration-none text-dark"><i class="fas fa-calculator me-2"></i> Lihat Hasil Perhitungan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian untuk informasi atau grafik lainnya bisa ditambahkan di sini --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold text-secondary">
                        Informasi Sistem
                    </div>
                    <div class="card-body">
                        <p>Sistem Pendukung Keputusan (SPK) Beasiswa ini dirancang untuk membantu dalam proses pengambilan keputusan pemberian beasiswa berdasarkan kriteria yang telah ditentukan.</p>
                        <p>Pastikan data alternatif dan kriteria selalu diperbarui untuk hasil perhitungan yang akurat.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
    