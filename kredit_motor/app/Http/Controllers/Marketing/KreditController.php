<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Kredit;
use App\Models\PengajuanKredit;
use App\Models\MetodeBayar;
use Illuminate\Http\Request;

class KreditController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $kredit = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor', 'angsuran'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        return view('marketing.kredit.index', compact('kredit'));
    }
    
    public function create()
    {
        $pengajuanDisetujui = PengajuanKredit::with(['pelanggan', 'motor'])
            ->where('status_pengajuan', 'Diterima')
            ->whereDoesntHave('kredit')
            ->get();
        
        $metodeBayar = MetodeBayar::all();
        
        return view('marketing.kredit.create', compact('pengajuanDisetujui', 'metodeBayar'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_pengajuan_kredit' => 'required|exists:pengajuan_kredit,id',
            'id_metode_bayar' => 'required|exists:metode_bayar,id',
            'tgl_mulai_kredit' => 'required|date',
            'sisa_kredit' => 'required|numeric|min:0',
            'status_kredit' => 'required|string',
            'keterangan_status_kredit' => 'nullable|string',
        ]);
        
        $pengajuan = PengajuanKredit::findOrFail($request->id_pengajuan_kredit);
        
        // Hitung tanggal selesai berdasarkan tenor
        $tglMulai = new \DateTime($request->tgl_mulai_kredit);
        $tglSelesai = clone $tglMulai;
        $tglSelesai->modify("+{$pengajuan->tenor} months");
        
        Kredit::create([
            'id_pengajuan_kredit' => $request->id_pengajuan_kredit,
            'id_metode_bayar' => $request->id_metode_bayar,
            'tgl_mulai_kredit' => $request->tgl_mulai_kredit,
            'tgl_selesai_kredit' => $tglSelesai->format('Y-m-d'),
            'sisa_kredit' => $request->sisa_kredit,
            'status_kredit' => $request->status_kredit,
            'keterangan_status_kredit' => $request->keterangan_status_kredit,
        ]);
        
        return redirect()->route('marketing.kredit.index')
            ->with('success', 'Data kredit berhasil ditambahkan!');
    }
    
    public function show($id)
    {
        $kredit = Kredit::with(['pengajuanKredit.pelanggan', 'pengajuanKredit.motor', 'metodeBayar', 'angsuran'])
            ->findOrFail($id);
        
        return view('marketing.kredit.show', compact('kredit'));
    }
    
    public function update(Request $request, $id)
    {
        $kredit = Kredit::findOrFail($id);
        
        $request->validate([
            'status_kredit' => 'required|string',
            'keterangan_status_kredit' => 'nullable|string',
        ]);
        
        $kredit->update([
            'status_kredit' => $request->status_kredit,
            'keterangan_status_kredit' => $request->keterangan_status_kredit,
        ]);
        
        return redirect()->route('marketing.kredit.index')
            ->with('success', 'Status kredit berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $kredit = Kredit::findOrFail($id);
        
        // Cek apakah ada angsuran
        if ($kredit->angsuran()->count() > 0) {
            return redirect()->route('marketing.kredit.index')
                ->with('error', 'Kredit tidak dapat dihapus karena sudah memiliki angsuran!');
        }
        
        $kredit->delete();
        
        return redirect()->route('marketing.kredit.index')
            ->with('success', 'Data kredit berhasil dihapus!');
    }
}