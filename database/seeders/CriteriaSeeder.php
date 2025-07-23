<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // $criterias = [
        //     ['name' => 'Prestasi Akademik', 'type' => 'benefit', 'weight' => 0.15],
        //     ['name' => 'Prestasi Non-Akademik', 'type' => 'benefit', 'weight' => 0.10],
        //     // ['name' => 'Kondisi Ekonomi', 'type' => 'cost', 'weight' => 0.15],
        //     ['name' => 'Domisili 3T', 'type' => 'benefit', 'weight' => 0.10],
        //     ['name' => 'Difabel', 'type' => 'benefit', 'weight' => 0.10],
        //     ['name' => 'Keterlibatan Masyarakat', 'type' => 'benefit', 'weight' => 0.10],
        //     ['name' => 'Penghasilan Orang Tua', 'type' => 'cost', 'weight' => 0.15],
        //     ['name' => 'Jumlah Tanggungan Orang Tua', 'type' => 'benefit', 'weight' => 0.15],
        // ];

        $criterias = [
            ['name' => 'Prestasi Akademik', 'type' => 'benefit', 'weight' => 0.15, 'bayes_probability' => 0.9],
            ['name' => 'Prestasi Non-Akademik', 'type' => 'benefit', 'weight' => 0.10, 'bayes_probability' => 0.7],
            ['name' => 'Domisili 3T', 'type' => 'benefit', 'weight' => 0.10, 'bayes_probability' => 0.85],
            ['name' => 'Difabel', 'type' => 'benefit', 'weight' => 0.10, 'bayes_probability' => 0.8],
            ['name' => 'Keterlibatan Masyarakat', 'type' => 'benefit', 'weight' => 0.10, 'bayes_probability' => 0.75],
            ['name' => 'Penghasilan Orang Tua', 'type' => 'cost', 'weight' => 0.15, 'bayes_probability' => 0.2],
            ['name' => 'Jumlah Tanggungan Orang Tua', 'type' => 'benefit', 'weight' => 0.15, 'bayes_probability' => 0.8],
        ];

        foreach ($criterias as $c) {
            Criteria::create($c);
        }
    }
}
