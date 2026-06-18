<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\PengajuanKredit;
use App\Models\Angsuran;
use App\Models\Motor;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalitikController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $filter = $request->get('filter');

        $tanggalMulai = null;
        $tanggalSelesai = null;

        switch ($filter) {
            case 'bulan_ini':
                $tanggalMulai = now()->startOfMonth();
                $tanggalSelesai = now()->endOfMonth();
                break;

            case 'tahun_ini':
                $tanggalMulai = now()->startOfYear();
                $tanggalSelesai = now()->endOfYear();
                break;

            case 'custom':
                if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
                    $tanggalMulai = $request->tanggal_mulai;
                    $tanggalSelesai = $request->tanggal_selesai;
                }
                break;
        }
// =========================
// Tren Pengajuan & Persetujuan Kredit
// =========================

$bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

$pengajuanPerBulan = PengajuanKredit::select(
        DB::raw('MONTH(created_at) as bulan'),
        DB::raw('COUNT(*) as total')
    )
    ->when(
        $tanggalMulai && $tanggalSelesai,
        function ($query) use ($tanggalMulai, $tanggalSelesai) {
            $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        },
        function ($query) use ($tahun) {
            $query->whereYear('created_at', $tahun);
        }
    )
    ->groupBy('bulan')
    ->get();

$disetujuiPerBulan = PengajuanKredit::select(
        DB::raw('MONTH(created_at) as bulan'),
        DB::raw('COUNT(*) as total')
    )
    ->where('status_pengajuan', 'Disetujui')
    ->when(
        $tanggalMulai && $tanggalSelesai,
        function ($query) use ($tanggalMulai, $tanggalSelesai) {
            $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        },
        function ($query) use ($tahun) {
            $query->whereYear('created_at', $tahun);
        }
    )
    ->groupBy('bulan')
    ->get();

$pengajuanData = array_fill(0, 12, 0);
$disetujuiData = array_fill(0, 12, 0);

foreach ($pengajuanPerBulan as $item) {
    $pengajuanData[$item->bulan - 1] = $item->total;
}

foreach ($disetujuiPerBulan as $item) {
    $disetujuiData[$item->bulan - 1] = $item->total;
}

        // =========================
        // Status Pengajuan
        // =========================
        $pengajuanQuery = PengajuanKredit::query();

        if ($tanggalMulai && $tanggalSelesai) {
            $pengajuanQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        } else {
            $pengajuanQuery->whereYear('created_at', $tahun);
        }

        $statusPengajuan = [
            'Menunggu' => (clone $pengajuanQuery)->where('status_pengajuan', 'Menunggu')->count(),
            'Disetujui' => (clone $pengajuanQuery)->where('status_pengajuan', 'Disetujui')->count(),
            'Ditolak' => (clone $pengajuanQuery)->where('status_pengajuan', 'Ditolak')->count(),
        ];

        // =========================
        // Status Kredit
        // =========================
        $kreditQuery = Kredit::query();

        if ($tanggalMulai && $tanggalSelesai) {
            $kreditQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
        } else {
            $kreditQuery->whereYear('created_at', $tahun);
        }

        $statusKredit = [
            'Aktif' => (clone $kreditQuery)->where('status_kredit', 'Dicicil')->count(),
            'Lunas' => (clone $kreditQuery)->where('status_kredit', 'Lunas')->count(),
            'Macet' => (clone $kreditQuery)->where('status_kredit', 'Macet')->count(),
        ];

        // =========================
        // Motor Terlaris
        // =========================
        $motorTerlaris = Motor::withCount('pengajuanKredit')
            ->orderBy('pengajuan_kredit_count', 'desc')
            ->limit(10)
            ->get();

        // =========================
        // Pertumbuhan Pelanggan
        // =========================
        $pelangganPerBulan = Pelanggan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->when(
                $tanggalMulai && $tanggalSelesai,
                function ($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
                },
                function ($query) use ($tahun) {
                    $query->whereYear('created_at', $tahun);
                }
            )
            ->groupBy('bulan')
            ->get();

        $pelangganData = array_fill(0, 12, 0);

        foreach ($pelangganPerBulan as $item) {
            $pelangganData[$item->bulan - 1] = $item->total;
        }
        
return view('ceo.analitik.index', compact(
    'tahun',
    'filter',
    'tanggalMulai',
    'tanggalSelesai',
    'bulanLabels',
    'pengajuanData',
    'disetujuiData',
    'statusPengajuan',
    'statusKredit',
    'motorTerlaris',
    'pelangganData'
));
    }
}