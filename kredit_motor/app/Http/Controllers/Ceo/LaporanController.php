<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\Motor;
use App\Models\PengajuanKredit;
use App\Models\Angsuran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // Dashboard Laporan
    public function index()
    {
        return view('ceo.laporan.index');
    }

    // Laporan Kredit
    public function kredit(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));

        $kredit = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor'])
            ->when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Ringkasan
        $ringkasan = [
            'total_kredit' => Kredit::when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->count(),
            'total_nilai' => Kredit::when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->sum('sisa_kredit'),
            'aktif' => Kredit::when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->where('status_kredit', 'Dicicil')->count(),
            'lunas' => Kredit::when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->where('status_kredit', 'Lunas')->count(),
            'macet' => Kredit::when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->where('status_kredit', 'Macet')->count(),
        ];

        return view('ceo.laporan.kredit', compact('kredit', 'ringkasan', 'startDate', 'endDate'));
    }

    // Laporan Data Motor
    public function motor(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_motor');
        $sortOrder = $request->get('sort_order', 'asc');

        $motor = Motor::with('jenisMotor')
            ->orderBy($sortBy, $sortOrder)
            ->paginate(15);

        // Statistik motor
        $statistik = [
            'total_motor' => Motor::count(),
            'total_stok' => Motor::sum('stok'),
            'motor_terlaris' => Motor::withCount('pengajuanKredit')
                ->orderBy('pengajuan_kredit_count', 'desc')
                ->first(),
            'motor_kosong' => Motor::where('stok', '<=', 0)->count(),
            'by_jenis' => Motor::select('jenis_motor_id', DB::raw('count(*) as total'))
                ->groupBy('jenis_motor_id')
                ->with('jenisMotor')
                ->get(),
        ];

        return view('ceo.laporan.motor', compact('motor', 'statistik', 'sortBy', 'sortOrder'));
    }

    // Laporan Analitik
    public function analitik(Request $request)
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

        return view('ceo.laporan.analitik', compact(
            'tahun', 'bulanLabels', 'pendapatanData', 'statusPengajuan',
            'statusKredit', 'motorTerlaris', 'pelangganData'
        ));
    }

    // Export Data
    public function export(Request $request)
    {
        $type = $request->get('type');
        $format = $request->get('format', 'excel'); // excel or csv

        if ($type == 'kredit') {
            return $this->exportKredit($format);
        } elseif ($type == 'motor') {
            return $this->exportMotor($format);
        } elseif ($type == 'angsuran') {
            return $this->exportAngsuran($format);
        } elseif ($type == 'pelanggan') {
            return $this->exportPelanggan($format);
        }

        return redirect()->back()->with('error', 'Tipe export tidak valid');
    }

    private function exportKredit($format)
    {
        $data = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor'])
            ->get()
            ->map(function($item) {
                return [
                    'ID' => $item->id,
                    'Pelanggan' => $item->pengajuanKredit->pelanggan->nama_pelanggan ?? '-',
                    'Motor' => $item->pengajuanKredit->motor->nama_motor ?? '-',
                    'Tanggal Mulai' => $item->tgl_mulai_kredit,
                    'Tanggal Selesai' => $item->tgl_selesai_kredit,
                    'Sisa Kredit' => $item->sisa_kredit,
                    'Status' => $item->status_kredit,
                ];
            });

        return $this->downloadExcel($data, 'laporan_kredit_' . date('Ymd'), $format);
    }

    private function exportMotor($format)
    {
        $data = Motor::with('jenisMotor')
            ->get()
            ->map(function($item) {
                return [
                    'ID' => $item->id,
                    'Nama Motor' => $item->nama_motor,
                    'Merk' => $item->merk,
                    'Jenis' => $item->jenisMotor->nama_jenis ?? '-',
                    'Harga Jual' => $item->harga_jual,
                    'Stok' => $item->stok,
                ];
            });

        return $this->downloadExcel($data, 'laporan_motor_' . date('Ymd'), $format);
    }

    private function exportAngsuran($format)
    {
        $data = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])
            ->whereNotNull('tgl_bayar')
            ->get()
            ->map(function($item) {
                return [
                    'ID' => $item->id,
                    'Pelanggan' => $item->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-',
                    'Motor' => $item->kredit->pengajuanKredit->motor->nama_motor ?? '-',
                    'Angsuran Ke' => $item->angsuran_ke,
                    'Tanggal Bayar' => $item->tgl_bayar,
                    'Total Bayar' => $item->total_bayar,
                ];
            });

        return $this->downloadExcel($data, 'laporan_angsuran_' . date('Ymd'), $format);
    }

    private function exportPelanggan($format)
    {
        $data = Pelanggan::get()
            ->map(function($item) {
                return [
                    'ID' => $item->id,
                    'Nama' => $item->nama_pelanggan,
                    'Email' => $item->email,
                    'No Telepon' => $item->no_telp,
                    'Alamat' => $item->alamat1,
                    'Tanggal Bergabung' => $item->created_at,
                ];
            });

        return $this->downloadExcel($data, 'laporan_pelanggan_' . date('Ymd'), $format);
    }

    private function downloadExcel($data, $filename, $format)
    {
        // Buat CSV sederhana (karena tidak ada library excel)
        $handle = fopen('php://temp', 'w+');
        
        // Header
        if ($data->isNotEmpty()) {
            fputcsv($handle, array_keys($data->first()->toArray()));
        }
        
        // Data
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return response($content)
            ->withHeaders([
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            ]);
    }
}