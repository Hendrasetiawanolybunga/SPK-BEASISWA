<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Criteria::truncate(); // Pastikan tabel kosong sebelum menambahkan data baru

        $criterias = [
            [
                'name' => 'Prestasi Akademik',
                'type' => 'benefit',
                'weight' => 0.16, // Disesuaikan dari 0.15
                'bayes_probability' => 0.95
            ],
            [
                'name' => 'Prestasi Non-Akademik',
                'type' => 'benefit',
                'weight' => 0.11, // Disesuaikan dari 0.10
                'bayes_probability' => 0.8
            ],
            [
                'name' => 'Domisili 3T',
                'type' => 'benefit',
                'weight' => 0.11, // Disesuaikan dari 0.10
                'bayes_probability' => 0.9
            ],
            [
                'name' => 'Difabel',
                'type' => 'benefit',
                'weight' => 0.10, // Tetap
                'bayes_probability' => 0.9
            ],
            [
                'name' => 'Keterlibatan Masyarakat',
                'type' => 'benefit',
                'weight' => 0.10, // Tetap
                'bayes_probability' => 0.8
            ],
            [
                'name' => 'Kondisi Ekonomi',
                'type' => 'cost',
                'weight' => 0.10, // Tetap
                'bayes_probability' => 0.95
            ],
            [
                'name' => 'Penghasilan Orang Tua',
                'type' => 'cost',
                'weight' => 0.16, // Disesuaikan dari 0.15
                'bayes_probability' => 0.98
            ],
            [
                'name' => 'Jumlah Tanggungan Orang Tua',
                'type' => 'benefit',
                'weight' => 0.16, // Disesuaikan dari 0.15
                'bayes_probability' => 0.85
            ],
        ];

        // Verifikasi total bobot (untuk debugging, bisa dihapus di produksi)
        $totalWeight = array_sum(array_column($criterias, 'weight'));
        // echo "Total bobot kriteria: " . $totalWeight . "\n"; // Anda bisa uncomment ini untuk cek di CLI

        foreach ($criterias as $c) {
            Criteria::create($c);
        }
    }
}
