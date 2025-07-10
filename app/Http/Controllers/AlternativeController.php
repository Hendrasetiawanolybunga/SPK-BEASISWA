<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        return view('alternatives.index', compact('alternatives'));
    }

    public function create()
    {
        $criterias = Criteria::all();
        return view('alternatives.create', compact('criterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'scores.*' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            $alt = Alternative::create(['name' => $request->name]);

            foreach ($request->scores as $criteria_id => $value) {
                Score::create([
                    'alternative_id' => $alt->id,
                    'criteria_id' => $criteria_id,
                    'value' => $value
                ]);
            }

            DB::commit();
            return redirect()->route('alternatives.index')->with('success', 'Data berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function result()
    {
        $alternatives = Alternative::with('scores.criteria')->get();
        $criterias = Criteria::all();

        // Buat matriks keputusan
        $matrix = [];
        foreach ($alternatives as $alt) {
            $row = [];
            foreach ($criterias as $c) {
                $score = $alt->scores->where('criteria_id', $c->id)->first();
                $row[] = $score ? $score->value : 0;
            }
            $matrix[] = $row;
        }

        // Normalisasi
        $norm = [];
        $denominators = [];
        foreach ($criterias as $j => $c) {
            $sumSquares = 0;
            foreach ($matrix as $i => $row) {
                $sumSquares += pow($row[$j], 2);
            }
            $denominators[$j] = sqrt($sumSquares);
        }

        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                $norm[$i][$j] = $denominators[$j] != 0 ? $val / $denominators[$j] : 0;
            }
        }

        // Hitung skor MOORA
        $scores = [];
        foreach ($norm as $i => $row) {
            $score = 0;
            foreach ($row as $j => $val) {
                $weight = $criterias[$j]->weight;
                if ($criterias[$j]->type === 'benefit') {
                    $score += $val * $weight;
                } else {
                    $score -= $val * $weight;
                }
            }
            $scores[] = ['alt' => $alternatives[$i], 'score' => $score];
        }

        // Urutkan skor
        usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);

        return view('alternatives.result', compact('scores'));
    }
}

