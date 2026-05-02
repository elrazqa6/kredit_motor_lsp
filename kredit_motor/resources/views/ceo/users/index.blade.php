@extends('layouts.ceo')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-users me-2 text-primary"></i> Daftar User
        </h5>
        <a href="{{ route('ceo.users.create') }}" class="btn btn-primary rounded-pill">
            <i class="fas fa-plus me-2"></i> Tambah User
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</div>
                        <td>{{ $user->name }}</div>
                        <td>{{ $user->email }}</div>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role == 'marketing')
                                <span class="badge bg-success">Marketing</span>
                            @elseif($user->role == 'ceo')
                                <span class="badge bg-primary">CEO</span>
                            @else
                                <span class="badge bg-secondary">Client</span>
                            @endif
                         </div>
                        <td>{{ $user->created_at->format('d/m/Y') }}</div>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('ceo.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id != auth()->id())
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                     </div>
                    @empty
                     <tr class="text-center py-4">
                        <td colspan="6">Belum ada data user</div>
                     </div>
                    @endforelse
                </tbody>
             </div>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        
        Swal.fire({
            title: 'Hapus User?',
            html: `Apakah Anda yakin ingin menghapus user <strong>${name}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route("ceo.users.index") }}/${id}`;
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