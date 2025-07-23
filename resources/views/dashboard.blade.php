@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-3">Selamat Datang di Dashboard Admin</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <p class="lead">Gunakan navbar atau menu navigasi untuk mengakses dan mengelola data sistem.</p>

    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </button>
    </form>
</div>
@endsection
