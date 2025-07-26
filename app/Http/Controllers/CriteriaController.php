<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Tampilkan semua kriteria.
     */
    public function index()
    {
        $criterias = Criteria::all();
        return view('criteria.index', compact('criterias'));
    }

    /**
     * Form tambah kriteria.
     */
    // public function create()
    // {
    //     return view('criteria.create');
    // }

    /**
     * Simpan kriteria baru.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|unique:criterias,name',
    //         'type' => 'required|in:benefit,cost',
    //         'weight' => 'required|numeric|min:0|max:1',
    //         'bayes_probability' => 'required|numeric|min:0|max:1',
    //     ]);

    //     Criteria::create($request->only(['name', 'type', 'weight']));

    //     return redirect()->route('criteria.index')
    //         ->with('success', 'Kriteria berhasil ditambahkan.');
    // }

    /**
     * Form edit kriteria.
     */
    public function edit(Criteria $criteria)
    {
        $criteria = Criteria::findorFail($criteria->id);
        return view('criteria.edit', compact('criteria'));
    }

    /**
     * Update kriteria.
     */
    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric|min:0|max:1',
        ]);

        $weight = $request->input('weight');

        // Hitung bayes_probability secara dinamis
        $bayesProbability = $this->calculateBayesProbability($weight);

        $criteria->update([
            'type' => $request->input('type'),
            'weight' => $weight,
            'bayes_probability' => $bayesProbability,
        ]);

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /**
     * Hapus kriteria.
     */
    // public function destroy(Criteria $criteria)
    // {
    //     $criteria->delete();

    //     return redirect()->route('criteria.index')
    //         ->with('success', 'Kriteria berhasil dihapus.');
    // }

    private function calculateBayesProbability($currentWeight)
    {
        // Ambil semua bobot dari database kecuali kriteria yang sedang di-update
        $weights = Criteria::pluck('weight');

        // Tentukan batas weight yang tersedia
        $minWeight = $weights->min();
        $maxWeight = $weights->max();

        // Jika semua bobot sama, hindari pembagian nol
        if ($minWeight == $maxWeight) {
            return 0.90; // default tengah
        }

        // Rentang nilai probabilitas yang bisa disesuaikan (konfigurasi global)
        $minProb = 0.80;
        $maxProb = 0.98;

        // Interpolasi linear otomatis
        $prob = $minProb + ($currentWeight - $minWeight) * ($maxProb - $minProb) / ($maxWeight - $minWeight);

        return round($prob, 2);
    }
}
