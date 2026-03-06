@extends('admin.dashboard')

@section('admin')

<style>
    /* ==============================
    RESPONSIVE TABLE TAMBAHAN
    ============================== */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        min-width: 950px;
    }

    .table th,
    .table td {
        vertical-align: middle !important;
        font-size: 13px;
        white-space: nowrap;
    }

    .table td:nth-child(2),
    .table td:nth-child(4),
    .table td:nth-child(6) {
        white-space: normal;
    }

    @media (max-width: 768px) {

        .table {
            min-width: 800px;
        }

        .table th,
        .table td {
            font-size: 12px;
            padding: 8px;
        }

        .btn-sm {
            font-size: 11px;
            padding: 4px 6px;
        }
    }
</style>

<div class="page-wrapper">
<div class="container-fluid pt-3">

    <!-- CARD -->
    <div class="card shadow-sm">
    <div class="card-body">

        <!-- HEADER -->
            <div class="mb-4">
                <h5 class="fw-semibold mb-1" style="font-size:18px;">
                    Kategori - Ikasandi
                </h5>
                <hr class="mt-2 mb-0">
            </div>

        <!-- TOOLBAR -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

            <!-- LEFT: Tambah -->
            <button class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modalCreate">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>

            <!-- RIGHT: Search -->
            <form action="{{ route('admin.ikasandi.kategori.index') }}"
                method="GET"
                class="d-flex align-items-center mt-2 mt-md-0">

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control form-control-sm me-2"
                    placeholder="Cari kategori..."
                    style="max-width:200px;">

                <button type="submit" class="btn btn-secondary btn-sm">
                    <i class="fas fa-search"></i>
                </button>

            </form>

        </div>

        <!-- TABLE -->
        <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="bg-light text-center">
                <tr>
                    <th width="60">No</th>
                    <th width="80">Kode</th>
                    <th>Keterangan</th>
                    <th width="100">Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($kategori as $item)
            <tr>
                <td class="text-center">
                    {{ $loop->iteration + ($kategori->currentPage()-1) * $kategori->perPage() }}
                </td>

                <td>{{ $item->kode_kategori }}</td>

                <td style="white-space: normal;">
                    {{ $item->keterangan }}
                </td>

                <td class="text-center">
                    @if($item->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </td>

                <td class="text-center">

                    <!-- EDIT -->
                    <button class="btn btn-warning btn-sm text-white"
                            data-toggle="modal"
                            data-target="#modalEdit{{ $item->id }}">
                        <i class="fas fa-edit"></i>
                    </button>

                    <!-- DELETE -->
                    <form action="{{ route('admin.ikasandi.kategori.destroy',$item->id) }}"
                          method="POST"
                          class="d-inline delete-form"
                          data-title="{{ $item->kode_kategori }}">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                </td>
            </tr>

            <!-- EDIT MODAL -->
            <div class="modal fade" id="modalEdit{{ $item->id }}">
                <div class="modal-dialog">
                    <form action="{{ route('admin.ikasandi.kategori.update',$item->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-edit"></i> Edit Kategori
                                </h5>
                                <button type="button"
                                        class="close text-white"
                                        data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                @include('admin.ikasandi.kategori._form', ['edit'=>true])
                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="btn btn-warning text-white">
                                    Update
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="5"
                    class="text-center text-muted py-4">
                    Data kategori belum tersedia.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">

            <div class="text-muted">
                Menampilkan {{ $kategori->firstItem() }} - {{ $kategori->lastItem() }} dari {{ $kategori->total() }} permohonan
            </div>

            <div class="d-flex align-items-center">
                @if ($kategori->onFirstPage())
                    <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                @else
                    <a href="{{ $kategori->previousPageUrl() }}&jenis_permohonan={{ request('jenis_permohonan') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}&search={{ request('search') }}"
                    class="px-2 text-decoration-none">&#8249;</a>
                @endif

                <span class="px-3 py-1 mx-1 text-white"
                    style="background-color: #5dd5f9; border-radius: 4px;">
                    {{ $kategori->currentPage() }}
                </span>

                @if ($kategori->hasMorePages())
                    <a href="{{ $kategori->nextPageUrl() }}&jenis_permohonan={{ request('jenis_permohonan') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}&search={{ request('search') }}"
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

<!-- CREATE MODAL -->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog">
        <form action="{{ route('admin.ikasandi.kategori.store') }}"
              method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle"></i> Tambah Kategori
                    </h5>
                    <button type="button"
                            class="close text-white"
                            data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @include('admin.ikasandi.kategori._form')
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit"
                            class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".btn-delete").forEach(button => {

        button.addEventListener("click", function () {

            const form = this.closest("form");
            const title = form.getAttribute("data-title");

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: `Kategori "${title}" akan dihapus.`,
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

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif

});
</script>
@endpush

@endsection
