@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Pelanggan</h3>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card Wrapper --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start fw-semibold">{{ $d->nama_pelanggan }}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->no_telp }}</td>

                            <td class="text-start">
                                {{ $d->alamat1 ?? '-' }}
                            </td>
                            <td>{{ $d->kota1 ?? '-' }}</td>
                            <td>{{ $d->provinsi1 ?? '-' }}</td>

                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.pelanggan.edit',$d->id) }}" 
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.pelanggan.destroy',$d->id) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Data belum ada
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection