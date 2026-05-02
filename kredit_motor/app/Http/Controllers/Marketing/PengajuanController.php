<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKredit;
use App\Models\Kredit;
use App\Models\MetodeBayar;
use App\Models\Angsuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanKredit::with(['pelanggan', 'motor', 'jenisCicilan', 'asuransi', 'kredit']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pengajuan', $request->status);
        }
        
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tgl_pengajuan_kredit', $request->tanggal);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pelanggan', function($q2) use ($search) {
                    $q2->where('nama_pelanggan', 'like', "%{$search}%");
                })->orWhereHas('motor', function($q2) use ($search) {
                    $q2->where('nama_motor', 'like', "%{$search}%");
                });
            });
        }
        
        $perPage = $request->get('per_page', 10);
        $pengajuan = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return view('marketing.pengajuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanKredit::with(['pelanggan', 'motor', 'jenisCicilan', 'asuransi', 'kredit.angsuran'])->findOrFail($id);
        return view('marketing.pengajuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanKredit::findOrFail($id);
        
        $request->validate([
            'status_pengajuan' => 'required|in:Menunggu,Disetujui,Ditolak',
            'keterangan_status_pengajuan' => 'nullable|string|max:255',
        ]);
        
        $oldStatus = $pengajuan->status_pengajuan;
        $newStatus = $request->status_pengajuan;
        
        DB::beginTransaction();
        
        try {
            $pengajuan->status_pengajuan = $newStatus;
            $pengajuan->keterangan_status_pengajuan = $request->keterangan_status_pengajuan;
            $pengajuan->save();
            
            // Jika status berubah menjadi Disetujui
            if ($newStatus == 'Disetujui' && $oldStatus != 'Disetujui') {
                $existingKredit = Kredit::where('id_pengajuan_kredit', $pengajuan->id)->first();
                
                if (!$existingKredit) {
                    // Cari metode bayar
                    $metodeBayar = MetodeBayar::first();
                    if (!$metodeBayar) {
                        $metodeBayar = MetodeBayar::create([
                            'metode_pembayaran' => 'Cash',
                            'tempat_bayar' => 'Kantor Dealer',
                            'no_rekening' => null,
                            'url_logo' => null,
                        ]);
                    }
                    
                    // Buat kredit
                    $kredit = Kredit::create([
                        'id_pengajuan_kredit' => $pengajuan->id,
                        'id_metode_bayar' => $metodeBayar->id,
                        'tgl_mulai_kredit' => now(),
                        'tgl_selesai_kredit' => now()->addMonths($pengajuan->tenor),
                        'sisa_kredit' => $pengajuan->harga_kredit,
                        'status_kredit' => 'Dicicil',
                        'keterangan_status_kredit' => 'Kredit aktif dari pengajuan yang disetujui',
                    ]);
                    
                    // ========== GENERATE ANGSURAN DENGAN JATUH TEMPO ==========
                    $tenor = (int) $pengajuan->tenor;
                    $cicilan = (float) $pengajuan->cicilan_perbulan;
                    
                    if ($tenor > 0 && $cicilan > 0) {
                        for ($i = 1; $i <= $tenor; $i++) {
                            // Hitung tanggal jatuh tempo: tgl_mulai_kredit + i bulan
                            $jatuhTempo = now()->addMonths($i);
                            
                            Angsuran::create([
                                'id_kredit' => $kredit->id,
                                'angsuran_ke' => $i,
                                'tgl_jatuh_tempo' => $jatuhTempo,  // ← TAMBAHKAN JATUH TEMPO
                                'total_bayar' => $cicilan,
                                'keterangan' => 'Angsuran ke-' . $i,
                            ]);
                        }
                    }
                    // =======================================================
                }
            }
            
            // Jika status Ditolak
            if ($newStatus == 'Ditolak') {
                $kredit = Kredit::where('id_pengajuan_kredit', $pengajuan->id)->first();
                if ($kredit) {
                    $kredit->update(['status_kredit' => 'Macet']);
                    Angsuran::where('id_kredit', $kredit->id)
                        ->whereNull('tgl_bayar')
                        ->update(['keterangan' => 'Kredit ditolak']);
                }
            }
            
            DB::commit();
            
            return redirect()->route('marketing.pengajuan.index')
                ->with('success', 'Status pengajuan berhasil diperbarui dan ' . $pengajuan->tenor . ' jadwal angsuran telah dibuat.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        $pengajuan = PengajuanKredit::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            $kredit = Kredit::where('id_pengajuan_kredit', $id)->first();
            
            if ($kredit) {
                // Hapus angsuran
                Angsuran::where('id_kredit', $kredit->id)->delete();
                $kredit->delete();
            }
            
            $pengajuan->delete();
            
            DB::commit();
            
            return redirect()->route('marketing.pengajuan.index')
                ->with('success', 'Pengajuan kredit dan semua data terkait berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        }
    }
    public function updateStatusDp(Request $request, $id)
{
    $pengajuan = PengajuanKredit::findOrFail($id);
    
    $request->validate([
        'status_dp' => 'required|in:Belum Bayar,Menunggu,Lunas,Ditolak',
        'keterangan_dp' => 'nullable|string|max:255',
    ]);
    
    $oldStatus = $pengajuan->status_dp;
    $newStatus = $request->status_dp;
    
    $updateData = ['status_dp' => $newStatus];
    
    if ($newStatus == 'Lunas' && $oldStatus != 'Lunas') {
        $updateData['tgl_bayar_dp'] = now();
    }
    
    if ($request->keterangan_dp) {
        $updateData['keterangan_dp'] = $request->keterangan_dp;
    }
    
    $pengajuan->update($updateData);
    
    return redirect()->route('marketing.pengajuan.index')
        ->with('success', 'Status DP berhasil diperbarui menjadi ' . $newStatus);
}
}