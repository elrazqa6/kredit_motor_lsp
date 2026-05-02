<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Angsuran;
use App\Models\Kredit;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $angsuran = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        return view('marketing.angsuran.index', compact('angsuran'));
    }
    
    public function create()
    {
        $kreditAktif = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor', 'angsuran'])
            ->where('status_kredit', 'aktif')
            ->where('sisa_kredit', '>', 0)
            ->get();
        
        return view('marketing.angsuran.create', compact('kreditAktif'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_kredit' => 'required|exists:kredit,id',
            'tgl_bayar' => 'required|date',
            'angsuran_ke' => 'required|integer|min:1',
            'total_bayar' => 'required|numeric|min:0',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);
        
        $angsuran = Angsuran::create($request->all());
        
        // Update sisa kredit
        $kredit = Kredit::find($request->id_kredit);
        $sisaBaru = $kredit->sisa_kredit - $request->total_bayar;
        $kredit->update(['sisa_kredit' => max(0, $sisaBaru)]);
        
        // Jika sisa kredit 0, update status kredit jadi lunas
        if ($kredit->sisa_kredit <= 0) {
            $kredit->update(['status_kredit' => 'lunas']);
        }
        
        return redirect()->route('marketing.angsuran.index')
            ->with('success', 'Angsuran berhasil ditambahkan!');
    }
    
    public function show($id)
    {
        $angsuran = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor', 'kredit.pengajuanKredit.motor.jenisMotor'])
            ->findOrFail($id);
        
        return view('marketing.angsuran.show', compact('angsuran'));
    }
    
    public function edit($id)
    {
        $angsuran = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])
            ->findOrFail($id);
        
        return view('marketing.angsuran.edit', compact('angsuran'));
    }
    
    public function update(Request $request, $id)
    {
        $angsuran = Angsuran::findOrFail($id);
        
        $request->validate([
            'tgl_bayar' => 'required|date',
            'total_bayar' => 'required|numeric|min:0',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);
        
        $oldTotalBayar = $angsuran->total_bayar;
        
        $angsuran->update($request->all());
        
        // Update sisa kredit
        $kredit = Kredit::find($angsuran->id_kredit);
        $sisaBaru = $kredit->sisa_kredit + $oldTotalBayar - $request->total_bayar;
        $kredit->update(['sisa_kredit' => max(0, $sisaBaru)]);
        
        // Update status kredit
        if ($kredit->sisa_kredit <= 0) {
            $kredit->update(['status_kredit' => 'lunas']);
        } elseif ($kredit->status_kredit == 'lunas') {
            $kredit->update(['status_kredit' => 'aktif']);
        }
        
        return redirect()->route('marketing.angsuran.index')
            ->with('success', 'Angsuran berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $angsuran = Angsuran::findOrFail($id);
        $kredit = Kredit::find($angsuran->id_kredit);
        
        // Kembalikan sisa kredit
        $kredit->update(['sisa_kredit' => $kredit->sisa_kredit + $angsuran->total_bayar]);
        
        // Update status kredit
        if ($kredit->status_kredit == 'lunas') {
            $kredit->update(['status_kredit' => 'aktif']);
        }
        
        $angsuran->delete();
        
        return redirect()->route('marketing.angsuran.index')
            ->with('success', 'Angsuran berhasil dihapus!');
    }

    public function print($id)
{
    $user = Auth::user();
    
    if ($user->role !== 'client') {
        return redirect()->route('client.dashboard');
    }
    
    $pelanggan = $user->pelanggan;
    
    $angsuran = Angsuran::with(['kredit.pengajuanKredit.motor', 'kredit.pengajuanKredit.pelanggan'])
        ->whereHas('kredit.pengajuanKredit', fn($q) => $q->where('id_pelanggan', $pelanggan->id))
        ->findOrFail($id);
    
    // Hanya angsuran yang sudah lunas yang bisa di-print
    if (!$angsuran->tgl_bayar) {
        return redirect()->route('client.angsuran.show', $id)
            ->with('error', 'Hanya angsuran yang sudah lunas yang bisa dicetak.');
    }
    
    return view('client.angsuran.print', compact('angsuran'));
}
}