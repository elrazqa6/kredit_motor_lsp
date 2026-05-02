<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;
        
        $pengiriman = Pengiriman::with(['kredit.pengajuanKredit.motor'])
            ->whereHas('kredit.pengajuanKredit', function($q) use ($pelanggan) {
                $q->where('id_pelanggan', $pelanggan->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('client.pengiriman.show', compact('pengiriman'));
    }
    
    public function show($id)
    {
        $pelanggan = Auth::user()->pelanggan;
        
        $pengiriman = Pengiriman::with(['kredit.pengajuanKredit.motor', 'kredit.pengajuanKredit.pelanggan'])
            ->whereHas('kredit.pengajuanKredit', function($q) use ($pelanggan) {
                $q->where('id_pelanggan', $pelanggan->id);
            })
            ->findOrFail($id);
        
        // Hitung progress berdasarkan status
        $progress = 0;
        if ($pengiriman->status == 'Diproses') $progress = 25;
        elseif ($pengiriman->status == 'Dikirim') $progress = 75;
        elseif ($pengiriman->status == 'Selesai') $progress = 100;
        
        return view('client.pengiriman.show', compact('pengiriman', 'progress'));
    }
}