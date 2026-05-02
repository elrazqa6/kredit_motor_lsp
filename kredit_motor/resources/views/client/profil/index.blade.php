@extends('layouts.client')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user me-2 text-primary"></i> Informasi Profil
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('client.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" class="form-control" 
                                value="{{ Auth::user()->pelanggan->nama_pelanggan ?? '' }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control" 
                                value="{{ Auth::user()->pelanggan->no_telp ?? '' }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="alamat1" class="form-control" rows="3" required 
                                placeholder="Jl. Contoh No. 123, RT 01/RW 02, Kelurahan, Kecamatan, Kota">{{ Auth::user()->pelanggan->alamat1 ?? '' }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kota</label>
                            <input type="text" name="kota1" class="form-control" 
                                value="{{ Auth::user()->pelanggan->kota1 ?? '' }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Provinsi</label>
                            <input type="text" name="provinsi1" class="form-control" 
                                value="{{ Auth::user()->pelanggan->provinsi1 ?? '' }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Pos</label>
                            <input type="text" name="kodepos1" class="form-control" 
                                value="{{ Auth::user()->pelanggan->kodepos1 ?? '' }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection