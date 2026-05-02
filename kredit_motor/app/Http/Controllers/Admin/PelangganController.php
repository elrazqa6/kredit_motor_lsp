// app/Http/Controllers/Admin/PengajuanController.php

public function update(Request $request, $id)
{
    $pengajuan = PengajuanKredit::findOrFail($id);
    
    $request->validate([
        'status_pengajuan' => 'required|in:Menunggu Konfirmasi,Diterima,Ditolak',
        'keterangan_status_pengajuan' => 'nullable|string',
    ]);
    
    $oldStatus = $pengajuan->status_pengajuan;
    $newStatus = $request->status_pengajuan;
    
    // Update status pengajuan
    $pengajuan->status_pengajuan = $newStatus;
    $pengajuan->keterangan_status_pengajuan = $request->keterangan_status_pengajuan;
    $pengajuan->save();
    
    // Jika status berubah menjadi Diterima (Disetujui)
    if ($newStatus == 'Diterima' && $oldStatus != 'Diterima') {
        // Cek apakah sudah ada record kredit
        $existingKredit = Kredit::where('id_pengajuan_kredit', $pengajuan->id)->first();
        
        if (!$existingKredit) {
            // Cari metode bayar default
            $metodeBayar = MetodeBayar::first();
            
            // Buat record kredit
            Kredit::create([
                'id_pengajuan_kredit' => $pengajuan->id,
                'id_metode_bayar' => $metodeBayar->id ?? 1,
                'tgl_mulai_kredit' => now(),
                'tgl_selesai_kredit' => now()->addMonths($pengajuan->tenor),
                'sisa_kredit' => $pengajuan->harga_kredit,
                'status_kredit' => 'Dicicil', // ← PERBAIKAN: gunakan 'Dicicil' bukan 'aktif'
                'keterangan_status_kredit' => 'Kredit aktif dari pengajuan yang disetujui',
            ]);
        }
    }
    
    // Jika status Ditolak, update status kredit jika ada
    if ($newStatus == 'Ditolak') {
        Kredit::where('id_pengajuan_kredit', $pengajuan->id)
            ->update(['status_kredit' => 'Macet']);
    }
    
    return redirect()->route('admin.pengajuan.index')
        ->with('success', 'Status pengajuan berhasil diperbarui');
}