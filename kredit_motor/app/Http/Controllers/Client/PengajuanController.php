<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKredit;
use App\Models\Motor;
use App\Models\JenisCicilan;
use App\Models\Asuransi;
use App\Models\MetodeBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    /**
     * Display a listing of user's submissions.
     */
    public function index()
{
    $pelanggan = Auth::user()->pelanggan;
    
    // Gunakan paginate() BUKAN get()
    $pengajuan = PengajuanKredit::with(['motor', 'jenisCicilan', 'asuransi', 'metodeBayar'])
        ->where('id_pelanggan', $pelanggan->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);  // ← pakai paginate, bukan get()
    
    return view('client.pengajuan.index', compact('pengajuan'));
}
    /**
     * Show the form for creating a new submission.
     */
    public function create()
    {
        $motors = Motor::where('stok', '>', 0)->get();
        $jenisCicilans = JenisCicilan::all();
        $asuransiList = Asuransi::all();
        $metodeBayar = MetodeBayar::all();  // ← INI YANG DIPERBAIKI
        
        return view('client.pengajuan.create', compact('motors', 'jenisCicilans', 'asuransiList', 'metodeBayar'));
    }

    /**
     * Store a newly created submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_motor' => 'required|exists:motor,id',
            'id_jenis_cicilan' => 'required|exists:jenis_cicilan,id',
            'id_asuransi' => 'nullable|exists:asuransi,id',
            'id_metode_bayar' => 'required|exists:metode_bayar,id',  // ← VALIDASI
            'uang_muka' => 'required|numeric|min:0',
            'url_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_slip_gaji' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        $pelanggan = Auth::user()->pelanggan;
        
        // Hitung ulang nilai kredit
        $motor = Motor::findOrFail($request->id_motor);
        $jenisCicilan = JenisCicilan::findOrFail($request->id_jenis_cicilan);
        $asuransi = Asuransi::find($request->id_asuransi);
        
        $hargaCash = $motor->harga_jual;
        $uangMuka = $request->uang_muka;
        $dpPersen = ($uangMuka / $hargaCash) * 100;
        $tenor = $jenisCicilan->lama_cicilan;
        $margin = $jenisCicilan->margin_kredit;
        $biayaAsuransi = $asuransi ? $asuransi->biaya : 0;
        
        $pokokKredit = $hargaCash - $uangMuka + $biayaAsuransi;
        $bungaTotal = $pokokKredit * ($margin / 100) * ($tenor / 12);
        $hargaKredit = $pokokKredit + $bungaTotal;
        $cicilanPerbulan = $hargaKredit / $tenor;
        $biayaAsuransiPerbulan = $biayaAsuransi / $tenor;
        
        // Upload files
        $urlKtp = $request->file('url_ktp')->store('dokumen/ktp', 'public');
        $urlKk = $request->hasFile('url_kk') ? $request->file('url_kk')->store('dokumen/kk', 'public') : null;
        $urlNpwp = $request->hasFile('url_npwp') ? $request->file('url_npwp')->store('dokumen/npwp', 'public') : null;
        $urlSlipGaji = $request->hasFile('url_slip_gaji') ? $request->file('url_slip_gaji')->store('dokumen/slip_gaji', 'public') : null;
        $urlFoto = $request->hasFile('url_foto') ? $request->file('url_foto')->store('dokumen/foto', 'public') : null;
        
        // Create submission
        $pengajuan = PengajuanKredit::create([
            'id_pelanggan' => $pelanggan->id,
            'id_motor' => $request->id_motor,
            'id_jenis_cicilan' => $request->id_jenis_cicilan,
            'id_asuransi' => $request->id_asuransi,
            'id_metode_bayar' => $request->id_metode_bayar,  // ← SIMPAN METODE BAYAR
            'uang_muka' => $uangMuka,
            'status_pengajuan' => 'Menunggu',
            'tgl_pengajuan_kredit' => now(),
            'harga_cash' => $hargaCash,
            'dp' => $dpPersen,
            'harga_kredit' => $hargaKredit,
            'biaya_asuransi_perbulan' => $biayaAsuransiPerbulan,
            'cicilan_perbulan' => $cicilanPerbulan,
            'tenor' => $tenor,
            'url_ktp' => $urlKtp,
            'url_kk' => $urlKk,
            'url_npwp' => $urlNpwp,
            'url_slip_gaji' => $urlSlipGaji,
            'url_foto' => $urlFoto,
            'keterangan_status_pengajuan' => $request->keterangan_status_pengajuan,
        ]);
        
        return redirect()->route('client.pengajuan.show', $pengajuan->id)
            ->with('success', 'Pengajuan kredit berhasil dikirim!');
    }
    
    /**
     * Display the specified submission.
     */
    public function show($id)
    {
        $pelanggan = Auth::user()->pelanggan;
        $pengajuan = PengajuanKredit::with(['motor', 'jenisCicilan', 'asuransi', 'metodeBayar', 'kredit'])
            ->where('id_pelanggan', $pelanggan->id)
            ->findOrFail($id);
        
        return view('client.pengajuan.show', compact('pengajuan'));
    }
    
    /**
     * Cancel a submission (only if status is Menunggu).
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Auth::user()->pelanggan;
        $pengajuan = PengajuanKredit::where('id_pelanggan', $pelanggan->id)->findOrFail($id);
        
        if ($pengajuan->status_pengajuan != 'Menunggu') {
            return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan karena sudah diproses.');
        }
        
        $pengajuan->status_pengajuan = 'Ditolak';
        $pengajuan->keterangan_status_pengajuan = $request->keterangan ?? 'Dibatalkan oleh pelanggan';
        $pengajuan->save();
        
        return redirect()->route('client.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    /**
 * Cancel a submission (soft delete or change status to Ditolak).
 */
public function cancel($id)
{
    $pelanggan = Auth::user()->pelanggan;
    $pengajuan = PengajuanKredit::where('id_pelanggan', $pelanggan->id)->findOrFail($id);
    
    if ($pengajuan->status_pengajuan != 'Menunggu') {
        return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan karena sudah diproses.');
    }
    
    $pengajuan->status_pengajuan = 'Ditolak';
    $pengajuan->keterangan_status_pengajuan = 'Dibatalkan oleh pelanggan';
    $pengajuan->save();
    
    return redirect()->route('client.pengajuan.index')
        ->with('success', 'Pengajuan berhasil dibatalkan.');
}
}