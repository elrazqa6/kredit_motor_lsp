<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;
        return view('client.profil.index', compact('pelanggan'));
    }
    
    public function update(Request $request)
    {
        $pelanggan = Auth::user()->pelanggan;
        
        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_telp' => $request->no_telp,
            'alamat1' => $request->alamat1,
            'kota1' => $request->kota1,
            'provinsi1' => $request->provinsi1,
            'kodepos1' => $request->kodepos1,
        ]);
        
        return redirect()->route('client.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}