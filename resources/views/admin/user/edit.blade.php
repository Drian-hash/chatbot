@extends('admin.dashboard')

@section('admin')
<div class="page-wrapper">
    <div class="container-fluid pt-2">

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-2">
                    <div class="card-body py-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 fw-bold">Edit User</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row mt-1">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-4 pb-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="formUserEdit" action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ old('username', $user->username) }}" placeholder="Masukkan username">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" placeholder="Masukkan email">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">No HP</label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ old('no_hp', $user->no_hp) }}" placeholder="Masukkan nomor HP">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Kosongkan jika tidak diganti">
                                        <small class="text-muted">Kosongkan jika password tidak ingin diubah</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="fw-bold">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="fw-bold">Foto</label>
                                <input type="file" name="foto" class="form-control">

                                <div class="mt-3">
                                    <label class="fw-bold d-block mb-2">Foto Saat Ini</label>

                                    @if($user->foto)
                                        <img src="{{ asset('uploads/user/'.$user->foto) }}"
                                            width="90" height="90" class="rounded-circle border">
                                    @else
                                        <img src="{{ asset('assets/images/users/profile-pic.jpg') }}"
                                            width="90" height="90" class="rounded-circle border">
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="button" id="btnUpdate" class="btn btn-primary px-4">
                                    <i class="fas fa-save"></i> Update
                                </button>

                                <a href="{{ route('admin.user.index') }}" class="btn btn-danger px-4">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>

                        </form>

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

    // SweetAlert Konfirmasi Update
    document.getElementById("btnUpdate").addEventListener("click", function () {
        Swal.fire({
            title: "Update Data User?",
            text: "Perubahan akan disimpan ke sistem.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, Update",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("formUserEdit").submit();
            }
        });
    });

    // SweetAlert Error jika validasi gagal
    @if ($errors->any())
        Swal.fire({
            icon: "error",
            title: "Gagal!",
            text: "Data belum lengkap atau ada yang salah. Silakan cek kembali.",
        });
    @endif

});
</script>
@endpush
