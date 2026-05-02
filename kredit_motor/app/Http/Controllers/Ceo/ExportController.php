<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\Motor;
use App\Models\Angsuran;
use App\Models\Pelanggan;
use App\Models\PengajuanKredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function index()
    {
        return view('ceo.export.index');
    }

    public function exportData(Request $request)
    {
        $request->validate([
            'type' => 'required|in:kredit,motor,angsuran,pelanggan,pengajuan',
            'format' => 'required|in:csv,excel',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $type = $request->type;
        $format = $request->format;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        switch ($type) {
            case 'kredit':
                return $this->exportKredit($format, $startDate, $endDate);
            case 'motor':
                return $this->exportMotor($format);
            case 'angsuran':
                return $this->exportAngsuran($format, $startDate, $endDate);
            case 'pelanggan':
                return $this->exportPelanggan($format);
            case 'pengajuan':
                return $this->exportPengajuan($format, $startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'Tipe export tidak valid');
        }
    }

    private function exportKredit($format, $startDate, $endDate)
    {
        $query = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        $data = $query->get()->map(function($item) {
            return [
                'ID Kredit' => $item->id,
                'ID Pengajuan' => $item->id_pengajuan_kredit,
                'Pelanggan' => $item->pengajuanKredit->pelanggan->nama_pelanggan ?? '-',
                'Motor' => $item->pengajuanKredit->motor->nama_motor ?? '-',
                'Tanggal Mulai' => $item->tgl_mulai_kredit,
                'Tanggal Selesai' => $item->tgl_selesai_kredit,
                'Total Kredit' => number_format($item->pengajuanKredit->harga_kredit ?? 0, 0, ',', '.'),
                'Sisa Kredit' => number_format($item->sisa_kredit, 0, ',', '.'),
                'Status' => $item->status_kredit == 'Dicicil' ? 'Aktif' : ($item->status_kredit == 'Lunas' ? 'Lunas' : 'Macet'),
                'Dibuat Tanggal' => $item->created_at,
            ];
        });

        $filename = 'laporan_kredit_' . date('Ymd_His');
        return $this->download($data, $filename, $format);
    }

    private function exportMotor($format)
    {
        $data = Motor::with('jenisMotor')->get()->map(function($item) {
            return [
                'ID Motor' => $item->id,
                'Nama Motor' => $item->nama_motor,
                'Merk' => $item->merk,
                'Jenis' => $item->jenisMotor->nama_jenis ?? '-',
                'Harga Cash' => number_format($item->harga_cash, 0, ',', '.'),
                'Harga Jual' => number_format($item->harga_jual, 0, ',', '.'),
                'Warna' => $item->warna ?? '-',
                'Stok' => $item->stok,
                'Status' => $item->stok > 0 ? 'Tersedia' : 'Habis',
                'Tahun' => $item->tahun ?? '-',
            ];
        });

        $filename = 'laporan_motor_' . date('Ymd_His');
        return $this->download($data, $filename, $format);
    }

    private function exportAngsuran($format, $startDate, $endDate)
    {
        $query = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        $data = $query->get()->map(function($item) {
            $status = $item->tgl_bayar ? 'Lunas' : 
                     ($item->tgl_jatuh_tempo < now() ? 'Terlambat' : 'Belum Bayar');
            
            return [
                'ID Angsuran' => $item->id,
                'ID Kredit' => $item->id_kredit,
                'Pelanggan' => $item->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-',
                'Motor' => $item->kredit->pengajuanKredit->motor->nama_motor ?? '-',
                'Angsuran Ke' => $item->angsuran_ke,
                'Jatuh Tempo' => $item->tgl_jatuh_tempo,
                'Total Bayar' => number_format($item->total_bayar, 0, ',', '.'),
                'Tanggal Bayar' => $item->tgl_bayar ?? '-',
                'Status' => $status,
                'Keterangan' => $item->keterangan ?? '-',
            ];
        });

        $filename = 'laporan_angsuran_' . date('Ymd_His');
        return $this->download($data, $filename, $format);
    }

    private function exportPelanggan($format)
    {
        $data = Pelanggan::get()->map(function($item) {
            return [
                'ID Pelanggan' => $item->id,
                'Nama' => $item->nama_pelanggan,
                'Email' => $item->email ?? '-',
                'No Telepon' => $item->no_telp ?? '-',
                'Alamat' => $item->alamat1 ?? '-',
                'Kota' => $item->kota1 ?? '-',
                'Provinsi' => $item->provinsi1 ?? '-',
                'Kode Pos' => $item->kodepos1 ?? '-',
                'Bergabung' => $item->created_at,
            ];
        });

        $filename = 'laporan_pelanggan_' . date('Ymd_His');
        return $this->download($data, $filename, $format);
    }

    private function exportPengajuan($format, $startDate, $endDate)
    {
        $query = PengajuanKredit::with(['pelanggan', 'motor', 'jenisCicilan']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        $data = $query->get()->map(function($item) {
            $statusMap = [
                'Menunggu' => 'Menunggu',
                'Disetujui' => 'Disetujui',
                'Ditolak' => 'Ditolak'
            ];
            
            return [
                'ID Pengajuan' => $item->id,
                'Tanggal Pengajuan' => $item->tgl_pengajuan_kredit,
                'Pelanggan' => $item->pelanggan->nama_pelanggan ?? '-',
                'Motor' => $item->motor->nama_motor ?? '-',
                'Harga Cash' => number_format($item->harga_cash, 0, ',', '.'),
                'DP' => number_format($item->dp, 2) . '%',
                'Uang Muka' => number_format($item->uang_muka, 0, ',', '.'),
                'Tenor' => $item->tenor . ' bulan',
                'Cicilan/Bulan' => number_format($item->cicilan_perbulan, 0, ',', '.'),
                'Status' => $statusMap[$item->status_pengajuan] ?? $item->status_pengajuan,
                'Status DP' => $item->status_dp ?? 'Belum Bayar',
            ];
        });

        $filename = 'laporan_pengajuan_' . date('Ymd_His');
        return $this->download($data, $filename, $format);
    }

    private function download($data, $filename, $format)
    {
        if ($format == 'csv') {
            $handle = fopen('php://temp', 'w+');
            
            // Add BOM for UTF-8 Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            if ($data->isNotEmpty()) {
                fputcsv($handle, array_keys($data->first()->toArray()));
            }
            
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
            
            rewind($handle);
            $content = stream_get_contents($handle);
            fclose($handle);
            
            return response($content)
                ->withHeaders([
                    'Content-Type' => 'text/csv; charset=UTF-8',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
                ]);
        }
        
        // Untuk format excel, kita redirect ke CSV (karena CSV juga bisa dibuka Excel)
        return redirect()->back()->with('info', 'Gunakan format CSV untuk export data');
    }
}