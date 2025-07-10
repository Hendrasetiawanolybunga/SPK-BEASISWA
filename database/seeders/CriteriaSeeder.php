<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = [
            ['name' => 'Prestasi Akademik', 'type' => 'benefit', 'weight' => 0.15],
            ['name' => 'Prestasi Non-Akademik', 'type' => 'benefit', 'weight' => 0.10],
            ['name' => 'Kondisi Ekonomi', 'type' => 'cost', 'weight' => 0.15],
            ['name' => 'Domisili 3T', 'type' => 'benefit', 'weight' => 0.10],
            ['name' => 'Difabel', 'type' => 'benefit', 'weight' => 0.10],
            ['name' => 'Keterlibatan Masyarakat', 'type' => 'benefit', 'weight' => 0.10],
            ['name' => 'Penghasilan Orang Tua', 'type' => 'cost', 'weight' => 0.15],
            ['name' => 'Jumlah Tanggungan Orang Tua', 'type' => 'benefit', 'weight' => 0.15],
        ];

        foreach ($criterias as $c) {
            Criteria::create($c);
        }
    }
}
