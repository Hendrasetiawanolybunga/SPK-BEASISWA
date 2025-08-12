{{-- 
    Usage Example for Matrix and Score Components
    This file demonstrates how to use the components in the result-bayes-mairca.blade.php file
--}}

{{-- Example for Raw Matrix --}}
<div id="collapseRawMatrix" class="accordion-collapse collapse" aria-labelledby="headingRawMatrix" data-bs-parent="#maircaProcessAccordion">
    <div class="accordion-body bg-white">
        <p class="text-muted mb-3">Matriks awal berisi nilai asli dari setiap alternatif untuk setiap kriteria sebelum normalisasi.</p>
        
        @php
            // Extract criteria names from the first alternative (if available)
            $criteriaNames = [];
            if (count($maircaProses['raw_matrix']) > 0) {
                $firstAlt = array_key_first($maircaProses['raw_matrix']);
                $criteriaCount = count($maircaProses['raw_matrix'][$firstAlt]);
                
                // Get criteria names from the database if available, otherwise use generic names
                foreach($criterias as $index => $criteria) {
                    if ($index < $criteriaCount) {
                        $criteriaNames[] = $criteria->name;
                    }
                }
                
                // If we couldn't get names from the database, use generic names
                if (count($criteriaNames) === 0) {
                    for ($i = 0; $i < $criteriaCount; $i++) {
                        $criteriaNames[] = 'Kriteria ' . ($i + 1);
                    }
                }
            }
        @endphp
        
        <x-matrix-table 
            title="Raw Matrix" 
            description="Nilai asli dari setiap alternatif untuk setiap kriteria" 
            :matrix="$maircaProses['raw_matrix']" 
            :criteria_names="$criteriaNames" 
        />
    </div>
</div>

{{-- Example for Normalized Matrix --}}
<div id="collapseNormalizedMatrix" class="accordion-collapse collapse" aria-labelledby="headingNormalizedMatrix" data-bs-parent="#maircaProcessAccordion">
    <div class="accordion-body bg-white">
        <p class="text-muted mb-3">Matriks yang telah dinormalisasi untuk menyamakan skala nilai dari berbagai kriteria.</p>
        
        <x-matrix-table 
            title="Normalized Matrix" 
            description="Nilai yang telah dinormalisasi untuk menyamakan skala" 
            :matrix="$maircaProses['normalized_matrix']" 
            :criteria_names="$criteriaNames" 
        />
    </div>
</div>

{{-- Example for Ideal Weights --}}
<div id="collapseIdealWeights" class="accordion-collapse collapse" aria-labelledby="headingIdealWeights" data-bs-parent="#maircaProcessAccordion">
    <div class="accordion-body bg-white">
        <p class="text-muted mb-3">Bobot ideal yang digunakan untuk menghitung deviasi dari setiap alternatif.</p>
        
        <x-ideal-weights-table 
            title="Ideal Weights" 
            description="Bobot ideal untuk setiap kriteria dan alternatif" 
            :weights="$maircaProses['ideal_weights']" 
            :criteria_names="$criteriaNames" 
        />
    </div>
</div>

{{-- Example for Final Scores --}}
<div id="collapseFinalScores" class="accordion-collapse collapse" aria-labelledby="headingFinalScores" data-bs-parent="#maircaProcessAccordion">
    <div class="accordion-body bg-white">
        <p class="text-muted mb-3">Skor akhir yang menunjukkan deviasi setiap alternatif dari nilai ideal. Semakin kecil nilai deviasi, semakin baik peringkat alternatif.</p>
        
        <x-final-scores-table 
            title="Final Scores (Deviasi)" 
            description="Skor akhir yang menentukan peringkat alternatif" 
            :scores="$maircaProses['final_scores']" 
            method="mairca" 
        />
    </div>
</div>

{{-- 
    For MOORA method, the usage would be similar but with different data and method parameter:
    
    <x-matrix-table 
        title="Raw Matrix" 
        description="Nilai asli dari setiap alternatif untuk setiap kriteria" 
        :matrix="$mooraProses['raw_matrix']" 
        :criteria_names="$criteriaNames" 
    />
    
    <x-denominators-table 
        title="Denominators" 
        description="Akar dari jumlah kuadrat nilai untuk setiap kriteria" 
        :denominators="$mooraProses['denominators']" 
        :criteria_names="$criteriaNames" 
    />
    
    <x-matrix-table 
        title="Normalized Matrix" 
        description="Nilai yang telah dinormalisasi dengan membagi nilai asli dengan denominator" 
        :matrix="$mooraProses['normalized_matrix']" 
        :criteria_names="$criteriaNames" 
    />
    
    <x-final-scores-table 
        title="Final Scores" 
        description="Skor akhir yang menentukan peringkat alternatif" 
        :scores="$mooraProses['final_scores']" 
        method="moora" 
    />
--}}