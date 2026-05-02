<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKredit;
use App\Models\Pelanggan;
use App\Models\Motor;
use App\Models\JenisCicilan;
use App\Models\Asuransi;
use App\Models\MetodeBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengajuanOfflineController extends Controller
{
    /**
     * Form input pengajuan offline
     */
    public function create()
    {
        $motors = Motor::where('stok', '>', 0)->get();
        $jenisCicilans = JenisCicilan::all();
        $asuransiList = Asuransi::all();
        $metodeBayar = MetodeBayar::all();
        
        return view('marketing.pengajuan-offline.create', compact(
            'motors', 'jenisCicilans', 'asuransiList', 'metodeBayar'
        ));
    }
    
    /**
     * Simpan pengajuan offline (dengan auto create user & pelanggan)
     */
    public function store(Request $request)
    {
        $request->validate([
            // Data Pelanggan
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kodepos' => 'nullable|string',
            
            // Data Pengajuan
            'id_motor' => 'required|exists:motor,id',
            'id_jenis_cicilan' => 'required|exists:jenis_cicilan,id',
            'id_asuransi' => 'nullable|exists:asuransi,id',
            'id_metode_bayar' => 'required|exists:metode_bayar,id',
            'uang_muka' => 'required|numeric|min:0',
            
            // Dokumen (opsional untuk offline)
            'url_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_slip_gaji' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'url_foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        DB::beginTransaction();
        
        try {
            // 1. Buat User (role client)
            $user = \App\Models\User::create([
                'name' => $request->nama_pelanggan,
                'email' => $request->email,
                'password' => Hash::make('password123'), // default password
                'role' => 'client',
            ]);
            
            // 2. Buat Data Pelanggan
            $pelanggan = Pelanggan::create([
                'user_id' => $user->id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'alamat1' => $request->alamat,
                'kota1' => $request->kota,
                'provinsi1' => $request->provinsi,
                'kodepos1' => $request->kodepos,
            ]);
            
            // 3. Hitung Nilai Kredit
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
            
            // 4. Upload Dokumen (jika ada)
            $urlKtp = $request->hasFile('url_ktp') ? $request->file('url_ktp')->store('dokumen/ktp', 'public') : null;
            $urlKk = $request->hasFile('url_kk') ? $request->file('url_kk')->store('dokumen/kk', 'public') : null;
            $urlNpwp = $request->hasFile('url_npwp') ? $request->file('url_npwp')->store('dokumen/npwp', 'public') : null;
            $urlSlipGaji = $request->hasFile('url_slip_gaji') ? $request->file('url_slip_gaji')->store('dokumen/slip_gaji', 'public') : null;
            $urlFoto = $request->hasFile('url_foto') ? $request->file('url_foto')->store('dokumen/foto', 'public') : null;
            
            // 5. Buat Pengajuan Kredit
            $pengajuan = PengajuanKredit::create([
                'id_pelanggan' => $pelanggan->id,
                'id_motor' => $request->id_motor,
                'id_jenis_cicilan' => $request->id_jenis_cicilan,
                'id_asuransi' => $request->id_asuransi,
                'id_metode_bayar' => $request->id_metode_bayar,
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
                'keterangan_status_pengajuan' => 'Pengajuan offline oleh marketing',
            ]);
            
            DB::commit();
            
            return redirect()->route('marketing.pengajuan-offline.success', $pengajuan->id)
                ->with('success', 'Pengajuan offline berhasil disimpan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan pengajuan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Halaman sukses setelah input offline
     */
    public function success($id)
    {
        $pengajuan = PengajuanKredit::with(['pelanggan', 'motor'])->findOrFail($id);
        return view('marketing.pengajuan-offline.success', compact('pengajuan'));
    }
    
    /**
     * Daftar semua pengajuan offline
     */
    public function index()
    {
        $pengajuan = PengajuanKredit::with(['pelanggan', 'motor'])
            ->where('keterangan_status_pengajuan', 'like', '%offline%')
            ->orWhere('keterangan_status_pengajuan', 'like', '%marketing%')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('marketing.pengajuan-offline.index', compact('pengajuan'));
    }
}