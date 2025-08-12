{{-- 
    Matrix Table Component
    This component displays a matrix (raw or normalized) in a clean, responsive HTML table.
    
    Parameters:
    - title: The title of the table
    - description: A short description of what the table shows
    - matrix: The matrix data to display (associative array where keys are alternative names)
    - criteria_names: Array of criteria names to use as column headers
--}}

@props(['title', 'description', 'matrix', 'criteria_names'])

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">{{ $title }}</h5>
        @if(isset($description))
            <p class="text-muted mb-0 mt-2">{{ $description }}</p>
        @endif
    </div>
    <div class="card-body p-0">
        @if(count($matrix) > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4"><i class="fas fa-user me-1"></i> Nama Alternatif</th>
                            @foreach($criteria_names as $criteria)
                                <th class="py-3 px-3 text-center">{{ $criteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matrix as $altName => $values)
                            <tr>
                                <td class="px-4 fw-medium">{{ $altName }}</td>
                                @foreach($values as $index => $value)
                                    <td class="text-center">
                                        {{ number_format($value, 3) }}
                                    </td>
                                @endforeach
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