<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'nama_motor');
        $sortOrder = $request->get('sort_order', 'asc');

        $motor = Motor::with('jenisMotor')
            ->orderBy($sortBy, $sortOrder)
            ->paginate(15);

        $statistik = [
            'total_motor' => Motor::count(),
            'total_stok' => Motor::sum('stok'),
            'motor_terlaris' => Motor::withCount('pengajuanKredit')
                ->orderBy('pengajuan_kredit_count', 'desc')
                ->first(),
            'motor_kosong' => Motor::where('stok', '<=', 0)->count(),
        ];

        return view('ceo.motor.index', compact('motor', 'statistik', 'sortBy', 'sortOrder'));
    }

    public function export()
    {
        $data = Motor::with('jenisMotor')->get()->map(function($item) {
            return [
                'ID' => $item->id,
                'Nama Motor' => $item->nama_motor,
                'Merk' => $item->merk,
                'Jenis' => $item->jenisMotor->nama_jenis ?? '-',
                'Harga Jual' => number_format($item->harga_jual, 0, ',', '.'),
                'Stok' => $item->stok,
                'Status' => $item->stok > 0 ? 'Tersedia' : 'Habis',
            ];
        });

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

        return response($content)->withHeaders([
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_motor_' . date('Ymd') . '.csv"',
        ]);
    }
}