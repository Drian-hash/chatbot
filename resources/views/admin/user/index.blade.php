@extends('admin.dashboard')

@section('admin')
    <style>
        /* TABLE */
        .table {
            font-size: 13px;
        }

        .table th {
            font-weight: 600;
            font-size: 13px;
            padding: 8px 10px;
        }

        .table td {
            vertical-align: middle !important;
            padding: 6px 8px;
        }

        /* RESPONSIVE TABLE */
        .table-responsive {
            overflow-x: auto;
        }

        /* BUTTON */
        .btn-sm {
            padding: 3px 7px;
            font-size: 12.5px;
        }

        /* INPUT */
        .form-control-sm {
            font-size: 13px;
            height: 30px;
        }

        /* TOOLBAR */
        .card-body {
            padding: 18px 20px;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {

            .table {
                font-size: 12.5px;
            }

            .table th {
                font-size: 12px;
                padding: 6px;
            }

            .table td {
                padding: 5px;
            }

            .btn-sm {
                padding: 3px 6px;
                font-size: 12px;
            }

        }
    </style>


    <div class="page-wrapper">
        <div class="container-fluid pt-3">


            <div class="card shadow-sm">
                <div class="card-body">


                    {{-- HEADER --}}
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-1" style="font-size:18px">
                            Daftar User
                        </h5>
                        <hr class="mt-2 mb-0">
                    </div>


                    {{-- TOOLBAR --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                        {{-- LEFT --}}
                        <div class="d-flex align-items-center mb-2">

                            <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalCreate">

                                <i class="fas fa-plus"></i> Tambah User

                            </button>

                        </div>


                        {{-- RIGHT --}}
                        <form method="GET" action="{{ route('admin.user.index') }}" class="d-flex mb-2">

                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm mr-2" placeholder="Cari nama / username / email..."
                                style="width:220px">

                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>

                            @if (request('search'))
                                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm ml-2">

                                    <i class="fas fa-sync"></i>

                                </a>
                            @endif

                        </form>

                    </div>



                    {{-- TABLE --}}
                    <div class="table-responsive">

                        <table class="table table-bordered align-middle">

                            <thead class="bg-light text-center">

                                <tr>
                                    <th width="50">No</th>
                                    <th width="100">Foto</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th width="120">Status</th>
                                    <th width="120">Aksi</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($users as $user)
                                    <tr>

                                        <td class="text-center">

                                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}

                                        </td>


                                        <td class="text-center">

                                            @if ($user->foto)
                                                <img src="{{ asset('uploads/user/' . $user->foto) }}" width="45"
                                                    height="45" class="rounded-circle border">
                                            @else
                                                <img src="{{ asset('assets/images/users/profile-pic.jpg') }}" width="45"
                                                    height="45" class="rounded-circle border">
                                            @endif

                                        </td>


                                        <td class="fw-semibold">{{ $user->name }}</td>

                                        <td>{{ $user->username }}</td>

                                        <td>{{ $user->email }}</td>


                                        <td class="text-center">

                                            @if (Cache::has('user-is-online-' . $user->id))
                                                <span class="badge badge-success px-3 py-2">
                                                    Online
                                                </span>
                                            @else
                                                <span class="badge badge-secondary px-3 py-2">
                                                    Offline
                                                </span>
                                            @endif

                                        </td>


                                        <td class="text-center">

                                            {{-- SHOW --}}
                                            {{-- <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#modalShow{{ $user->id }}">

                                                <i class="fas fa-eye"></i>

                                            </button> --}}


                                            {{-- EDIT --}}
                                            <button class="btn btn-warning btn-sm text-white" data-toggle="modal"
                                                data-target="#modalEdit{{ $user->id }}">

                                                <i class="fas fa-edit"></i>

                                            </button>


                                            {{-- DELETE --}}
                                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                                class="d-inline delete-form" data-title="{{ $user->name }}">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm btn-delete">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </td>

                                    </tr>


                                    {{-- SHOW MODAL --}}
                                    <div class="modal fade" id="modalShow{{ $user->id }}">

                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">

                                                <div class="modal-header bg-secondary text-white">

                                                    <h5 class="modal-title">
                                                        Detail User
                                                    </h5>

                                                    <button type="button" class="close text-white" data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>


                                                <div class="modal-body">

                                                    <p><strong>Nama :</strong> {{ $user->name }}</p>

                                                    <p><strong>Username :</strong> {{ $user->username }}</p>

                                                    <p><strong>Email :</strong> {{ $user->email }}</p>

                                                    <p><strong>No HP :</strong> {{ $user->no_hp ?? '-' }}</p>

                                                </div>


                                                <div class="modal-footer">

                                                    <button class="btn btn-secondary" data-dismiss="modal">

                                                        Tutup

                                                    </button>

                                                </div>

                                            </div>
                                        </div>
                                    </div>



                                    {{-- EDIT MODAL --}}
                                    <div class="modal fade" id="modalEdit{{ $user->id }}">

                                        <div class="modal-dialog modal-lg">

                                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST"
                                                enctype="multipart/form-data">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-content">

                                                    <div class="modal-header bg-warning text-white">

                                                        <h5 class="modal-title">

                                                            Edit User

                                                        </h5>

                                                        <button type="button" class="close text-white"
                                                            data-dismiss="modal">

                                                            <span>&times;</span>

                                                        </button>

                                                    </div>


                                                    <div class="modal-body">

                                                        @include('admin.user._form', [
                                                            'edit' => true,
                                                            'user' => $user,
                                                        ])

                                                    </div>


                                                    <div class="modal-footer">

                                                        <button class="btn btn-secondary" data-dismiss="modal">

                                                            Batal

                                                        </button>

                                                        <button class="btn btn-warning text-white">

                                                            Update

                                                        </button>

                                                    </div>

                                                </div>

                                            </form>

                                        </div>
                                    </div>



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



                    {{-- PAGINATION --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted">

                            Menampilkan
                            {{ $users->firstItem() }}
                            -
                            {{ $users->lastItem() }}
                            dari
                            {{ $users->total() }} user

                        </div>


                        <div class="d-flex align-items-center">

                            @if ($users->onFirstPage())
                                <span class="px-2 text-muted">&#8249;</span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}&search={{ request('search') }}"
                                    class="px-2 text-decoration-none">

                                    &#8249;

                                </a>
                            @endif


                            <span class="px-3 py-1 mx-1 text-white" style="background:#5dd5f9;border-radius:4px">

                                {{ $users->currentPage() }}

                            </span>


                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}&search={{ request('search') }}"
                                    class="px-2 text-decoration-none">

                                    &#8250;

                                </a>
                            @else
                                <span class="px-2 text-muted">&#8250;</span>
                            @endif

                        </div>

                    </div>



                </div>
            </div>



        </div>
    </div>


    {{-- CREATE MODAL --}}
    <div class="modal fade" id="modalCreate">

        <div class="modal-dialog modal-lg">

            <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">

                            Tambah User

                        </h5>

                        <button type="button" class="close text-white" data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>


                    <div class="modal-body">

                        @include('admin.user._form')

                    </div>


                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-dismiss="modal">

                            Batal

                        </button>

                        <button class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const deleteButtons = document.querySelectorAll(".btn-delete");

                deleteButtons.forEach(button => {
                    button.addEventListener("click", function(e) {
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
@endsection
