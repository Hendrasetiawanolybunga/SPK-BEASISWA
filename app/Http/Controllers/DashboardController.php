<?php

    namespace App\Http\Controllers;

    use App\Models\Alternative; // Pastikan model Alternative ada
    use App\Models\Criteria;    // Pastikan model Criteria ada
    use Illuminate\Http\Request;

    class DashboardController extends Controller
    {
        /**
         * Tampilkan halaman dashboard admin.
         *
         * @return \Illuminate\View\View
         */
        public function index()
        {
            $totalAlternatives = Alternative::count();
            $totalCriterias = Criteria::count();

            return view('dashboard', compact('totalAlternatives', 'totalCriterias'));
        }
    }
    