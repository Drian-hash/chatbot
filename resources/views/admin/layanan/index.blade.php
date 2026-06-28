@extends('admin.dashboard')

@section('title', 'Data Layanan')

@section('admin')

    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">

            {{-- JUDUL UTAMA --}}
            <div class="page-heading mb-3">
                <div class="page-heading-copy">
                    <div>
                        <h3 class="h3 mb-1 text-dark fw-bold" style="color: #0f5132 !important;">Data Layanan</h3>
                        <p class="text-muted mb-0">
                            Kelola data master jenis pelayanan publik Dinas Komunikasi dan Informatika Kabupaten Ketapang.
                        </p>
                    </div>
                </div>
            </div>

            <section class="panel">

                {{-- PANEL ACTION BAR: SEJAJAR DI BAWAH TULISAN JUDUL (SINKRON DENGAN HALAMAN FAQ) --}}
                <div class="panel-header mb-3">
                    <div class="w-100 d-flex justify-content-between align-items-center flex-wrap gap-2 m-0">

                        {{-- SISI KIRI: CONFIG SHOW ENTRIES --}}
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">Show</span>
                                <form action="{{ route('admin.layanan.index') }}" method="GET" class="m-0">
                                    <select name="per_page" class="form-select text-center" style="width: 70px; height: 38px; font-size: 13.5px; border-radius: 8px;" onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                </form>
                                <span class="text-muted small">entries</span>
                            </div>

                            {{-- Reset Button --}}
                            @if(request('search'))
                                <a href="{{ route('admin.layanan.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center" style="height: 38px; border-radius: 8px; padding: 0 12px;">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            @endif
                        </div>

                        {{-- SISI KANAN: SEARCH BOX & TOMBOL TAMBAH DATA --}}
                        <div class="d-flex align-items-center gap-2">
                            {{-- Search Box --}}
                            <form action="{{ route('admin.layanan.index') }}" method="GET" class="m-0">
                                <div class="search-box">
                                    <input type="text" name="search" placeholder="Cari jenis layanan..." value="{{ request('search') }}">
                                    @if(request('per_page'))
                                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                    @endif
                                    <button type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- Tambah Data Baru --}}
                            <button type="button" class="btn-create" style="height: 38px; border-radius: 8px;" id="btnTambah">
                                <i class="bi bi-plus-lg"></i> Tambah Layanan
                            </button>
                        </div>

                    </div>
                </div>

                {{-- DATA TABLE CONTAINER --}}
                <div class="table-responsive rounded-3 border">
                    <table class="table align-middle mb-0">
                        <thead style="background: linear-gradient(90deg, #0b3d2e 0%, #146c43 100%);">
                            <tr>
                                <th width="60" class="text-white py-3 ps-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">No</th>
                                <th width="350" class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Nama Layanan</th>
                                <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Deskripsi Operasional</th>
                                <th width="140" class="text-white py-3 text-end pe-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($layanan as $item)
                                <tr class="border-bottom">
                                    <td class="ps-3 text-secondary" style="font-size: 13.5px;">
                                        {{ ($layanan->currentPage() - 1) * $layanan->perPage() + $loop->iteration }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #1e293b !important; font-weight: 500;">
                                        {{ $item->nama_layanan }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #475569 !important; text-align: justify;" class="pe-4">
                                        {{ Str::limit($item->deskripsi, 140) ?? '-' }}
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="action-buttons">
                                            {{-- VIEW (DETAIL DESKRIPSI LAYANAN LENGKAP) --}}
                                            <button type="button" class="btn btn-outline-info btn-sm btn-view"
                                                data-nama="{{ $item->nama_layanan }}"
                                                data-deskripsi="{{ $item->deskripsi ?? 'Belum ada penjelasan deskripsi untuk layanan ini.' }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            {{-- EDIT --}}
                                            <button type="button" class="btn btn-outline-warning btn-sm btn-edit"
                                                data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama_layanan }}"
                                                data-deskripsi="{{ $item->deskripsi }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete" data-title="{{ Str::limit($item->nama_layanan, 30) }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted" style="font-size: 13.5px;">
                                        Belum ada data master layanan publik terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION FOOTER --}}
                <div class="d-flex justify-content-between align-items-center mt-3 p-3">
                    <div class="text-muted" style="font-size: 13px;">
                        Menampilkan {{ $layanan->firstItem() ?? 0 }} - {{ $layanan->lastItem() ?? 0 }} dari {{ $layanan->total() }} data layanan
                    </div>

                    <div class="d-flex align-items-center">
                        @if ($layanan->onFirstPage())
                            <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                        @else
                            <a href="{{ $layanan->previousPageUrl() }}&search={{ request('search') }}&per_page={{ request('per_page') }}" class="px-2 text-decoration-none">&#8249;</a>
                        @endif

                        <span class="px-3 py-1 mx-1 text-white" style="background-color: #146c43; border-radius: 4px; font-size: 13px;">
                            {{ $layanan->currentPage() }}
                        </span>

                        @if ($layanan->hasMorePages())
                            <a href="{{ $layanan->nextPageUrl() }}&search={{ request('search') }}&per_page={{ request('per_page') }}" class="px-2 text-decoration-none">&#8250;</a>
                        @endif
                    </div>
                </div>

            </section>
        </div>
    </main>

    {{-- MODAL LAYANAN: TAMBAH & EDIT --}}
    <div class="modal fade" id="modalLayanan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <form id="formLayanan" action="{{ route('admin.layanan.store') }}" method="POST">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="modal-header custom-header" style="background-color: #146c43;">
                        <h5 class="modal-title" id="modalTitle">Tambah Layanan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" placeholder="Masukkan nama bidang layanan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Operasional</label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control" placeholder="Masukkan penjelasan rincian dan output layanan..."></textarea>
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

    {{-- MODAL VIEW DETAIL DESKRIPSI LAYANAN --}}
    <div class="modal fade" id="modalViewLayanan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-header" style="background-color: #0b3d2e;">
                    <h5 class="modal-title">Detail Informasi Layanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Nama Master Layanan</label>
                        <div id="viewNamaLayanan" class="p-2.5 border rounded bg-light text-dark fw-bold" style="font-size: 13.5px; color: #0b3d2e !important;"></div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold text-secondary">Rincian Deskripsi & Konteks WhatsApp NLP</label>
                        <div id="viewDeskripsi" class="p-2.5 border rounded bg-light text-dark" style="font-size: 13.5px; white-space: pre-wrap; text-align: justify; line-height: 1.5;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- STYLING ADAPTATION (IDENTIK DENGAN FAQ) --}}
    <style>
        .search-box { display: flex; align-items: center; }
        .search-box input {
            width: 220px; height: 38px; padding: 0 14px;
            border: 1px solid #d9e2ec; border-right: none;
            border-radius: 8px 0 0 8px; font-size: 13px; color: #334155; background: #fff;
        }
        .search-box input:focus { outline: none; border-color: #146c43; }
        .search-box button {
            width: 44px; height: 38px; border: none;
            background: #146c43; color: white; border-radius: 0 8px 8px 0; cursor: pointer;
        }
        .btn-create {
            height: 38px; padding: 0 16px; border: none; border-radius: 8px;
            background: linear-gradient(135deg, #22c55e, #16a34a); color: white;
            font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 3px 10px rgba(34, 197, 94, .15); transition: .2s;
        }
        .btn-create:hover { transform: translateY(-1px); background: linear-gradient(135deg, #16a34a, #15803d); }
        .action-buttons { display: flex; justify-content: flex-end; align-items: center; gap: 8px; }
        .btn-view, .btn-edit, .btn-delete { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 6px; padding: 0; }
        .custom-modal { border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, .15); }
        .custom-header .modal-title { font-size: 15px; font-weight: 600; }
        .modal-body label { display: block; margin-bottom: 5px; font-size: 12px; font-weight: 600; color: #374151; }
        .modal-body .form-control, .modal-body .form-select { height: 38px; border-radius: 8px; border: 1px solid #dbe2ea; font-size: 13px; }
        .modal-body .form-control:focus, .modal-body .form-select:focus { border-color: #146c43; box-shadow: none; }
        .btn-cancel { border: none; background: #6c757d; color: white; padding: 7px 16px; border-radius: 8px; font-size: 13px; }
        .btn-save { border: none; color: white; padding: 7px 16px; border-radius: 8px; font-size: 13px; }

        .modal-body textarea.form-control { min-height: 100px; max-height: 220px; resize: vertical; }

        @media (max-width:768px) {
            .panel-header .w-100 { flex-direction: column; align-items: stretch !important; }
            .search-box { width: 100%; }
            .search-box input { width: 100%; }
            .btn-create { width: 100%; }
        }
    </style>

    {{-- JS WORKFLOW & SWEETALERT HANDLERS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('modalLayanan');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            const form = document.getElementById('formLayanan');
            const methodContainer = document.getElementById('methodContainer');

            // 1. CREATE DATA MODE TRIGGER
            const btnTambah = document.getElementById('btnTambah');
            if (btnTambah) {
                btnTambah.addEventListener('click', function() {
                    form.reset();
                    document.getElementById('modalTitle').innerText = 'Tambah Layanan';
                    form.action = "{{ route('admin.layanan.store') }}";
                    methodContainer.innerHTML = '';
                    modal.show();
                });
            }

            // 2. EDIT DATA MODE TRIGGER
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modalTitle').innerText = 'Edit Layanan';
                    document.getElementById('nama_layanan').value = this.dataset.nama;
                    document.getElementById('deskripsi').value = this.dataset.deskripsi ?? '';
                    form.action = "{{ url('admin/layanan') }}/" + this.dataset.id;
                    methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    modal.show();
                });
            });

            // 3. PREVIEW MODAL VIEW LAYANAN (DIPERBAIKI AGAR COCOK DENGAN DETAIL FAQ)
            const viewModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalViewLayanan'));
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('viewNamaLayanan').innerText = this.dataset.nama;
                    document.getElementById('viewDeskripsi').innerText = this.dataset.deskripsi;
                    viewModal.show();
                });
            });

            // 4. SWEETALERT HAPUS DATA TERMINATION
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const formDelete = this.closest('form');
                    Swal.fire({
                        title: 'Hapus Layanan?',
                        text: 'Master data "' + this.dataset.title + '" akan dihapus permanen dari sistem.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Hapus'
                    }).then((result) => { if (result.isConfirmed) formDelete.submit(); });
                });
            });
        });
    </script>

    {{-- SYSTEM NOTIFICATION POPUPS --}}
    @if (session('success'))
        <script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', confirmButtonColor: '#146c43' });</script>
    @endif
    @if (session('error'))
        <script>Swal.fire({ icon: 'error', title: 'Gagal', text: '{{ session("error") }}', confirmButtonColor: '#6c757d' });</script>
    @endif
@endsection
