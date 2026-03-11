@extends('admin.dashboard')

@section('admin')
    <style>
        /* ==============================
                TABLE RESPONSIVE
                ============================== */

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            min-width: 950px;
            font-size: 13px;
        }

        .table th {
            font-weight: 600;
            font-size: 13px;
            padding: 8px 10px;
        }

        .table td {
            vertical-align: middle !important;
            padding: 7px 8px;
        }

        /* kolom panjang boleh wrap */
        .table td:nth-child(2),
        .table td:nth-child(4),
        .table td:nth-child(6) {
            white-space: normal;
        }


        /* ==============================
                TOOLBAR
                ============================== */

        .toolbar {
            gap: 8px;
        }

        .toolbar .form-control-sm {
            height: 30px;
            font-size: 13px;
        }

        .toolbar .btn-sm {
            font-size: 12.5px;
            padding: 4px 8px;
        }


        /* ==============================
                BUTTON
                ============================== */

        .btn-sm {
            padding: 4px 7px;
            font-size: 12.5px;
        }


        /* ==============================
                MODAL
                ============================== */

        .modal-title {
            font-size: 15px;
        }

        .modal-body {
            font-size: 13px;
        }


        /* ==============================
                MOBILE RESPONSIVE
                ============================== */

        @media (max-width:768px) {

            .table {
                min-width: 780px;
                font-size: 12px;
            }

            .table th {
                font-size: 12px;
                padding: 7px;
            }

            .table td {
                padding: 6px;
            }

            .btn-sm {
                font-size: 11px;
                padding: 3px 6px;
            }

            .form-control-sm {
                font-size: 12px;
                height: 28px;
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
                            <i class="fas fa-signature text-primary"></i>
                            Data Permohonan TTE
                        </h5>
                        <hr class="mt-2 mb-0">
                    </div>

                    <!-- TOOLBAR -->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3 toolbar">

                        <!-- LEFT -->
                        <div class="d-flex align-items-center flex-wrap mb-2 toolbar">

                            <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalCreate">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>

                            <!-- FILTER -->
                            <form method="GET" action="{{ route('admin.tte.index') }}"
                                class="d-flex align-items-center flex-wrap">

                                <select name="jenis_permohonan" class="form-control form-control-sm mr-2"
                                    style="width:180px;">
                                    <option value="">Semua Layanan</option>
                                    <option value="Permohonan TTE Baru (Belum Mempunyai TTE)"
                                        {{ request('jenis_permohonan') == 'Permohonan TTE Baru (Belum Mempunyai TTE)' ? 'selected' : '' }}>
                                        TTE Baru
                                    </option>
                                    <option value="Lupa Passphrase TTE"
                                        {{ request('jenis_permohonan') == 'Lupa Passphrase TTE' ? 'selected' : '' }}>
                                        Lupa Passphrase
                                    </option>
                                    <option value="Pembaharuan TTE ( TTE Expired)"
                                        {{ request('jenis_permohonan') == 'Pembaharuan TTE ( TTE Expired)' ? 'selected' : '' }}>
                                        Pembaharuan
                                    </option>
                                </select>

                                <select name="bulan" class="form-control form-control-sm mr-2" style="width:120px;">
                                    <option value="">Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>

                                <select name="tahun" class="form-control form-control-sm mr-2" style="width:100px;">
                                    <option value="">Tahun</option>
                                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>

                                <button type="submit" class="btn btn-sm btn-primary mr-2">
                                    <i class="fas fa-filter"></i>
                                </button>

                                @if (request()->query())
                                    <a href="{{ route('admin.tte.index') }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- RIGHT -->
                        <div class="d-flex align-items-center flex-wrap mb-2 toolbar">
                            <a href="{{ route('admin.tte.print', request()->query()) }}"
                                class="btn btn-success btn-sm mr-3">
                                <i class="fas fa-file-excel"></i> Cetak Laporan
                            </a>

                            <form method="GET" action="{{ route('admin.tte.index') }}" class="d-flex">

                                <input type="hidden" name="jenis_permohonan" value="{{ request('jenis_permohonan') }}">
                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm mr-2" placeholder="Cari nama / NIP..."
                                    style="width:200px;">

                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama</th>
                                    <th width="150">NIP</th>
                                    <th>OPD</th>
                                    <th width="140">No HP</th>
                                    <th width="260">Jenis Permohonan</th>
                                    <th width="170">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($tte as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($tte->currentPage() - 1) * $tte->perPage() }}
                                        </td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td>{{ $item->nip ?? '-' }}</td>
                                        <td>{{ $item->opd ?? '-' }}</td>
                                        <td>{{ $item->no_hp ?? '-' }}</td>
                                        <td>{{ $item->jenis_permohonan }}</td>

                                        <td class="text-center">

                                            <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#modalShow{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-warning btn-sm text-white" data-toggle="modal"
                                                data-target="#modalEdit{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form action="{{ route('admin.tte.destroy', $item->id) }}" method="POST"
                                                class="d-inline delete-form" data-title="{{ $item->nama_lengkap }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>

                                    </tr>

                                    <!-- SHOW MODAL -->
                                    <div class="modal fade" id="modalShow{{ $item->id }}">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content shadow">
                                                <div class="modal-header bg-secondary text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-eye"></i> Detail Permohonan
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Nama:</strong> {{ $item->nama_lengkap }} <br>
                                                    <strong>NIP:</strong> {{ $item->nip ?? '-' }} <br>
                                                    <strong>OPD:</strong> {{ $item->opd ?? '-' }} <br>
                                                    <strong>No HP:</strong> {{ $item->no_hp ?? '-' }} <br>
                                                    <strong>Jenis:</strong> {{ $item->jenis_permohonan }} <br>
                                                    <strong>Dibuat:</strong> {{ $item->created_at->format('d M Y H:i') }}
                                                    <br>
                                                    <strong>Update:</strong> {{ $item->updated_at->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT MODAL -->
                                    <div class="modal fade" id="modalEdit{{ $item->id }}">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <form action="{{ route('admin.tte.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content shadow">
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title">Edit Permohonan</h5>
                                                        <button type="button" class="close text-white"
                                                            data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @include('admin.tte._form', ['edit' => true])
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted">
                            Menampilkan {{ $tte->firstItem() }} - {{ $tte->lastItem() }} dari {{ $tte->total() }}
                            permohonan
                        </div>

                        <div class="d-flex align-items-center">
                            @if ($tte->onFirstPage())
                                <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                            @else
                                <a href="{{ $tte->previousPageUrl() }}&jenis_permohonan={{ request('jenis_permohonan') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}&search={{ request('search') }}"
                                    class="px-2 text-decoration-none">&#8249;</a>
                            @endif

                            <span class="px-3 py-1 mx-1 text-white"
                                style="background-color: #5dd5f9; border-radius: 4px;">
                                {{ $tte->currentPage() }}
                            </span>

                            @if ($tte->hasMorePages())
                                <a href="{{ $tte->nextPageUrl() }}&jenis_permohonan={{ request('jenis_permohonan') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}&search={{ request('search') }}"
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

    <!-- CREATE MODAL (DIBESARKAN SEPERTI EDIT) -->
    <div class="modal fade" id="modalCreate">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('admin.tte.store') }}" method="POST">
                @csrf
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Permohonan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('admin.tte._form')
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- SWEETALERT TIDAK DIUBAH -->
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.querySelectorAll(".btn-delete").forEach(button => {

                    button.addEventListener("click", function() {

                        const form = this.closest("form");
                        const title = form.getAttribute("data-title");

                        Swal.fire({
                            title: "Yakin ingin menghapus?",
                            text: `Data "${title}" akan dihapus permanen.`,
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
    @endpush
@endsection
