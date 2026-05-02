@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Tambah Pelanggan</h3>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pelanggan.store') }}" method="POST">
        @csrf

        {{-- DATA UTAMA --}}
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>No Telp</label>
            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required>
        </div>

        <hr>

        {{-- ALAMAT UTAMA --}}
        <h5>Alamat Utama</h5>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat1" class="form-control" value="{{ old('alamat1') }}" required>
        </div>

        <div class="mb-3">
            <label>Kota</label>
            <input type="text" name="kota1" class="form-control" value="{{ old('kota1') }}" required>
        </div>

        <div class="mb-3">
            <label>Provinsi</label>
            <input type="text" name="provinsi1" class="form-control" value="{{ old('provinsi1') }}" required>
        </div>

        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="kodepos1" class="form-control" value="{{ old('kodepos1') }}" required>
        </div>

        <hr>

        {{-- ALAMAT TAMBAHAN (OPTIONAL) --}}
        <h5>Alamat Tambahan (Opsional)</h5>

        <div class="mb-3">
            <label>Alamat 2</label>
            <input type="text" name="alamat2" class="form-control" value="{{ old('alamat2') }}">
        </div>

        <div class="mb-3">
            <label>Kota 2</label>
            <input type="text" name="kota2" class="form-control" value="{{ old('kota2') }}">
        </div>

        <div class="mb-3">
            <label>Provinsi 2</label>
            <input type="text" name="provinsi2" class="form-control" value="{{ old('provinsi2') }}">
        </div>

        <div class="mb-3">
            <label>Kode Pos 2</label>
            <input type="text" name="kodepos2" class="form-control" value="{{ old('kodepos2') }}">
        </div>

        <hr>

        {{-- SUBMIT --}}
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection