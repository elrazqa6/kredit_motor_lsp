@extends('layouts.admin')

@section('title', 'Manajemen Banner Hero')
@section('page-title', 'Manajemen Banner Hero')

@push('styles')
<style>
    .hero-card {
        transition: all 0.2s ease;
    }
    .hero-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    .hero-preview {
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        width: 100%;
    }
    .status-badge {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-active {
        background: #d1fae5;
        color: #059669;
    }
    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }
</style>
@endpush

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-images me-2 text-primary"></i> Banner Hero
            </h5>
            <a href="{{ route('admin.hero.create') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-plus me-2"></i> Tambah Banner
            </a>
        </div>
        <p class="text-muted mb-0 mt-2 small">
            Kelola banner yang tampil di halaman utama client. Banner dengan urutan terkecil akan tampil pertama.
        </p>
    </div>
    <div class="card-body p-4">
        @if($hero->count() > 0)
            <div class="row g-4">
                @foreach($hero as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card border hero-card h-100">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" class="hero-preview" alt="Hero Banner">
                        @else
                            <div class="hero-preview bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0">{{ $item->judul ?? 'Tanpa Judul' }}</h6>
                                <span class="status-badge {{ $item->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas {{ $item->is_active ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            @if($item->sub_judul)
                                <p class="small text-muted mb-2">{{ Str::limit($item->sub_judul, 60) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-sort-numeric-down me-1"></i> Urutan: {{ $item->urutan ?? 0 }}
                                    </span>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('admin.hero.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.hero.toggle', $item->id) }}" class="btn btn-sm btn-outline-{{ $item->is_active ? 'secondary' : 'success' }}" title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $item->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->judul ?? 'Banner' }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h5 class="fw-semibold">Belum Ada Banner Hero</h5>
                <p class="text-muted">Klik tombol "Tambah Banner" untuk menambahkan banner hero.</p>
                <a href="{{ route('admin.hero.create') }}" class="btn btn-primary rounded-pill mt-2">
                    <i class="fas fa-plus me-2"></i> Tambah Banner
                </a>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        
        Swal.fire({
            title: 'Hapus Banner?',
            html: `Apakah Anda yakin ingin menghapus banner <strong>${name}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route("admin.hero.index") }}/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>
@endsection