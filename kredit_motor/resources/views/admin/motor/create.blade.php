@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">Tambah Motor</div>
  <div class="card-body">

    {{-- ERROR --}}
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <strong>Terjadi kesalahan!</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form action="{{ route('admin.motor.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Nama Motor --}}
      <input type="text" name="nama_motor" 
        value="{{ old('nama_motor') }}" 
        placeholder="Nama Motor" 
        class="form-control mb-2">

      {{-- Merk --}}
      <input type="text" name="merk" 
        value="{{ old('merk') }}" 
        placeholder="Merk" 
        class="form-control mb-2">

      {{-- Jenis --}}
      <select name="jenis_id" class="form-control mb-2">
        <option value="">-- Pilih Jenis Motor --</option>
        @foreach($jenisMotor as $j)
          <option value="{{ $j->id }}" 
            {{ old('jenis_id') == $j->id ? 'selected' : '' }}>
            {{ $j->nama_jenis }}
          </option>
        @endforeach
      </select>

      {{-- Harga --}}
      <input type="number" name="harga_cash" 
        value="{{ old('harga_cash') }}" 
        placeholder="Harga Cash" 
        class="form-control mb-2">

      <input type="number" name="harga_jual" 
        value="{{ old('harga_jual') }}" 
        placeholder="Harga Jual" 
        class="form-control mb-2">

      {{-- Warna --}}
      <input type="text" name="warna" 
        value="{{ old('warna') }}" 
        placeholder="Warna" 
        class="form-control mb-2">

      {{-- Tahun --}}
      <input type="text" name="tahun_produksi" 
        value="{{ old('tahun_produksi') }}" 
        placeholder="Tahun" 
        class="form-control mb-2">

      {{-- Stok --}}
      <input type="number" name="stok" 
        value="{{ old('stok') }}" 
        placeholder="Stok" 
        class="form-control mb-2">

      {{-- Foto --}}
      <input type="file" name="foto1" class="form-control mb-3">

      <button class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection