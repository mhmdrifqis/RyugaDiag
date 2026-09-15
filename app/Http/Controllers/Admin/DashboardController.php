<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGejala = Gejala::count();
        $totalKerusakan = Kerusakan::count();
        $totalRule = Rule::count();
        $totalTeknisi = User::where('role', 'teknisi')->count();

        return view('admin.dashboard', compact(
            'totalGejala',
            'totalKerusakan',
            'totalRule',
            'totalTeknisi'
        ));
    }
}
