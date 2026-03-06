@extends('admin.dashboard')

@section('admin')
<div class="page-wrapper">
    <div class="container-fluid pt-2">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-2">
                    <div class="card-body py-2 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold">Daftar User</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row mt-1">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-2">

                        <!-- Toolbar: Tambah + Search -->
                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <!-- Tombol Tambah User (kiri) -->
                            <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah User
                            </a>

                            <!-- Search (kanan) -->
                            <form method="GET" action="{{ route('admin.user.index') }}" class="d-flex">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm"
                                    placeholder="Cari nama / username / email..." style="width: 250px;">

                                <button type="submit" class="btn btn-success btn-sm ms-2">
                                    <i class="fas fa-search"></i>
                                </button>

                                @if(request('search'))
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm ms-2">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                @endif
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-2">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th width="50">No</th>
                                        <th width="110">Foto</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th width="120">Status</th>
                                        <th width="160">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </td>

                                            <td class="text-center">
                                                @if($user->foto)
                                                    <img src="{{ asset('uploads/user/'.$user->foto) }}"
                                                        width="50" height="50" class="rounded-circle border">
                                                @else
                                                    <img src="{{ asset('assets/images/users/profile-pic.jpg') }}"
                                                        width="50" height="50" class="rounded-circle border">
                                                @endif
                                            </td>

                                            <td class="fw-semibold">{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>

                                            <!-- Status Online/Offline -->
        /                                    <td class="text-center">
                                                @if(Cache::has('user-is-online-' . $user->id))
                                                    <span class="badge bg-success px-3 py-2">Online</span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">Offline</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('admin.user.show', $user->id) }}"
                                                    class="btn btn-info btn-sm text-white">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm text-white">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.user.destroy', $user->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm btn-delete"
                                                        data-title="{{ $user->name }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Data user belum tersedia
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-2">

                            <!-- Info jumlah data -->
                            <div class="text-muted">
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                            </div>

                            <!-- Tombol Navigasi -->
                            <div class="d-flex align-items-center">

                                {{-- Tombol Sebelumnya --}}
                                @if ($users->onFirstPage())
                                    <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}&search={{ request('search') }}"
                                        class="px-2 text-decoration-none">&#8249;</a>
                                @endif

                                {{-- Nomor Halaman Aktif --}}
                                <span class="px-3 py-1 mx-1 text-white"
                                    style="background-color: #5dd5f9; border-radius: 4px;">
                                    {{ $users->currentPage() }}
                                </span>

                                {{-- Tombol Selanjutnya --}}
                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}&search={{ request('search') }}"
                                        class="px-2 text-decoration-none">&#8250;</a>
                                @else
                                    <span class="px-2 text-muted" style="cursor: default;">&#8250;</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const form = this.closest("form");
            const title = this.getAttribute("data-title");

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: `Data user "${title}" tidak dapat dikembalikan.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif
@endpush
