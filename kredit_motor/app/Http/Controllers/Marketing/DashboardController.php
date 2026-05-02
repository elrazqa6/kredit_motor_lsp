<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKredit;
use App\Models\Kredit;
use App\Models\Angsuran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalPengajuan = PengajuanKredit::count();
        $pengajuanMenunggu = PengajuanKredit::where('status_pengajuan', 'Menunggu')->count();
        $pengajuanDisetujui = PengajuanKredit::where('status_pengajuan', 'Disetujui')->count();
        $pengajuanDitolak = PengajuanKredit::where('status_pengajuan', 'Ditolak')->count();
        
        // Statistik Kredit
        $kreditAktif = Kredit::where('status_kredit', 'Dicicil')->count();
        $kreditLunas = Kredit::where('status_kredit', 'Lunas')->count();
        $totalAngsuranMasuk = Angsuran::whereNotNull('tgl_bayar')->sum('total_bayar');
        
        // Total Pelanggan
        $totalPelanggan = Pelanggan::count();
        
        // Data untuk Chart (Angsuran per Bulan)
        $angsuranPerBulan = Angsuran::select(
                DB::raw('MONTH(tgl_bayar) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereNotNull('tgl_bayar')
            ->whereYear('tgl_bayar', date('Y'))
            ->groupBy('bulan')
            ->get();
        
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $angsuranData = array_fill(0, 12, 0);
        foreach ($angsuranPerBulan as $item) {
            $angsuranData[$item->bulan - 1] = (int) $item->total;
        }
        
        // Pengajuan Terbaru (5 data)
        $pengajuanTerbaru = PengajuanKredit::with(['pelanggan', 'motor'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Angsuran Terlambat (5 data)
        $angsuranTerlambat = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])
            ->whereNull('tgl_bayar')
            ->where('tgl_jatuh_tempo', '<', now())
            ->limit(5)
            ->get();
        
        return view('marketing.dashboard.index', compact(
            'totalPengajuan', 'pengajuanMenunggu', 'pengajuanDisetujui', 'pengajuanDitolak',
            'kreditAktif', 'kreditLunas', 'totalAngsuranMasuk', 'totalPelanggan',
            'bulanLabels', 'angsuranData', 'pengajuanTerbaru', 'angsuranTerlambat'
        ));
    }
}