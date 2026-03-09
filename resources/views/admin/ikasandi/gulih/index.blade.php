@extends('admin.dashboard')

@section('admin')

    <style>
        /* ==============================
        TABLE
        ============================== */

        .table {
            font-size: 13px;
            min-width: 950px;
            /* penting agar bisa scroll horizontal */
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

        /* kolom pertanyaan boleh wrap */
        .table td:nth-child(3) {
            white-space: normal;
        }


        /* ==============================
        RESPONSIVE TABLE
        ============================== */

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }


        /* ==============================
        SELECT NILAI
        ============================== */

        .nilai-select {
            width: 50px;
            height: 28px;
            padding: 2px 4px;
            font-size: 13px;
            text-align: center;
            margin: auto;
        }


        /* ==============================
        FILTER
        ============================== */

        .filter-select {
            width: auto !important;
            min-width: 65px;
            max-width: 85px;
            font-size: 13px;
            font-weight: 500;
            padding: 2px 6px;
        }


        /* ==============================
        INPUT SEARCH
        ============================== */

        .form-control-sm {
            font-size: 13px;
            height: 30px;
        }


        /* ==============================
        BUTTON
        ============================== */

        .btn-sm {
            padding: 3px 7px;
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
        TOOLBAR
        ============================== */

        .card-body {
            padding: 18px 20px;
        }


        /* ==============================
        INFO KATEGORI
        ============================== */

        .kategori-info {
            display: inline-block;
            background: #f1f3f5;
            padding: 5px 12px;
            font-weight: 600;
            border-left: 4px solid #5dd5f9;
            border-radius: 4px;
            font-size: 13px;
        }


        /* ==============================
        MOBILE
        ============================== */

        @media (max-width:768px) {

            .table {
                min-width: 800px;
                /* tetap lebar agar bisa scroll */
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

            .nilai-select {
                width: 45px;
                height: 26px;
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
                            Gulih - IKASANDI
                        </h5>
                        <hr class="mt-2 mb-0">
                    </div>

                    {{-- TOOLBAR --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <form method="GET" class="d-flex">
                            <select name="kategori" onchange="this.form.submit()"
                                class="form-control form-control-sm filter-select mr-2">

                                @foreach ($kategoriList as $k)
                                    <option value="{{ $k->kode_kategori }}"
                                        {{ $kodeKategori == $k->kode_kategori ? 'selected' : '' }}>
                                        {{ $k->kode_kategori }}
                                    </option>
                                @endforeach

                            </select>
                        </form>

                        <div class="d-flex align-items-center">

                            <form action="{{ route('admin.ikasandi.gulih.import') }}" method="POST"
                                enctype="multipart/form-data" id="importForm" class="mr-3">

                                @csrf
                                <input type="file" name="file_excel" id="importFile" accept=".xlsx,.xls" hidden>

                                <button type="button" class="btn btn-success btn-sm"
                                    onclick="document.getElementById('importFile').click()">
                                    <i class="fas fa-file-excel"></i> Import
                                </button>

                            </form>

                            <form method="GET" class="d-flex">
                                <input type="hidden" name="kategori" value="{{ $kodeKategori }}">

                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    class="form-control form-control-sm mr-2" placeholder="Cari..." style="width:200px">

                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>

                        </div>
                    </div>

                    {{-- INFO KATEGORI --}}
                    <div class="mb-2">
                        <div
                            style="
                        display:inline-block;
                        background:#f1f3f5;
                        padding:6px 14px;
                        font-weight:600;
                        border-left:4px solid #5dd5f9;
                        border-radius:4px;
                        font-size:14px">
                            Kategori {{ $kategori->kode_kategori ?? '-' }} -
                            {{ $kategori->keterangan ?? '-' }}
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">

                            <thead class="bg-light text-center">
                                <tr>
                                    <th width="50">No</th>
                                    <th width="120">Kode Soal</th>
                                    <th>Pertanyaan</th>
                                    <th width="80">Nilai</th>
                                    <th width="120">Bukti</th>
                                    <th width="170">Terakhir Update</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($soal as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_soal }}</td>
                                        <td>{{ $item->pertanyaan }}</td>

                                        {{-- NILAI --}}
                                        <td class="text-center">
                                            <select class="form-control nilai-select" data-id="{{ $item->id }}">
                                                @for ($i = 0; $i <= 5; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $item->nilai == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>

                                        {{-- BUKTI --}}
                                        <td class="text-center">

                                            <form action="{{ route('admin.ikasandi.gulih.uploadBukti') }}"
                                                method="POST" enctype="multipart/form-data" class="upload-form">

                                                @csrf

                                                <input type="hidden" name="id" value="{{ $item->id }}">

                                                <input type="file" name="bukti_dukung" class="d-none upload-input">

                                                @if ($item->bukti_url)
                                                    <button type="button" class="btn btn-info btn-sm mr-1"
                                                        data-toggle="modal" data-target="#modalPreview{{ $item->id }}">
                                                        <i class="fas fa-file-alt"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-success btn-sm upload-btn">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-sm upload-btn">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                @endif

                                            </form>

                                        </td>

                                        {{-- TERAKHIR UPDATE --}}
                                        <td class="text-center">

                                            @if ($item->updated_type == 'admin')
                                                {{ $item->admin?->name ?? '-' }}
                                            @else
                                                {{ $item->user?->name ?? '-' }}
                                            @endif

                                            <br>

                                            <small class="text-muted">
                                                {{ $item->updated_at?->format('d-m-Y H:i') }}
                                            </small>

                                        </td>

                                        {{-- AKSI --}}
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm text-white" data-toggle="modal"
                                                data-target="#modalEdit{{ $item->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form action="{{ route('admin.ikasandi.gulih.destroy', $item->id) }}"
                                                method="POST" class="d-inline delete-form"
                                                data-title="{{ $item->kode_soal }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
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

                </div>
            </div>

        </div>
    </div>

    {{-- MODAL EDIT --}}
    @foreach ($soal as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('admin.ikasandi.gulih.update', $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">

                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title">Edit Soal</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            @include('admin.ikasandi.gulih._form', [
                                'edit' => true,
                                'item' => $item,
                            ])
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning text-white">
                                Update
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endforeach

    {{-- MODAL PREVIEW --}}
    @foreach ($soal as $item)
        @if ($item->bukti_url)
            <div class="modal fade" id="modalPreview{{ $item->id }}">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content shadow">

                        <div class="modal-header bg-dark text-white">

                            <h5 class="modal-title">
                                <i class="fas fa-file-alt mr-2"></i>
                                Bukti Dukung
                            </h5>

                            <div class="ml-auto d-flex align-items-center">

                                {{-- DOWNLOAD --}}
                                <a href="{{ $item->bukti_url }}" download class="btn btn-success btn-sm mr-2"
                                    data-toggle="tooltip" title="Unduh Bukti">

                                    <i class="fas fa-download"></i>
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('admin.ikasandi.gulih.hapusbukti', $item->id) }}"
                                    method="POST" class="delete-bukti-form d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-danger btn-sm btn-hapus-bukti"
                                        data-toggle="tooltip" title="Hapus Bukti">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                                <button type="button" class="close text-white ml-3" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>

                            </div>

                        </div>

                        <div class="modal-body p-0" style="height:80vh;background:#f8f9fa">

                            @if (in_array($item->bukti_extension, ['jpg', 'jpeg', 'png']))
                                <div class="d-flex justify-content-center align-items-center h-100">

                                    <img src="{{ $item->bukti_url }}"
                                        style="max-width:100%;max-height:100%;object-fit:contain">

                                </div>
                            @else
                                <iframe src="{{ $item->bukti_url }}" width="100%" height="100%" style="border:none">
                                </iframe>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                /* UPDATE NILAI DENGAN KONFIRMASI */
                document.querySelectorAll(".nilai-select").forEach(select => {

                    select.addEventListener("change", function() {

                        let id = this.dataset.id
                        let nilai = this.value
                        let selectElement = this
                        let oldValue = this.getAttribute("data-old") ?? this.value

                        Swal.fire({
                            title: "Ubah Nilai?",
                            text: "Nilai akan diperbarui di sistem.",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#6c757d",
                            confirmButtonText: "Ya, ubah",
                            cancelButtonText: "Batal"
                        }).then((result) => {

                            if (result.isConfirmed) {

                                fetch("{{ route('admin.ikasandi.gulih.updateNilai') }}", {

                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            id: id,
                                            nilai: nilai
                                        })

                                    })
                                    .then(res => res.json())
                                    .then(data => {

                                        if (data.success) {

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Berhasil',
                                                text: 'Nilai berhasil diperbarui',
                                                timer: 1500,
                                                showConfirmButton: false
                                            })

                                            setTimeout(() => {
                                                location.reload()
                                            }, 1200)

                                        }

                                    })

                            } else {

                                location.reload()

                            }

                        })

                    })

                })

                /* UPLOAD FILE */
                /* UPLOAD FILE PER ROW */
                document.querySelectorAll(".upload-btn").forEach(btn => {

                    btn.addEventListener("click", function() {

                        let form = this.closest(".upload-form")

                        let input = form.querySelector(".upload-input")

                        input.click()

                    })

                })

                document.querySelectorAll(".upload-input").forEach(input => {

                    input.addEventListener("change", function() {

                        this.closest("form").submit()

                    })

                })

                document.querySelectorAll(".upload-input").forEach(input => {
                    input.addEventListener("change", function() {
                        this.closest("form").submit()
                    })
                })

                /* DELETE */
                document.querySelectorAll(".btn-delete").forEach(button => {
                    button.addEventListener("click", function() {

                        const form = this.closest("form")
                        const title = form.getAttribute("data-title")

                        Swal.fire({
                                title: "Yakin ingin menghapus?",
                                text: `Soal "${title}" akan dihapus.`,
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#6c757d",
                                confirmButtonText: "Ya, hapus!",
                                cancelButtonText: "Batal"
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    form.submit()
                                }
                            })
                    })
                })

                /* AKTIFKAN TOOLTIP */
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })


                /* HAPUS BUKTI */
                document.querySelectorAll(".btn-hapus-bukti").forEach(btn => {

                    btn.addEventListener("click", function() {

                        const form = this.closest("form")

                        Swal.fire({

                            title: "Hapus Bukti?",
                            text: "File bukti akan dihapus dari sistem.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#6c757d",
                            confirmButtonText: "Ya, hapus",
                            cancelButtonText: "Batal"

                        }).then((result) => {

                            if (result.isConfirmed) {
                                form.submit()
                            }

                        })

                    })

                })

                /* IMPORT */
                const importFile = document.getElementById("importFile")

                if (importFile) {
                    importFile.addEventListener("change", function() {
                        if (this.files.length > 0) {

                            Swal.fire({
                                    title: "Import Data?",
                                    text: "File akan diproses dan dimasukkan ke sistem.",
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonText: "Ya, Import",
                                    cancelButtonText: "Batal"
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById("importForm").submit()
                                    }
                                })
                        }
                    })
                }

            })
        </script>

        {{-- SWEETALERT SUCCESS --}}
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

        {{-- SWEETALERT ERROR --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}'
                });
            </script>
        @endif
    @endpush

@endsection
