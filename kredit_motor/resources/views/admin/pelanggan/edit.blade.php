@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Edit Pelanggan</h3>

    <form action="{{ route('admin.pelanggan.update',$data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="{{ $data->nama_pelanggan }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $data->email }}">
        </div>

        <div class="mb-3">
            <label>No Telp</label>
            <input type="text" name="no_telp" class="form-control" value="{{ $data->no_telp }}">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection