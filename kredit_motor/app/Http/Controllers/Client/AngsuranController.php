<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Angsuran;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AngsuranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'client') {
            return redirect()->route('client.dashboard')->with('error', 'Akses ditolak.');
        }
        
        $pelanggan = $user->pelanggan;
        
        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'user_id' => $user->id,
                'nama_pelanggan' => $user->name,
                'email' => $user->email,
                'no_telp' => '-',
                'alamat1' => '-',
            ]);
        }
        
        $tab = $request->get('tab', 'semua');
        
        $query = Angsuran::whereHas('kredit.pengajuanKredit', function ($q) use ($pelanggan) {
            $q->where('id_pelanggan', $pelanggan->id);
        })->with(['kredit.pengajuanKredit.motor']);
        
        if ($tab === 'belum_bayar') {
            $query->whereNull('tgl_bayar');
        } elseif ($tab === 'lunas') {
            $query->whereNotNull('tgl_bayar');
        }
        
        $query->orderByRaw("CASE WHEN tgl_bayar IS NOT NULL THEN 1 ELSE 0 END ASC")
              ->orderByRaw("COALESCE(tgl_jatuh_tempo, '9999-12-31') ASC")
              ->orderBy('created_at', 'desc');
        
        $angsuran = $query->paginate(10)->withQueryString();
        
        // Statistik
        $all = Angsuran::whereHas('kredit.pengajuanKredit', function ($q) use ($pelanggan) {
            $q->where('id_pelanggan', $pelanggan->id);
        })->get(['tgl_bayar', 'tgl_jatuh_tempo']);
        
        $statistik = [
            'lunas'              => $all->whereNotNull('tgl_bayar')->count(),
            'belum_bayar'        => $all->whereNull('tgl_bayar')->count(),
            'hampir_jatuh_tempo' => $all->whereNull('tgl_bayar')
                ->filter(fn($a) => $a->tgl_jatuh_tempo
                    && Carbon::parse($a->tgl_jatuh_tempo)->between(
                        Carbon::today(), Carbon::today()->addDays(7)))
                ->count(),
            'jatuh_tempo'        => $all->whereNull('tgl_bayar')
                ->filter(fn($a) => $a->tgl_jatuh_tempo
                    && Carbon::parse($a->tgl_jatuh_tempo)->lt(Carbon::today()))
                ->count(),
        ];
        
        // Notifikasi
        $notifikasi = Angsuran::whereHas('kredit.pengajuanKredit', function ($q) use ($pelanggan) {
            $q->where('id_pelanggan', $pelanggan->id);
        })
            ->with(['kredit.pengajuanKredit.motor'])
            ->whereNull('tgl_bayar')
            ->whereNotNull('tgl_jatuh_tempo')
            ->whereDate('tgl_jatuh_tempo', '<=', Carbon::today()->addDays(7))
            ->orderBy('tgl_jatuh_tempo', 'asc')
            ->get()
            ->each(function ($item) {
                $item->sisa_hari = (int) Carbon::today()->diffInDays($item->tgl_jatuh_tempo, false);
            });
        
        return view('client.angsuran.index', compact('angsuran', 'statistik', 'notifikasi', 'tab'));
    }

    public function show($id)
    {
        $user = Auth::user();
        
        if ($user->role !== 'client') {
            return redirect()->route('client.dashboard');
        }
        
        $pelanggan = $user->pelanggan;
        
        $angsuran = Angsuran::with(['kredit.pengajuanKredit.motor'])
            ->whereHas('kredit.pengajuanKredit', fn($q) => $q->where('id_pelanggan', $pelanggan->id))
            ->findOrFail($id);
        
        $sisaHari = (!$angsuran->tgl_bayar && $angsuran->tgl_jatuh_tempo)
            ? (int) Carbon::today()->diffInDays($angsuran->tgl_jatuh_tempo, false)
            : null;
        
        return view('client.angsuran.show', compact('angsuran', 'sisaHari'));
    }
    public function print($id)
{
    $user = Auth::user();
    
    if ($user->role !== 'client') {
        return redirect()->route('client.dashboard');
    }
    
    $pelanggan = $user->pelanggan;
    
    $angsuran = Angsuran::with(['kredit.pengajuanKredit.motor', 'kredit.pengajuanKredit.pelanggan', 'kredit.pengiriman'])
        ->whereHas('kredit.pengajuanKredit', fn($q) => $q->where('id_pelanggan', $pelanggan->id))
        ->findOrFail($id);
    
    if (!$angsuran->tgl_bayar) {
        return redirect()->route('client.angsuran.show', $id)
            ->with('error', 'Hanya angsuran yang sudah lunas yang bisa dicetak.');
    }
    
    return view('client.angsuran.print', compact('angsuran'));
}
    // Tidak perlu method formBayar dan bayar lagi, karena pakai Midtrans langsung
    // Hapus method formBayar() dan bayar() jika ada
}

