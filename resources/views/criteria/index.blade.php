@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center"><i class="fas fa-list-alt me-2"></i>Data Kriteria</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">
                <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="fw-semibold">
                <i class="fas fa-balance-scale me-1"></i>Total Bobot:
                <span id="bobot-summary" class="fw-bold"></span>
            </div>
            {{-- <a href="{{ route('criteria.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>Tambah Kriteria
            </a> --}}
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-primary">
                            <tr>
                                <th><i class="fas fa-tag"></i> Nama</th>
                                <th><i class="fas fa-layer-group"></i> Jenis</th>
                                <th class="text-center"> <i class="fas fa-percentage"></i> Bobot</th>
                                <th class="text-center"> <i class="fas fa-tools"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($criterias as $c)
                                <tr>
                                    <td>{{ $c->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $c->type == 'benefit' ? 'success' : 'danger' }}">
                                            {{ ucfirst($c->type) }}
                                        </span>
                                    </td>
                                    <td class="bobot text-center">{{ $c->weight }}</td>
                                    <td class="text-center" class="text-center">
                                        <a href="{{ route('criteria.edit', $c->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($criterias->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center text-muted fst-italic">Belum ada data kriteria.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.bobot');
            let total = 0;

            rows.forEach(cell => {
                const val = parseFloat(cell.textContent);
                if (!isNaN(val)) total += val;
            });

            const summary = document.getElementById('bobot-summary');
            total = total.toFixed(2);

            if (total > 1) {
                summary.innerHTML = `<span class="text-danger">${total}</span> ⚠️ (Melebihi 1.0)`;
            } else if (total < 1) {
                summary.innerHTML = `<span class="text-warning">${total}</span> 🔔 (Kurang dari 1.0)`;
            } else {
                summary.innerHTML = `<span class="text-success">${total}</span> ✅ (Tepat 1.0)`;
            }
        });
    </script>
@endsection
