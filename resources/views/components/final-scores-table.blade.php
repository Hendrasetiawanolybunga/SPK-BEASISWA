{{-- 
    Final Scores Table Component
    This component displays the final scores in a clean, responsive HTML table with visual indicators.
    
    Parameters:
    - title: The title of the table
    - description: A short description of what the table shows
    - scores: The final scores data (associative array where keys are alternative names)
    - method: The method used ('moora' or 'mairca')
--}}

@props(['title', 'description', 'scores', 'method'])

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">{{ $title }}</h5>
        @if(isset($description))
            <p class="text-muted mb-0 mt-2">{{ $description }}</p>
        @endif
    </div>
    <div class="card-body p-0">
        @if(count($scores) > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4" style="width: 50px;"><i class="fas fa-trophy me-1"></i> Rank</th>
                            <th class="py-3 px-4"><i class="fas fa-user me-1"></i> Nama Alternatif</th>
                            
                            @if($method === 'moora')
                                <th class="py-3 px-4"><i class="fas fa-plus-circle text-success me-1"></i> Benefit Score</th>
                                <th class="py-3 px-4"><i class="fas fa-minus-circle text-danger me-1"></i> Cost Score</th>
                            @endif
                            
                            <th class="py-3 px-4">
                                @if($method === 'moora')
                                    <i class="fas fa-equals text-primary me-1"></i> Final Score
                                @else
                                    <i class="fas fa-chart-line text-warning me-1"></i> Deviasi Score
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            // Sort scores based on method
                            $sortedScores = $scores;
                            if ($method === 'moora') {
                                // For MOORA, higher scores are better
                                uasort($sortedScores, function($a, $b) {
                                    return $b['final_score'] <=> $a['final_score'];
                                });
                            } else {
                                // For MAIRCA, lower scores are better
                                uasort($sortedScores, function($a, $b) {
                                    $scoreA = is_array($a) && isset($a['final_deviation']) ? $a['final_deviation'] : (is_numeric($a) ? $a : 0);
                                    $scoreB = is_array($b) && isset($b['final_deviation']) ? $b['final_deviation'] : (is_numeric($b) ? $b : 0);
                                    return $scoreA <=> $scoreB;
                                });
                            }
                            $rank = 1;
                        @endphp
                        
                        @foreach($sortedScores as $altName => $scoreData)
                            @php
                                $isTopRank = $rank <= 3;
                                $bgClass = $isTopRank ? 'table-' . ($method === 'moora' ? 'success' : 'warning') . ' bg-opacity-10' : '';
                                
                                // Get the score value based on method
                                if ($method === 'moora') {
                                    $finalScore = $scoreData['final_score'];
                                    $benefitScore = $scoreData['benefit_score'];
                                    $costScore = $scoreData['cost_score'];
                                } else {
                                    // Handle MAIRCA data structure which contains deviation_details and final_deviation
                                    $finalScore = is_array($scoreData) && isset($scoreData['final_deviation']) 
                                        ? $scoreData['final_deviation'] 
                                        : (is_numeric($scoreData) ? $scoreData : 0);
                                }
                            @endphp
                            
                            <tr class="{{ $bgClass }}">
                                <td class="text-center px-4">
                                    @if($rank == 1)
                                        <span class="badge bg-{{ $method === 'moora' ? 'success' : 'warning' }} rounded-pill px-3 py-2">
                                            <i class="fas fa-crown me-1"></i> {{ $rank }}
                                        </span>
                                    @elseif($rank <= 3)
                                        <span class="badge bg-info text-dark rounded-pill px-3 py-2">{{ $rank }}</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $rank }}</span>
                                    @endif
                                </td>
                                <td class="px-4 fw-medium">{{ $altName }}</td>
                                
                                @if($method === 'moora')
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                    style="width: {{ min($benefitScore * 100, 100) }}%" 
                                                    aria-valuenow="{{ $benefitScore * 100 }}" 
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span>{{ number_format($benefitScore, 6) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                <div class="progress-bar bg-danger" role="progressbar" 
                                                    style="width: {{ min($costScore * 100, 100) }}%" 
                                                    aria-valuenow="{{ $costScore * 100 }}" 
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span>{{ number_format($costScore, 6) }}</span>
                                        </div>
                                    </td>
                                @endif
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $method === 'moora' ? 'primary' : 'warning' }}" role="progressbar" 
                                                style="width: {{ min(abs($finalScore) * 100, 100) }}%" 
                                                aria-valuenow="{{ abs($finalScore) * 100 }}" 
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="fw-bold">{{ number_format($finalScore, 6) }}</span>
                                    </div>
                                    <small class="text-muted">
                                        @if($method === 'moora')
                                            Semakin tinggi nilai, semakin baik peringkat
                                        @else
                                            Semakin kecil nilai, semakin baik peringkat
                                        @endif
                                    </small>
                                </td>
                            </tr>
                            @php $rank++; @endphp
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