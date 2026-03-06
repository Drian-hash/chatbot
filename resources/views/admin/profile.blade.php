@extends('admin.dashboard')

@section('admin')
<div class="page-wrapper">
    <div class="container-fluid pt-3">

        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body py-3">
                        <h4 class="mb-0 fw-bold">My Profile</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="row g-4">

            <!-- LEFT SIDE - FOTO -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-4">

                        <img src="{{ $admin->foto
                            ? asset('uploads/user/'.$admin->foto)
                            : asset('assets/images/users/profile-pic.jpg') }}"
                            class="rounded-circle border shadow-sm mb-3"
                            width="170" height="170"
                            style="object-fit: cover;">

                        <h5 class="fw-bold mb-1">
                            {{ $admin->name ?? '-' }}
                        </h5>

                        <p class="text-muted mb-2">
                            {{ $admin->email }}
                        </p>

                        <span class="badge bg-primary px-3 py-2">
                            Administrator
                        </span>

                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE - FORM EDIT -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body px-4 py-4">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="fw-semibold mb-1">Nama</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           value="{{ old('name', $admin->name) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-semibold mb-1">Username</label>
                                    <input type="text"
                                           class="form-control bg-light"
                                           value="{{ $admin->username }}"
                                           readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold mb-1">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $admin->email) }}">
                            </div>

                            <div class="mb-4">
                                <label class="fw-semibold mb-1">Foto Profil</label>
                                <input type="file"
                                       name="foto"
                                       class="form-control">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="btn btn-outline-secondary">
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    Update Profil
                                </button>
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
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
});
</script>
@endif
@endpush
