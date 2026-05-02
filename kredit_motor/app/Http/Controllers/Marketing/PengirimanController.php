<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::with('kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('marketing.pengiriman.index', compact('pengiriman'));
    }
  public function create($id_kredit)
{
    $kredit = Kredit::with('pengajuanKredit.pelanggan', 'pengajuanKredit.motor')
        ->findOrFail($id_kredit);
    
    // Ambil alamat dari data pelanggan
    $pelanggan = $kredit->pengajuanKredit->pelanggan;
    $alamat = '';
    
    if ($pelanggan) {
        // Gabungkan alamat dari kolom yang ada
        $alamat = trim(implode(', ', array_filter([
            $pelanggan->alamat1,
            $pelanggan->kota1,
            $pelanggan->provinsi1,
            $pelanggan->kodepos1
        ])));
        
        // Jika alamat1 kosong, coba alamat2 atau alamat3
        if (empty($alamat) || $alamat == ', , ,') {
            $alamat = trim(implode(', ', array_filter([
                $pelanggan->alamat2,
                $pelanggan->kota2,
                $pelanggan->provinsi2,
                $pelanggan->kodepos2
            ])));
        }
        
        if (empty($alamat) || $alamat == ', , ,') {
            $alamat = trim(implode(', ', array_filter([
                $pelanggan->alamat3,
                $pelanggan->kota3,
                $pelanggan->provinsi3,
                $pelanggan->kodepos3
            ])));
        }
        
        // Jika masih kosong, pakai pesan default
        if (empty($alamat) || $alamat == ', , ,') {
            $alamat = 'Alamat belum diisi oleh pelanggan';
        }
    }
    
    return view('marketing.pengiriman.create', compact('kredit', 'alamat'));

    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_kredit' => 'required|exists:kredit,id',
            'kurir' => 'nullable|string',
            'alamat_pengiriman' => 'required|string',
            'tgl_estimasi_sampai' => 'nullable|date',
        ]);
        
        // Generate no resi otomatis
        $no_resi = 'KRM-' . str_pad($request->id_kredit, 5, '0', STR_PAD_LEFT) . '-' . date('Ymd');
        
        Pengiriman::create([
            'id_kredit' => $request->id_kredit,
            'no_resi' => $no_resi,
            'kurir' => $request->kurir,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'tgl_estimasi_sampai' => $request->tgl_estimasi_sampai,
            'status' => 'Diproses',
        ]);
        
        return redirect()->route('marketing.pengiriman.index')
            ->with('success', 'Pengiriman berhasil dibuat. No Resi: ' . $no_resi);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $status = $request->status;
        
        $updateData = ['status' => $status];
        
        if ($status == 'Dikirim') {
            $updateData['tgl_pengiriman'] = now();
        } elseif ($status == 'Selesai') {
            $updateData['tgl_sampai'] = now();
        }
        
        $pengiriman->update($updateData);
        
        return redirect()->back()->with('success', 'Status pengiriman diperbarui menjadi ' . $status);
    }
    
    public function show($id)
    {
        $pengiriman = Pengiriman::with('kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor')
            ->findOrFail($id);
        
        return view('marketing.pengiriman.show', compact('pengiriman'));
    }

    public function edit($id)
{
    $pengiriman = Pengiriman::with('kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor')
        ->findOrFail($id);
    
    return view('marketing.pengiriman.edit', compact('pengiriman'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'kurir' => 'required|string',
        'alamat_pengiriman' => 'required|string',
        'tgl_estimasi_sampai' => 'nullable|date',
        'keterangan' => 'nullable|string',
    ]);
    
    $pengiriman = Pengiriman::findOrFail($id);
    
    $pengiriman->update([
        'kurir' => $request->kurir,
        'alamat_pengiriman' => $request->alamat_pengiriman,
        'tgl_estimasi_sampai' => $request->tgl_estimasi_sampai,
        'keterangan' => $request->keterangan,
    ]);
    
    return redirect()->route('marketing.pengiriman.show', $id)
        ->with('success', 'Data pengiriman berhasil diperbarui.');
}
}