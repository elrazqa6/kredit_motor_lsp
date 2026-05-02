@extends('layouts.admin')
@section('title', 'Data Motor')
@section('page-title', 'Data Motor')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
  <div>
    <h4>Data Motor</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:var(--primary)">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Motor</li>
      </ol>
    </nav>
  </div>
  <a href="{{ route('admin.motor.create') }}" class="btn btn-primary">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="margin-right:6px;vertical-align:-2px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    Tambah Motor
  </a>
</div>

{{-- Filter Bar --}}
<div class="card mb-4">
  <div class="card-body py-3">
    <form method="GET" class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Cari nama motor, merk..." value="{{ request('search') }}">
      </div>
      <div class="col-md-3">
        <select name="jenis" class="form-select">
          <option value="">Semua Jenis</option>
          @foreach($jenisMotor ?? [] as $j)
            <option value="{{ $j->id }}" {{ request('jenis') == $j->id ? 'selected' : '' }}>{{ $j->nama_jenis }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
     
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.motor.index') }}" class="btn btn-outline-secondary ms-1">Reset</a>
      </div>
    </form>
  </div>
</div>

{{-- Table --}}
<div class="card fade-up">
  <div class="card-header">
    <h6>Daftar Motor ({{ $motors->total() ?? 0 }} unit)</h6>
    <div style="display:flex;gap:8px">
      <button class="btn btn-sm btn-outline-secondary">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Export
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-wrapper">
      <table class="table">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Motor</th>
            <th>Jenis</th>
            <th>Harga Cash</th>
            <th>Harga Jual</th>
            <th>Warna</th>
            <th>Stok</th>
            <th>Status</th>
            <th style="text-align:right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($motors ?? [] as $i => $motor)
          <tr>
            <td style="color:var(--gray-500)">{{ $motors->firstItem() + $i }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                @if($motor->foto1)
                  <img src="{{ asset('storage/'.$motor->foto1) }}" style="width:42px;height:42px;object-fit:cover;border-radius:8px;border:1px solid var(--gray-200)" alt="">
                @else
                  <div style="width:42px;height:42px;border-radius:8px;background:var(--gray-100);display:flex;align-items:center;justify-content:center">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--gray-400)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                  </div>
                @endif
                <div>
                  <div style="font-weight:600;font-size:13px">{{ $motor->nama_motor }}</div>
                  <div style="font-size:11px;color:var(--gray-500)">{{ $motor->merk }} · {{ $motor->tahun_produksi }}</div>
                </div>
              </div>
            </td>
          <td>
  <span class="status-badge badge-info">
    {{ $motor->jenisMotor->nama_jenis ?? '-' }}
  </span>
</td>
            <td>Rp {{ number_format($motor->harga_cash, 0, ',', '.') }}</td>
            <td style="font-weight:600">Rp {{ number_format($motor->harga_jual, 0, ',', '.') }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:6px">
                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ strtolower($motor->warna ?? 'gray') === 'merah' ? '#ef4444' : (strtolower($motor->warna ?? '') === 'biru' ? '#3b82f6' : '#6b7280') }};border:1px solid var(--gray-200)"></span>
                {{ $motor->warna ?? '-' }}
              </div>
            </td>
            <td>
              <span class="status-badge {{ $motor->stok > 5 ? 'badge-success' : ($motor->stok > 0 ? 'badge-warning' : 'badge-danger') }}">
                {{ $motor->stok }} unit
              </span>
            </td>
            <td>
              <span class="status-badge {{ $motor->stok > 0 ? 'badge-success' : 'badge-danger' }}">
                {{ $motor->stok > 0 ? 'Tersedia' : 'Habis' }}
              </span>
            </td>
            <td>
              <div style="display:flex;justify-content:flex-end;gap:6px">
                
                <a href="{{ route('admin.motor.edit', $motor->id) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form action="{{ route('admin.motor.destroy', $motor->id) }}" method="POST" onsubmit="return confirm('Hapus motor ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9">
              <div style="text-align:center;padding:48px;color:var(--gray-500)">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--gray-300)" stroke-width="1.5" style="margin:0 auto 12px;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 8h4l4 4v4h-8V8z"/></svg>
                <div style="font-weight:600;margin-bottom:4px">Belum ada data motor</div>
                <div style="font-size:12px">Klik "Tambah Motor" untuk menambahkan data baru</div>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(isset($motors) && $motors->hasPages())
    <div style="padding:14px 16px;border-top:1px solid var(--gray-200)">
      {{ $motors->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
  </div>
</div>
@endsection
