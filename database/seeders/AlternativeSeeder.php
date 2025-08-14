<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;

class AlternativeSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel sebelum menambahkan data baru
        Alternative::truncate();

        $alternatives = [
            ['name' => 'Ahmad Fauzi'],
            ['name' => 'Budi Santoso'],
            ['name' => 'Citra Dewi'],
            ['name' => 'Dian Pratama'],
            ['name' => 'Eka Saputra'],
            ['name' => 'Fajar Hidayat'],
            ['name' => 'Gita Lestari'],
            ['name' => 'Hendra Wijaya'],
            ['name' => 'Indra Setiawan'],
            ['name' => 'Joko Susanto'],
            ['name' => 'Kirana Sari'],
            ['name' => 'Lina Marlina'],
            ['name' => 'Maya Pratiwi'],
            ['name' => 'Nanda Prabowo'],
            ['name' => 'Oka Wijaya'],
            ['name' => 'Putri Ayu'],
            ['name' => 'Rudi Hartono'],
            ['name' => 'Siti Aminah'],
            ['name' => 'Tono Kurniawan'],
            ['name' => 'Umi Lestari'],
        ];

        foreach ($alternatives as $alt) {
            Alternative::create($alt);
        }
    }
}
