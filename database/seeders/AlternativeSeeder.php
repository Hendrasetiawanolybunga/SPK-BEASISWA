<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;

class AlternativeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Andi Saputra', 'juara_olimpiade', 'ada', 'ketua', 'sangat_buruk', '<_1jt', 1, 0, 4],
            ['Budi Santoso', 'juara_kelas', 'tidak_ada', 'pengurus', 'buruk', '1jt_1.5jt', 0, 0, 3],
            ['Citra Dewi', 'juara_lainnya', 'ada', 'anggota', 'cukup', '1.5jt_2jt', 0, 1, 5],
            ['Dedi Pratama', 'tidak_ada_akademik', 'ada', 'tidak_ada_keterlibatan', 'baik', '2jt_2.5jt', 1, 0, 2],
            ['Eka Rahmawati', 'juara_kelas', 'ada', 'ketua', 'sangat_buruk', '<_1jt', 0, 0, 6],
            ['Fajar Nugroho', 'juara_olimpiade', 'tidak_ada', 'anggota', 'buruk', '3jt_4jt', 0, 0, 1],
            ['Gita Sari', 'juara_lainnya', 'ada', 'pengurus', 'cukup', '4jt_5jt', 1, 0, 4],
            ['Hendra Kurniawan', 'tidak_ada_akademik', 'ada', 'ketua', 'sangat_baik', '>_10jt', 0, 0, 2],
            ['Indah Permata', 'juara_olimpiade', 'ada', 'anggota', 'buruk', '5jt_6jt', 1, 0, 5],
            ['Joko Wibisono', 'juara_kelas', 'tidak_ada', 'pengurus', 'sangat_buruk', '<_1jt', 0, 0, 6],
            ['Kartika Ayu', 'juara_olimpiade', 'ada', 'ketua', 'cukup', '1.5jt_2jt', 0, 1, 3],
            ['Lukman Hakim', 'juara_lainnya', 'tidak_ada', 'anggota', 'buruk', '2.5jt_3jt', 0, 0, 4],
            ['Maya Safitri', 'juara_kelas', 'ada', 'pengurus', 'sangat_buruk', '1jt_1.5jt', 1, 0, 5],
            ['Nanda Prasetyo', 'tidak_ada_akademik', 'ada', 'ketua', 'baik', '6jt_8jt', 0, 0, 2],
            ['Oki Firmansyah', 'juara_olimpiade', 'tidak_ada', 'pengurus', 'cukup', '4jt_5jt', 0, 1, 3],
            ['Putri Melati', 'juara_lainnya', 'ada', 'anggota', 'buruk', '3jt_4jt', 1, 0, 4],
            ['Qori Ramadhani', 'juara_kelas', 'ada', 'ketua', 'sangat_baik', '5jt_6jt', 0, 0, 1],
            ['Raka Aditya', 'juara_olimpiade', 'ada', 'pengurus', 'sangat_buruk', '<_1jt', 1, 0, 6],
            ['Sinta Lestari', 'juara_kelas', 'tidak_ada', 'anggota', 'cukup', '1.5jt_2jt', 0, 0, 3],
            ['Tono Setiawan', 'juara_lainnya', 'ada', 'tidak_ada_keterlibatan', 'baik', '8jt_10jt', 0, 1, 2],
        ];

        // Ambil semua kriteria
        $criterias = Criteria::all()->keyBy('name');

        foreach ($data as $row) {
            $alt = Alternative::create(['name' => $row[0]]);

            foreach ($criterias as $criteria) {
                $value = null;
                $nameLower = strtolower($criteria->name);

                if (str_contains($nameLower, 'prestasi akademik')) {
                    $map = [
                        'juara_olimpiade' => 4,
                        'juara_kelas' => 3,
                        'juara_lainnya' => 2,
                        'tidak_ada_akademik' => 1
                    ];
                    $value = $map[$row[1]];
                } elseif (str_contains($nameLower, 'prestasi non-akademik')) {
                    $value = $row[2] == 'ada' ? 1 : 0;
                } elseif (str_contains($nameLower, 'keterlibatan masyarakat')) {
                    $map = [
                        'ketua' => 4,
                        'pengurus' => 3,
                        'anggota' => 2,
                        'tidak_ada_keterlibatan' => 1
                    ];
                    $value = $map[$row[3]];
                } elseif (str_contains($nameLower, 'kondisi ekonomi')) {
                    $map = [
                        'sangat_buruk' => 5,
                        'buruk' => 4,
                        'cukup' => 3,
                        'baik' => 2,
                        'sangat_baik' => 1
                    ];
                    $value = $map[$row[4]];
                } elseif (str_contains($nameLower, 'penghasilan orang tua')) {
                    $map = [
                        '<_1jt' => 1,
                        '1jt_1.5jt' => 2,
                        '1.5jt_2jt' => 3,
                        '2jt_2.5jt' => 4,
                        '2.5jt_3jt' => 5,
                        '3jt_4jt' => 6,
                        '4jt_5jt' => 7,
                        '5jt_6jt' => 8,
                        '6jt_8jt' => 9,
                        '8jt_10jt' => 10,
                        '>_10jt' => 11
                    ];
                    $value = $map[$row[5]];
                } elseif (str_contains($nameLower, 'domisili 3t')) {
                    $value = (int) $row[6];
                } elseif (str_contains($nameLower, 'difabel')) {
                    $value = (int) $row[7];
                } elseif (str_contains($nameLower, 'jumlah tanggungan orang tua')) {
                    $value = (int) $row[8];
                }

                if ($value !== null) {
                    Score::create([
                        'alternative_id' => $alt->id,
                        'criteria_id' => $criteria->id,
                        'value' => $value
                    ]);
                }
            }
        }
    }
}
