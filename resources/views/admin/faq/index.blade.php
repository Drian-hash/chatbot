@extends('admin.dashboard')

@section('title', 'Data FAQ')

@section('admin')

    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">

            {{-- JUDUL UTAMA --}}
            <div class="page-heading mb-3">
                <div class="page-heading-copy">
                    <div>
                        <h3 class="h3 mb-1 text-dark fw-bold" style="color: #0f5132 !important;">Data FAQ</h3>
                        <p class="text-muted mb-0">
                            Kelola basis data FAQ sistem cerdas layanan publik Dinas Komunikasi dan Informatika.
                        </p>
                    </div>
                </div>
            </div>

            <section class="panel">

                {{-- PANEL ACTION BAR: SEJAJAR DI BAWAH TULISAN JUDUL (SINKRON DENGAN SCREENSHOT) --}}
                <div class="panel-header mb-3">
                    <div class="w-100 d-flex justify-content-between align-items-center flex-wrap gap-2 m-0">

                        {{-- SISI KIRI: CONFIG SHOW ENTRIES & TOMBOL IMPORT MINI --}}
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            {{-- Show Entries --}}
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">Show</span>
                                <form action="{{ route('admin.faq.index') }}" method="GET" class="m-0">
                                    <select name="per_page" class="form-select text-center"
                                        style="width: 70px; height: 38px; font-size: 13.5px; border-radius: 8px;"
                                        onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                </form>
                                <span class="text-muted small">entries</span>
                            </div>



                            {{-- Reset Button --}}
                            @if (request('search'))
                                <a href="{{ route('admin.faq.index') }}"
                                    class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center"
                                    style="height: 38px; border-radius: 8px; padding: 0 12px;">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            @endif
                        </div>

                        {{-- SISI KANAN: SEARCH BOX & TOMBOL TAMBAH DATA DATA --}}
                        <div class="d-flex align-items-center gap-2">

                            {{-- MULTI-FORMAT IMPORT BUTTON (EXCEL / CSV / PDF) --}}
                            <form id="formImport" action="{{ route('admin.faq.import') }}" method="POST"
                                enctype="multipart/form-data" class="m-0">
                                @csrf
                                <input type="file" name="file" id="fileInput" accept=".xlsx, .xls, .csv, .pdf" hidden>
                                <button type="button"
                                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1.5"
                                    style="height: 38px; border-radius: 8px; padding: 0 14px; font-size: 13px;"
                                    onclick="document.getElementById('fileInput').click()">
                                    <i class="bi bi-upload"></i> Import FAQ
                                </button>
                            </form>
                            {{-- Search Box --}}
                            <form action="{{ route('admin.faq.index') }}" method="GET" class="m-0">
                                <div class="search-box">
                                    <input type="text" name="search" placeholder="Cari pertanyaan FAQ..."
                                        value="{{ request('search') }}">
                                    @if (request('per_page'))
                                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                    @endif
                                    <button type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- Tambah Data Baru --}}
                            <button type="button" class="btn-create" style="height: 38px; border-radius: 8px;"
                                onclick="createData()">
                                <i class="bi bi-plus-lg"></i> Tambah FAQ
                            </button>
                        </div>

                    </div>
                </div>

                {{-- DATA TABLE CONTAINER --}}
                <div class="table-responsive rounded-3 border">
                    <table class="table align-middle mb-0">
                        <thead style="background: linear-gradient(90deg, #0b3d2e 0%, #146c43 100%);">
                            <tr>
                                <th width="60" class="text-white py-3 ps-3"
                                    style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">No</th>
                                <th class="text-white py-3"
                                    style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Layanan</th>
                                <th class="text-white py-3"
                                    style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Pertanyaan</th>
                                <th class="text-white py-3"
                                    style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Jawaban</th>
                                <th width="100" class="text-white py-3"
                                    style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Hits</th>
                                <th width="140" class="text-white py-3 text-end pe-3"
                                    style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($faq as $item)
                                <tr class="border-bottom">
                                    <td class="ps-3 text-secondary" style="font-size: 13.5px;">
                                        {{ ($faq->currentPage() - 1) * $faq->perPage() + $loop->iteration }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #1e293b !important; font-weight: 500;">
                                        {{ $item->layanan->nama_layanan ?? '-' }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #1e293b !important;">
                                        {{ $item->pertanyaan }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #475569 !important;">
                                        {{ Str::limit($item->jawaban, 75) }}
                                    </td>
                                    <td style="font-size: 13.5px;">
                                        <span class="badge bg-light text-dark border px-2 py-1"
                                            style="border-radius: 4px;">{{ $item->jumlah_ditanya ?? 0 }}x</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="action-buttons">
                                            {{-- VIEW --}}
                                            <button type="button" class="btn btn-outline-info btn-sm btn-view"
                                                data-layanan="{{ $item->layanan->nama_layanan ?? '-' }}"
                                                data-pertanyaan="{{ $item->pertanyaan }}"
                                                data-jawaban="{{ $item->jawaban }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            {{-- EDIT --}}
                                            <button type="button" class="btn btn-outline-warning btn-sm btn-edit"
                                                data-id="{{ $item->id }}" data-layanan="{{ $item->layanan_id }}"
                                                data-pertanyaan="{{ $item->pertanyaan }}"
                                                data-jawaban="{{ $item->jawaban }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('admin.faq.destroy', $item->id) }}" method="POST"
                                                class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete"
                                                    data-title="{{ Str::limit($item->pertanyaan, 30) }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted" style="font-size: 13.5px;">
                                        Belum ada data FAQ terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION FOOTER --}}
                <div class="d-flex justify-content-between align-items-center mt-3 p-3">
                    <div class="text-muted" style="font-size: 13px;">
                        Menampilkan {{ $faq->firstItem() ?? 0 }} - {{ $faq->lastItem() ?? 0 }} dari {{ $faq->total() }}
                        data FAQ
                    </div>

                    <div class="d-flex align-items-center">
                        @if ($faq->onFirstPage())
                            <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                        @else
                            <a href="{{ $faq->previousPageUrl() }}&search={{ request('search') }}&per_page={{ request('per_page') }}"
                                class="px-2 text-decoration-none">&#8249;</a>
                        @endif

                        <span class="px-3 py-1 mx-1 text-white"
                            style="background-color: #146c43; border-radius: 4px; font-size: 13px;">
                            {{ $faq->currentPage() }}
                        </span>

                        @if ($faq->hasMorePages())
                            <a href="{{ $faq->nextPageUrl() }}&search={{ request('search') }}&per_page={{ request('per_page') }}"
                                class="px-2 text-decoration-none">&#8250;</a>
                        @endif
                    </div>
                </div>

            </section>
        </div>
    </main>

    {{-- MODAL FAQ: TAMBAH & EDIT --}}
    <div class="modal fade" id="modalFaq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <form id="formFaq" action="{{ route('admin.faq.store') }}" method="POST">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="modal-header custom-header" style="background-color: #146c43;">
                        <h5 class="modal-title" id="modalTitle">Tambah FAQ</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Layanan <span class="text-danger">*</span></label>
                            <select name="layanan_id" id="layanan_id" class="form-select" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($layanan as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea name="pertanyaan" id="pertanyaan" rows="3" class="form-control"
                                placeholder="Masukkan pertanyaan FAQ" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jawaban <span class="text-danger">*</span></label>
                            <textarea name="jawaban" id="jawaban" rows="5" class="form-control" placeholder="Masukkan jawaban resmi..."
                                required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save" style="background-color: #146c43;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL VIEW DETAIL FAQ --}}
    <div class="modal fade" id="modalViewFaq" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-header" style="background-color: #0b3d2e;">
                    <h5 class="modal-title">Detail Berkas FAQ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Kategori Layanan</label>
                        <div id="viewLayanan" class="p-2.5 border rounded bg-light text-dark font-weight-medium"
                            style="font-size: 13.5px;"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Pertanyaan</label>
                        <div id="viewPertanyaan" class="p-2.5 border rounded bg-light text-dark"
                            style="font-size: 13.5px; white-space: pre-wrap;"></div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold text-secondary">Jawaban Konten NLP</label>
                        <div id="viewJawaban" class="p-2.5 border rounded bg-light text-dark"
                            style="font-size: 13.5px; white-space: pre-wrap;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- STYLING ADAPTATION --}}
    <style>
        .search-box {
            display: flex;
            align-items: center;
        }

        .search-box input {
            width: 220px;
            height: 38px;
            padding: 0 14px;
            border: 1px solid #d9e2ec;
            border-right: none;
            border-radius: 8px 0 0 8px;
            font-size: 13px;
            color: #334155;
            background: #fff;
        }

        .search-box input:focus {
            outline: none;
            border-color: #146c43;
        }

        .search-box button {
            width: 44px;
            height: 38px;
            border: none;
            background: #146c43;
            color: white;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
        }

        .btn-create {
            height: 38px;
            padding: 0 16px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(34, 197, 94, .15);
            transition: .2s;
        }

        .btn-create:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
        }

        .btn-view,
        .btn-edit,
        .btn-delete {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            padding: 0;
        }

        .custom-modal {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
        }

        .custom-header .modal-title {
            font-size: 15px;
            font-weight: 600;
        }

        .modal-body label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
        }

        .modal-body .form-control,
        .modal-body .form-select {
            height: 38px;
            border-radius: 8px;
            border: 1px solid #dbe2ea;
            font-size: 13px;
        }

        .modal-body .form-control:focus,
        .modal-body .form-select:focus {
            border-color: #146c43;
            box-shadow: none;
        }

        .btn-cancel {
            border: none;
            background: #6c757d;
            color: white;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn-save {
            border: none;
            color: white;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
        }

        @media (max-width:768px) {
            .panel-header .w-100 {
                flex-direction: column;
                align-items: stretch !important;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }

            .btn-create {
                width: 100%;
            }
        }
    </style>

    {{-- JS WORKFLOW & SWEETALERT HANDLERS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('modalFaq');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            const form = document.getElementById('formFaq');
            const methodContainer = document.getElementById('methodContainer');

            // 1. EVENT AUTO-SUBMIT FORM IMPORT SAAT FILE SINKRON PILIHAN
            const fileInput = document.getElementById('fileInput');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        Swal.fire({
                            title: 'Sedang Memproses...',
                            text: 'Mohon tunggu berkas Anda sedang di-import dan dianalisis sistem.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('formImport').submit();
                    }
                });
            }

            // 2. CREATE FAQ DATA
            window.createData = function() {
                form.reset();
                document.getElementById('modalTitle').innerText = 'Tambah FAQ';
                form.action = "{{ route('admin.faq.store') }}";
                methodContainer.innerHTML = '';
                modal.show();
            };

            // 3. EDIT FAQ DATA
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modalTitle').innerText = 'Edit FAQ';
                    document.getElementById('layanan_id').value = this.dataset.layanan;
                    document.getElementById('pertanyaan').value = this.dataset.pertanyaan;
                    document.getElementById('jawaban').value = this.dataset.jawaban;
                    form.action = "{{ url('admin/faq') }}/" + this.dataset.id;
                    methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    modal.show();
                });
            });

            // 4. PREVIEW MODAL VIEW FAQ
            const viewModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalViewFaq'));
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('viewLayanan').innerText = this.dataset.layanan;
                    document.getElementById('viewPertanyaan').innerText = this.dataset.pertanyaan;
                    document.getElementById('viewJawaban').innerText = this.dataset.jawaban;
                    viewModal.show();
                });
            });

            // 5. SWEETALERT HAPUS DATA TERMINATION
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const formDelete = this.closest('form');
                    Swal.fire({
                        title: 'Hapus FAQ?',
                        text: 'Kombinasi data FAQ "' + this.dataset.title +
                            '..." akan terhapus dari server.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Hapus'
                    }).then((result) => {
                        if (result.isConfirmed) formDelete.submit();
                    });
                });
            });
        });
    </script>

    {{-- SYSTEM NOTIFICATION POPUPS --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#146c43'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#6c757d'
            });
        </script>
    @endif
@endsection
