<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\JenisMotor;
use App\Models\JenisCicilan;
use App\Models\Asuransi;
use App\Models\MetodeBayar;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Master Data
        $totalMotor = Motor::count();
        $totalJenisMotor = JenisMotor::count();
        $totalJenisCicilan = JenisCicilan::count();
        $totalAsuransi = Asuransi::count();
        $totalMetodeBayar = MetodeBayar::count();
        $totalUsers = User::count();
        
        // Motor terbaru (5 data)
        $motorTerbaru = Motor::with('jenisMotor')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard.index', compact(
            'totalMotor',
            'totalJenisMotor',
            'totalJenisCicilan',
            'totalAsuransi',
            'totalMetodeBayar',
            'totalUsers',
            'motorTerbaru'
        ));
    }
}