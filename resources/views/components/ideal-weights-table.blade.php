{{-- 
    Ideal Weights Table Component
    This component displays the ideal weights used in the MAIRCA method.
    
    Parameters:
    - title: The title of the table
    - description: A short description of what the table shows
    - weights: The ideal weights values (array)
    - criteria_names: Array of criteria names to use as row headers
--}}

@props(['title', 'description', 'weights', 'criteria_names'])

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">{{ $title }}</h5>
        @if(isset($description))
            <p class="text-muted mb-0 mt-2">{{ $description }}</p>
        @endif
    </div>
    <div class="card-body p-0">
        @if(count($weights) > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4"><i class="fas fa-balance-scale me-1"></i> Kriteria</th>
                            <th class="py-3 px-4 text-center"><i class="fas fa-weight-hanging me-1"></i> Bobot Ideal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weights as $altName => $altWeights)
                            @php $criteriaCounter = 0; @endphp
                            @foreach($altWeights as $criteriaName => $value)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">
                                                @if(is_numeric($criteriaName))
                                                    {{ $criteria_names[$criteriaName] ?? 'Kriteria ' . ($criteriaCounter + 1) }}
                                                @else
                                                    {{ $criteriaName }}
                                                @endif
                                            </span>
                                            <span class="badge bg-secondary ms-2">{{ $altName }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="progress me-2" style="width: 100px; height: 8px;">
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                    style="width: {{ min($value * 100, 100) }}%" 
                                                    aria-valuenow="{{ $value * 100 }}" 
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span>{{ number_format($value, 6) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @php $criteriaCounter++; @endphp
                            @endforeach
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