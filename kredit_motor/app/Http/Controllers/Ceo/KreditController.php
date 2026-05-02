<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\PengajuanKredit;
use Illuminate\Http\Request;

class KreditController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));

        $kredit = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor'])
            ->when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $ringkasan = [
            'total_kredit' => Kredit::when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->count(),
            'aktif' => Kredit::where('status_kredit', 'Dicicil')->when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->count(),
            'lunas' => Kredit::where('status_kredit', 'Lunas')->when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->count(),
            'macet' => Kredit::where('status_kredit', 'Macet')->when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })->count(),
        ];

        return view('ceo.kredit.index', compact('kredit', 'ringkasan', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));

        $data = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor'])
            ->when($startDate, function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            })
            ->get()
            ->map(function($item) {
                return [
                    'ID' => $item->id,
                    'Pelanggan' => $item->pengajuanKredit->pelanggan->nama_pelanggan ?? '-',
                    'Motor' => $item->pengajuanKredit->motor->nama_motor ?? '-',
                    'Tanggal Mulai' => $item->tgl_mulai_kredit,
                    'Tanggal Selesai' => $item->tgl_selesai_kredit,
                    'Sisa Kredit' => number_format($item->sisa_kredit, 0, ',', '.'),
                    'Status' => $item->status_kredit == 'Dicicil' ? 'Aktif' : ($item->status_kredit == 'Lunas' ? 'Lunas' : 'Macet'),
                ];
            });

        return $this->downloadCsv($data, 'laporan_kredit_' . date('Ymd'));
    }

    private function downloadCsv($data, $filename)
    {
        $handle = fopen('php://temp', 'w+');
        
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
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            ]);
    }
}