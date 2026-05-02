@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">Edit Motor</div>
  <div class="card-body">
    <form action="{{ route('admin.motor.update', $motor->id) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <input type="text" name="nama_motor" value="{{ $motor->nama_motor }}" class="form-control mb-2">
      <input type="text" name="merk" value="{{ $motor->merk }}" class="form-control mb-2">

      <select name="jenis_id" class="form-control mb-2">
        @foreach($jenisMotor as $j)
          <option value="{{ $j->id }}" {{ $motor->jenis_id == $j->id ? 'selected' : '' }}>
            {{ $j->nama_jenis }}
          </option>
        @endforeach
      </select>

      <input type="number" name="harga_cash" value="{{ $motor->harga_cash }}" class="form-control mb-2">
      <input type="number" name="harga_jual" value="{{ $motor->harga_jual }}" class="form-control mb-2">
      <input type="text" name="warna" value="{{ $motor->warna }}" class="form-control mb-2">
      <input type="text" name="tahun_produksi" value="{{ $motor->tahun_produksi }}" class="form-control mb-2">
      <input type="number" name="stok" value="{{ $motor->stok }}" class="form-control mb-2">

      <input type="file" name="foto1" class="form-control mb-2">

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection