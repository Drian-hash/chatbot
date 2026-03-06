@extends('admin.dashboard')

@section('admin')

    <style>
        .table {
            font-size: 14px;
        }

        .table th {
            font-weight: 600;
        }

        .table td {
            vertical-align: middle !important;
        }

        .table td:nth-child(3) {
            white-space: normal;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .nilai-select {
            width: 55px;
            height: 30px;
            padding: 2px 4px;
            font-size: 14px;
            text-align: center;
            margin: auto;
        }

        .filter-select {
            width: auto !important;
            min-width: 70px;
            max-width: 90px;
            font-size: 14px;
            font-weight: 500;
            padding: 3px 8px;
        }
    </style>

    <div class="page-wrapper">
        <div class="container-fluid pt-3">

            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-1" style="font-size:18px">
                            Identifikasi - IKASANDI
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

                            <form action="{{ route('admin.ikasandi.identifikasi.import') }}" method="POST"
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

                                            <form action="{{ route('admin.ikasandi.identifikasi.uploadBukti') }}"
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
                                                    <button type="button" class="btn btn-primary btn-sm upload-btn">
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                @endif

                                            </form>

                                        </td>

                                        {{-- TERAKHIR UPDATE --}}
                                        <td class="text-center">
                                            {{ $item->user?->name ?? '-' }} <br>
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

                                            <form action="{{ route('admin.ikasandi.identifikasi.destroy', $item->id) }}"
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
                <form action="{{ route('admin.ikasandi.identifikasi.update', $item->id) }}" method="POST"
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
                            @include('admin.ikasandi.identifikasi._form', [
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
                    <div class="modal-content">

                        <div class="modal-header bg-secondary text-white">
                            <h5 class="modal-title">Preview Bukti</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body p-0" style="height:80vh">
                            @if (in_array($item->bukti_extension, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $item->bukti_url }}" style="width:100%;height:100%;object-fit:contain">
                            @else
                                <iframe src="{{ $item->bukti_url }}" width="100%" height="100%"
                                    style="border:none"></iframe>
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

                /* UPDATE NILAI */
                document.querySelectorAll(".nilai-select").forEach(select => {
                    select.addEventListener("change", function() {

                        let id = this.dataset.id
                        let nilai = this.value

                        fetch("{{ route('admin.ikasandi.identifikasi.updateNilai') }}", {
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
