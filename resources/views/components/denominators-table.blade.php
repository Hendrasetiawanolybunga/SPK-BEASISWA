{{-- 
    Denominators Table Component
    This component displays the denominators used in the MOORA method.
    
    Parameters:
    - title: The title of the table
    - description: A short description of what the table shows
    - denominators: The denominator values (array)
    - criteria_names: Array of criteria names to use as row headers
--}}

@props(['title', 'description', 'denominators', 'criteria_names'])

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">{{ $title }}</h5>
        @if(isset($description))
            <p class="text-muted mb-0 mt-2">{{ $description }}</p>
        @endif
    </div>
    <div class="card-body p-0">
        @if(count($denominators) > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4"><i class="fas fa-balance-scale me-1"></i> Kriteria</th>
                            <th class="py-3 px-4 text-center"><i class="fas fa-calculator me-1"></i> Nilai Denominator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denominators as $index => $value)
                            <tr>
                                <td class="px-4 fw-medium">
                                    {{ $criteria_names[$index] ?? 'Kriteria ' . ($index + 1) }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($value, 6) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center">
                <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                <p class="mb-0">Tidak ada data yang tersedia.</p>
            </div>
        @endif
    </div>
</div>