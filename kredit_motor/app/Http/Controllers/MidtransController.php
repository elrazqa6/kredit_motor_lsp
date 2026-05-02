<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\PengajuanKredit;
use App\Models\Angsuran;
use App\Models\Kredit;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }

    // Pembayaran DP
    public function payDp($id)
    {
        $pengajuan = PengajuanKredit::with('pelanggan', 'motor')->findOrFail($id);
        
        $orderId = 'DP-' . $pengajuan->id . '-' . time();
        $amount = (int) $pengajuan->uang_muka;
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $pengajuan->pelanggan->nama_pelanggan ?? 'Customer',
                'email' => $pengajuan->pelanggan->email ?? 'customer@example.com',
            ],
            'item_details' => [
                [
                    'id' => 'DP-' . $pengajuan->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Uang Muka DP - ' . ($pengajuan->motor->nama_motor ?? 'Motor'),
                ]
            ],
        ];
        
        try {
            $snapToken = Snap::getSnapToken($params);
            
            return view('client.midtrans.payment', [
                'snapToken' => $snapToken,
                'type' => 'dp',
                'id' => $pengajuan->id,
                'amount' => $amount
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
    
    // Pembayaran Angsuran
    public function payAngsuran($id)
    {
        $angsuran = Angsuran::with(['kredit.pengajuanKredit.pelanggan', 'kredit.pengajuanKredit.motor'])->findOrFail($id);
        $pengajuan = $angsuran->kredit->pengajuanKredit;
        
        $orderId = 'AGS-' . $angsuran->id . '-' . time();
        $amount = (int) $angsuran->total_bayar;
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $pengajuan->pelanggan->nama_pelanggan ?? 'Customer',
                'email' => $pengajuan->pelanggan->email ?? 'customer@example.com',
            ],
            'item_details' => [
                [
                    'id' => 'AGS-' . $angsuran->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Angsuran Ke-' . $angsuran->angsuran_ke . ' - ' . ($pengajuan->motor->nama_motor ?? 'Motor'),
                ]
            ],
        ];
        
        try {
            $snapToken = Snap::getSnapToken($params);
            
            return view('client.midtrans.payment', [
                'snapToken' => $snapToken,
                'type' => 'angsuran',
                'id' => $angsuran->id,
                'amount' => $amount,
                'angsuran_ke' => $angsuran->angsuran_ke
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
    
    // Halaman pembayaran (view)
    public function paymentPage($snapToken, $type, $id, $amount)
    {
        return view('client.midtrans.payment', compact('snapToken', 'type', 'id', 'amount'));
    }
    
    // Webhook notifikasi dari Midtrans
    public function handleNotification(Request $request)
    {
        $notification = json_decode($request->getContent(), true);
        
        Log::info('Midtrans Notification:', $notification);
        
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $fraudStatus = $notification['fraud_status'];
        
        // Pembayaran DP
        if (strpos($orderId, 'DP-') === 0) {
            $pengajuanId = explode('-', $orderId)[1];
            $pengajuan = PengajuanKredit::find($pengajuanId);
            
            if ($pengajuan && ($transactionStatus == 'settlement' || $transactionStatus == 'capture')) {
                // Update status DP
                $pengajuan->update([
                    'status_dp' => 'Lunas',
                    'tgl_bayar_dp' => now(),
                ]);
                
                // ========== BUAT PENGIRIMAN OTOMATIS ==========
                $kredit = Kredit::where('id_pengajuan_kredit', $pengajuan->id)->first();
                
                if ($kredit) {
                    // Cek apakah sudah ada pengiriman
                    $existingPengiriman = Pengiriman::where('id_kredit', $kredit->id)->first();
                    
                    if (!$existingPengiriman) {
                        // Generate No Resi
                        $no_resi = 'KRM-' . $kredit->id . '-' . date('Ymd') . '-' . rand(100, 999);
                        $alamat = $pengajuan->pelanggan->alamat ?? '-';
                        
                        Pengiriman::create([
                            'id_kredit' => $kredit->id,
                            'no_resi' => $no_resi,
                            'kurir' => 'Akan ditentukan',
                            'alamat_pengiriman' => $alamat,
                            'status' => 'Diproses',
                            'keterangan' => 'Pengiriman dibuat otomatis setelah DP lunas',
                        ]);
                        
                        Log::info("Pengiriman otomatis dibuat untuk kredit ID: {$kredit->id}, No Resi: {$no_resi}");
                    }
                }
                // ===============================================
            }
        } 
        // Pembayaran Angsuran
        elseif (strpos($orderId, 'AGS-') === 0) {
            $angsuranId = explode('-', $orderId)[1];
            $angsuran = Angsuran::find($angsuranId);
            
            if ($angsuran && ($transactionStatus == 'settlement' || $transactionStatus == 'capture')) {
                $angsuran->update([
                    'tgl_bayar' => now(),
                ]);
                
                // Update sisa kredit
                $kredit = $angsuran->kredit;
                if ($kredit) {
                    $sisaBaru = $kredit->sisa_kredit - $angsuran->total_bayar;
                    $kredit->update(['sisa_kredit' => $sisaBaru]);
                    
                    if ($sisaBaru <= 0) {
                        $kredit->update(['status_kredit' => 'Lunas']);
                    }
                }
            }
        }
        
        return response()->json(['status' => 'ok']);
    }
    
    // Halaman sukses
    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        return view('client.midtrans.success', compact('orderId'));
    }
    
    // Halaman pending
    public function pending(Request $request)
    {
        return view('client.midtrans.pending');
    }
    
    // Halaman error
    public function error(Request $request)
    {
        return view('client.midtrans.error');
    }
}