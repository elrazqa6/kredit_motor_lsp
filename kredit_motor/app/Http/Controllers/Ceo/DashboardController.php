<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PengajuanKredit;
use App\Models\Kredit;
use App\Models\Angsuran;
use App\Models\Motor;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalUser = User::count();
        $totalPelanggan = Pelanggan::count();
        $totalMotor = Motor::count();
        
        // Statistik Pengajuan
        $totalPengajuan = PengajuanKredit::count();
        $pengajuanDisetujui = PengajuanKredit::where('status_pengajuan', 'Disetujui')->count();
        $pengajuanDitolak = PengajuanKredit::where('status_pengajuan', 'Ditolak')->count();
        $pengajuanMenunggu = PengajuanKredit::where('status_pengajuan', 'Menunggu')->count();
        
        // Statistik Kredit
        $kreditAktif = Kredit::where('status_kredit', 'Dicicil')->count();
        $kreditLunas = Kredit::where('status_kredit', 'Lunas')->count();
        $kreditMacet = Kredit::where('status_kredit', 'Macet')->count();
        
        // Statistik Keuangan
        $totalDpTerbayar = PengajuanKredit::sum('uang_muka');
        $totalAngsuranTerbayar = Angsuran::whereNotNull('tgl_bayar')->sum('total_bayar');
        $totalPendapatan = $totalDpTerbayar + $totalAngsuranTerbayar;
        
        // Data untuk Chart (Pendapatan per Bulan)
        $pendapatanPerBulan = Angsuran::select(
                DB::raw('MONTH(tgl_bayar) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereNotNull('tgl_bayar')
            ->whereYear('tgl_bayar', date('Y'))
            ->groupBy('bulan')
            ->get();
        
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $pendapatanData = array_fill(0, 12, 0);
        foreach ($pendapatanPerBulan as $item) {
            $pendapatanData[$item->bulan - 1] = (int) $item->total;
        }
        
        // Motor Terlaris
        $motorTerlaris = Motor::withCount('pengajuanKredit')
            ->orderBy('pengajuan_kredit_count', 'desc')
            ->limit(5)
            ->get();
        
        // Pengajuan Terbaru
        $pengajuanTerbaru = PengajuanKredit::with(['pelanggan', 'motor'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('ceo.dashboard.index', compact(
            'totalUser', 'totalPelanggan', 'totalMotor',
            'totalPengajuan', 'pengajuanDisetujui', 'pengajuanDitolak', 'pengajuanMenunggu',
            'kreditAktif', 'kreditLunas', 'kreditMacet',
            'totalPendapatan', 'bulanLabels', 'pendapatanData',
            'motorTerlaris', 'pengajuanTerbaru'
        ));
    }
}