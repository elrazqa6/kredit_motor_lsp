@extends('layouts.marketing')

@section('title', 'Edit Pengiriman')
@section('page-title', 'Edit Data Pengiriman')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i> Edit Pengiriman
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info mb-4">
                    <strong>No Resi:</strong> {{ $pengiriman->no_resi }}<br>
                    <strong>Pelanggan:</strong> {{ $pengiriman->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}
                </div>
                
                <form action="{{ route('marketing.pengiriman.update', $pengiriman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kurir</label>
                        <select name="kurir" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>
                            <option value="JNE" {{ $pengiriman->kurir == 'JNE' ? 'selected' : '' }}>JNE</option>
                            <option value="J&T" {{ $pengiriman->kurir == 'J&T' ? 'selected' : '' }}>J&T Express</option>
                            <option value="SiCepat" {{ $pengiriman->kurir == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                            <option value="Ninja Express" {{ $pengiriman->kurir == 'Ninja Express' ? 'selected' : '' }}>Ninja Express</option>
                            <option value="Lion Parcel" {{ $pengiriman->kurir == 'Lion Parcel' ? 'selected' : '' }}>Lion Parcel</option>
                            <option value="Pos Indonesia" {{ $pengiriman->kurir == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Pengiriman</label>
                        <textarea name="alamat_pengiriman" class="form-control" rows="4" required>{{ $pengiriman->alamat_pengiriman }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estimasi Sampai</label>
                        <input type="date" name="tgl_estimasi_sampai" class="form-control" value="{{ $pengiriman->tgl_estimasi_sampai ? \Carbon\Carbon::parse($pengiriman->tgl_estimasi_sampai)->format('Y-m-d') : '' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $pengiriman->keterangan }}</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('marketing.pengiriman.show', $pengiriman->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection