@extends('admin.dashboard')

@section('title', 'Layanan')

@section('admin')

    <!-- 🔥 FONT MODERN -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* 🔥 GLOBAL FONT */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* ===== TITLE ===== */
        .title {
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 600;
        }

        /* ===== BOX ===== */
        .table-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        /* ===== HEADER ===== */
        .table-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .left-actions,
        .right-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* ===== BUTTON ===== */
        .btn-add {
            background: #22c55e;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        /* ===== SEARCH ===== */
        .right-actions input {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            text-align: left;
            font-size: 13px;
            /* 🔥 lebih rapi */
            font-weight: 600;
        }

        td,
        th {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        td {
            font-size: 13px;
            /* 🔥 lebih kecil */
            line-height: 1.5;
        }

        /* ===== ACTION ===== */
        .aksi {
            display: flex;
            gap: 6px;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            font-size: 13px;
        }

        .pagination-info {
            color: #6b7280;
        }

        .pagination-custom {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-btn {
            padding: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: #555;
            transition: 0.2s;
        }

        .pagination-btn:hover {
            background: #f3f4f6;
        }

        .pagination-btn.disabled {
            color: #bbb;
            cursor: default;
        }

        .pagination-current {
            padding: 6px 12px;
            border-radius: 6px;
            background: #38bdf8;
            color: white;
            font-weight: 500;
        }

        .icon-btn {
            border: none;
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
        }

        .edit {
            background: #3b82f6;
            color: white;
        }

        .delete {
            background: #ef4444;
            color: white;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: flex-start;
            padding-top: 70px;
            z-index: 9999;
        }

        .modal-box {
            background: white;
            width: 500px;
            padding: 25px;
            border-radius: 14px;
            animation: fade 0.2s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 13px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        /* VALIDATION */
        .input-error {
            border-color: #ef4444;
        }

        .error-text {
            font-size: 12px;
            color: #ef4444;
        }

        /* FOOTER */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-save {
            background: #22c55e;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
        }

        .btn-save.loading {
            background: #94a3b8;
        }

        .btn-cancel {
            background: #eee;
            padding: 10px 16px;
            border-radius: 8px;
        }
    </style>

    <h2 class="title">Data Layanan</h2>

    <div class="table-box">

        <div class="table-header">
            <div class="left-actions">
                <button onclick="openModal()" class="btn-add">+ Tambah Layanan</button>
            </div>

            <div class="right-actions">
                <form method="GET">
                    <input type="text" name="search" placeholder="Cari layanan..." value="{{ request('search') }}">
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($layanan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_layanan }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td class="aksi">

                            <button onclick='editData(@json($item))' class="icon-btn edit">
                                <i class="fas fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST"
                                data-title="{{ $item->nama_layanan }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-btn delete btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#999;">
                            Belum ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">

            <!-- INFO -->
            <div class="pagination-info">
                Menampilkan {{ $layanan->firstItem() ?? 0 }} - {{ $layanan->lastItem() ?? 0 }}
                dari {{ $layanan->total() }} data
            </div>

            <!-- BUTTON -->
            <div class="pagination-custom">

                {{-- PREVIOUS --}}
                @if ($layanan->onFirstPage())
                    <span class="pagination-btn disabled">&#8249;</span>
                @else
                    <a href="{{ $layanan->previousPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8249;</a>
                @endif

                {{-- CURRENT PAGE --}}
                <span class="pagination-current">
                    {{ $layanan->currentPage() }}
                </span>

                {{-- NEXT --}}
                @if ($layanan->hasMorePages())
                    <a href="{{ $layanan->nextPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8250;</a>
                @else
                    <span class="pagination-btn disabled">&#8250;</span>
                @endif

            </div>

        </div>

    </div>

    <!-- MODAL -->
    <div id="modal" class="modal-overlay">
        <div class="modal-box">

            <div class="modal-header">
                <h3 id="modalTitle">Tambah Layanan</h3>
                <span onclick="closeModal()" style="cursor:pointer;">&times;</span>
            </div>

            <form id="formLayanan" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Layanan</label>
                    <input type="text" name="nama_layanan" id="nama_layanan">
                    <div class="error-text" id="error_nama"></div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"></textarea>
                    <div class="error-text" id="error_deskripsi"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn-cancel">Batal</button>
                    <button type="submit" id="btnSubmit" class="btn-save">Simpan</button>
                </div>

            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ✅ SUCCESS ALERT --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}'
            });
        </script>
    @endif

    <script>
        const nama = document.getElementById('nama_layanan');
        const deskripsi = document.getElementById('deskripsi');
        const form = document.getElementById('formLayanan');
        const btn = document.getElementById('btnSubmit');
        const modal = document.getElementById('modal');

        /* VALIDASI */
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let valid = true;

            if (nama.value.trim() === '') {
                error_nama.innerText = 'Nama wajib diisi';
                nama.classList.add('input-error');
                valid = false;
            } else {
                error_nama.innerText = '';
                nama.classList.remove('input-error');
            }

            if (deskripsi.value.length < 5) {
                error_deskripsi.innerText = 'Minimal 5 karakter';
                deskripsi.classList.add('input-error');
                valid = false;
            } else {
                error_deskripsi.innerText = '';
                deskripsi.classList.remove('input-error');
            }

            if (!valid) return;

            btn.classList.add('loading');
            btn.innerText = 'Menyimpan...';

            setTimeout(() => form.submit(), 700);
        });

        /* MODAL */
        function openModal() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            form.reset();
            form.action = "{{ route('admin.layanan.store') }}";

            document.getElementById('modalTitle').innerText = "Tambah Layanan";

            let m = form.querySelector('input[name=_method]');
            if (m) m.remove();
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        /* EDIT */
        function editData(data) {
            openModal();

            document.getElementById('modalTitle').innerText = "Edit Layanan";

            nama.value = data.nama_layanan;
            deskripsi.value = data.deskripsi;

            form.action = "/admin/layanan/" + data.id;

            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);
        }

        /* DELETE (FIX GLOBAL) */
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {

                let btn = e.target.closest('.btn-delete');
                let form = btn.closest('form');
                let title = form.getAttribute('data-title');

                Swal.fire({
                    title: 'Yakin?',
                    text: `Layanan "${title}" akan dihapus`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    </script>

@endsection
