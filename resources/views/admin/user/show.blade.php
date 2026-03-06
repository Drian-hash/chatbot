@extends('admin.dashboard')

@section('admin')
<div class="page-wrapper">
    <div class="container-fluid pt-2">

        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-2">
                    <div class="card-body py-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 fw-bold">Detail User</h3>

                        <a href="{{ route('admin.user.index') }}" class="btn btn-danger px-4">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail -->
        <div class="row mt-1">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-4 pb-4">

                        <div class="row align-items-center">
                            <!-- Foto -->
                            <div class="col-md-4 text-center mb-3">
                                @if($user->foto)
                                    <img src="{{ asset('uploads/user/'.$user->foto) }}"
                                        width="170" height="170"
                                        class="rounded-circle border shadow-sm">
                                @else
                                    <img src="{{ asset('assets/images/users/profile-pic.jpg') }}"
                                        width="170" height="170"
                                        class="rounded-circle border shadow-sm">
                                @endif

                                <h5 class="fw-bold mt-3 mb-0">{{ $user->name }}</h5>
                                <small class="text-muted">{{ $user->username }}</small>
                            </div>

                            <!-- Detail -->
                            <div class="col-md-8">
                                <table class="table table-bordered table-hover align-middle">
                                    <tr>
                                        <th width="220" class="bg-light">Nama</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">Username</th>
                                        <td>{{ $user->username }}</td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">No HP</th>
                                        <td>{{ $user->no_hp ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">Status Online</th>
                                        <td>
                                            @if(Cache::has('user-is-online-' . $user->id))
                                                <span class="badge bg-success px-3 py-2">Online</span>
                                            @else
                                                <span class="badge bg-secondary px-3 py-2">Offline</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">Dibuat</th>
                                        <td>{{ $user->created_at->format('d-m-Y H:i:s') }}</td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">Terakhir Update</th>
                                        <td>{{ $user->updated_at->format('d-m-Y H:i:s') }}</td>
                                    </tr>
                                </table>

                                <div class="mt-3 d-flex gap-2">
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning px-4 text-white">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline" id="deleteForm">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger px-4" id="btnDelete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>

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

    document.getElementById("btnDelete").addEventListener("click", function () {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data user ini akan terhapus permanen dan tidak dapat dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("deleteForm").submit();
            }
        });
    });

});
</script>
@endpush
