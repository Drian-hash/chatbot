@extends('admin.dashboard')

@section('admin')

    <style>
        /* ==============================
            RESPONSIVE TABLE
            ============================== */

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* tabel dipaksa lebih lebar dari mobile */
        .table {
            min-width: 950px;
            font-size: 13px;
        }

        /* header */
        .table th {
            vertical-align: middle !important;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 10px;
            white-space: nowrap;
        }

        /* cell */
        .table td {
            vertical-align: middle !important;
            font-size: 13px;
            padding: 6px 8px;
            white-space: nowrap;
        }

        /* kolom yang boleh wrap */
        .table td:nth-child(3) {
            white-space: normal;
            word-break: break-word;
        }

        /* tombol */
        .btn-sm {
            font-size: 12.5px;
            padding: 4px 7px;
        }


        /* ==============================
            TOOLBAR
            ============================== */

        .form-control-sm {
            font-size: 13px;
            height: 30px;
        }


        /* ==============================
            MOBILE
            ============================== */

        @media (max-width:768px) {

            .table {
                min-width: 850px;
                font-size: 12px;
            }

            .table th {
                font-size: 12px;
                padding: 7px;
            }

            .table td {
                font-size: 12px;
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

            @php
                $currentYear = date('Y');
            @endphp

            <!-- SATU CARD UTAMA -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- HEADER -->
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-1" style="font-size:18px;">
                            Data Berita Terklarifikasi
                        </h5>
                        <hr class="mt-2 mb-0">
                    </div>

                    <!-- TOOLBAR -->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3 toolbar">

                        <!-- LEFT -->
                        <div class="d-flex align-items-center flex-wrap mb-2 toolbar">

                            <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalCreate">
                                <i class="fas fa-plus"></i> Tambah Berita
                            </button>

                            <form method="GET" action="{{ route('admin.berita.index') }}"
                                class="d-flex align-items-center">

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
                                    @for ($y = $currentYear; $y >= $currentYear - 2; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>

                                <button type="submit" class="btn btn-sm btn-primary mr-2">
                                    <i class="fas fa-filter"></i>
                                </button>

                                @if (request()->query())
                                    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- RIGHT -->
                        <div class="d-flex align-items-center flex-wrap mb-2 toolbar">

                            <a href="{{ route('admin.berita.export.excel', request()->query()) }}"
                                class="btn btn-success btn-sm mr-3">
                                <i class="fas fa-file-excel"></i> Cetak Laporan
                            </a>

                            <form method="GET" action="{{ route('admin.berita.index') }}" class="d-flex">

                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control form-control-sm mr-2" placeholder="Cari kode / isi..."
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
                                    <th width="120">Kode</th>
                                    <th>Isi Ringkas</th>
                                    <th width="150">Tujuan</th>
                                    <th width="150">Nomor</th>
                                    <th width="100">Bukti</th>
                                    <th width="170">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($berita as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($berita->currentPage() - 1) * $berita->perPage() }}
                                        </td>

                                        <td>{{ $item->kode }}</td>

                                        <td style="white-space: normal; word-break: break-word;">
                                            {{ $item->isi_ringkas }}
                                        </td>

                                        <td>{{ $item->tujuan_surat }}</td>
                                        <td>{{ $item->nomor_surat }}</td>

                                        <td class="text-center">
                                            @if ($item->bukti_surat)
                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#modalPreview{{ $item->id }}">
                                                    <i class="fas fa-file"></i>
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="text-center">

                                            <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#modalShow{{ $item->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-warning btn-sm text-white" data-toggle="modal"
                                                data-target="#modalEdit{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST"
                                                class="d-inline delete-form" data-title="{{ $item->kode }}">
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
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-secondary text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-eye"></i> Detail Berita
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <p><strong>Kode:</strong> {{ $item->kode }}</p>
                                                    <p><strong>Nomor Surat:</strong> {{ $item->nomor_surat }}</p>
                                                    <p><strong>Tujuan:</strong> {{ $item->tujuan_surat }}</p>
                                                    <p><strong>Tanggal Surat:</strong> {{ $item->tanggal_format }}</p>
                                                    <p><strong>Isi Ringkas:</strong><br>{{ $item->isi_ringkas }}</p>
                                                    <p><strong>Keterangan:</strong><br>{{ $item->keterangan ?? '-' }}</p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT MODAL -->
                                    <div class="modal fade" id="modalEdit{{ $item->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('admin.berita.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-edit"></i> Edit Berita
                                                        </h5>
                                                        <button type="button" class="close text-white"
                                                            data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @include('admin.berita._form', ['edit' => true])
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-warning text-white">
                                                            Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    @if ($item->bukti_surat)
                                        <div class="modal fade" id="modalPreview{{ $item->id }}">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">

                                                    <div class="modal-header bg-secondary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-eye"></i> Preview Bukti
                                                        </h5>
                                                        <button type="button" class="close text-white"
                                                            data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body p-0" style="height:80vh;">

                                                        @php
                                                            $ext = pathinfo($item->bukti_surat, PATHINFO_EXTENSION);
                                                        @endphp

                                                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ asset('storage/' . $item->bukti_surat) }}"
                                                                style="width:100%; height:100%; object-fit:contain;">
                                                        @else
                                                            <iframe src="{{ asset('storage/' . $item->bukti_surat) }}"
                                                                width="100%" height="100%" style="border:none;"
                                                                loading="lazy">
                                                            </iframe>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif



                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- CREATE MODAL -->
                        <div class="modal fade" id="modalCreate">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('admin.berita.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-plus-circle"></i> Tambah Berita
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            @include('admin.berita._form')
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
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted">
                            Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }} dari
                            {{ $berita->total() }} permohonan
                        </div>

                        <div class="d-flex align-items-center">
                            @if ($berita->onFirstPage())
                                <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                            @else
                                <a href="{{ $berita->previousPageUrl() }}&jenis_permohonan={{ request('jenis_permohonan') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}&search={{ request('search') }}"
                                    class="px-2 text-decoration-none">&#8249;</a>
                            @endif

                            <span class="px-3 py-1 mx-1 text-white"
                                style="background-color: #5dd5f9; border-radius: 4px;">
                                {{ $berita->currentPage() }}
                            </span>

                            @if ($berita->hasMorePages())
                                <a href="{{ $berita->nextPageUrl() }}&jenis_permohonan={{ request('jenis_permohonan') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}&search={{ request('search') }}"
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

                @if (session('success'))
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
