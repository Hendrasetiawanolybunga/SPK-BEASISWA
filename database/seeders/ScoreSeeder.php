<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;

class ScoreSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel sebelum insert baru
        Score::truncate();

        $alternatives = Alternative::all();
        $criterias    = Criteria::orderBy('id')->get();

        foreach ($alternatives as $alt) {
            // Siapkan nilai untuk criteria id = 4 (jika ada)
            $hasC4  = $criterias->firstWhere('id', 4) !== null;
            $valC4  = $hasC4 ? rand(1, 5) : null;

            foreach ($criterias as $criteria) {
                $value = null;

                switch ($criteria->id) {
                    case 1:
                        $value = rand(1, 4);
                        break;

                    case 2:
                        $value = rand(0, 1);
                        break;

                    case 3:
                        $value = rand(1, 4);
                        break;

                    case 4:
                        // Gunakan nilai yang sudah dipilih di atas supaya konsisten
                        $value = $valC4 ?? rand(1, 5);
                        break;

                    case 5:
                        // Nilai id=5 bergantung pada nilai id=4 untuk alternatif ini
                        if ($valC4 === null) {
                            // Fallback kalau criteria id=4 tidak ada
                            $value = rand(0, 1);
                        } else {
                            if ($valC4 === 1) {
                                $value = rand(9, 11);
                            } elseif ($valC4 === 2) {
                                $value = rand(7, 8);
                            } elseif ($valC4 === 3) {
                                $value = rand(5, 6);
                            } elseif ($valC4 === 4) {
                                $value = rand(3, 4);
                            } else { // $valC4 === 5
                                $value = rand(1, 2);
                            }
                        }
                        break;

                    case 6:
                    case 7:
                        $value = rand(0, 1);
                        break;

                    default:
                        $value = rand(0, 10);
                        break;
                }

                Score::create([
                    'alternative_id' => $alt->id,
                    'criteria_id'    => $criteria->id,
                    'value'          => $value,
                ]);
            }
        }
    }
}
