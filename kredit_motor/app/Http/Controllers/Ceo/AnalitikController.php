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

        // Pendapatan per bulan
        $pendapatanBulanan = Angsuran::select(
                DB::raw('MONTH(tgl_bayar) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereNotNull('tgl_bayar')
            ->whereYear('tgl_bayar', $tahun)
            ->groupBy('bulan')
            ->get();

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $pendapatanData = array_fill(0, 12, 0);
        foreach ($pendapatanBulanan as $item) {
            $pendapatanData[$item->bulan - 1] = (int) $item->total;
        }

        // Status pengajuan
        $statusPengajuan = [
            'Menunggu' => PengajuanKredit::where('status_pengajuan', 'Menunggu')->whereYear('created_at', $tahun)->count(),
            'Disetujui' => PengajuanKredit::where('status_pengajuan', 'Disetujui')->whereYear('created_at', $tahun)->count(),
            'Ditolak' => PengajuanKredit::where('status_pengajuan', 'Ditolak')->whereYear('created_at', $tahun)->count(),
        ];

        // Status kredit
        $statusKredit = [
            'Aktif' => Kredit::where('status_kredit', 'Dicicil')->whereYear('created_at', $tahun)->count(),
            'Lunas' => Kredit::where('status_kredit', 'Lunas')->whereYear('created_at', $tahun)->count(),
            'Macet' => Kredit::where('status_kredit', 'Macet')->whereYear('created_at', $tahun)->count(),
        ];

        // Motor terlaris
        $motorTerlaris = Motor::withCount('pengajuanKredit')
            ->orderBy('pengajuan_kredit_count', 'desc')
            ->limit(10)
            ->get();

        // Pertumbuhan pelanggan
        $pelangganPerBulan = Pelanggan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->get();

        $pelangganData = array_fill(0, 12, 0);
        foreach ($pelangganPerBulan as $item) {
            $pelangganData[$item->bulan - 1] = $item->total;
        }

        return view('ceo.analitik.index', compact(
            'tahun', 'bulanLabels', 'pendapatanData', 'statusPengajuan',
            'statusKredit', 'motorTerlaris', 'pelangganData'
        ));
    }
}