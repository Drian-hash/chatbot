@extends('admin.dashboard')

@section('title', 'Auto Response')

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
            /* 🔥 */
            font-weight: 600;
        }

        td,
        th {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        td {
            font-size: 13px;
            /* 🔥 */
            line-height: 1.5;
        }

        /* ===== ACTION ===== */
        .aksi {
            display: flex;
            gap: 6px;
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

        /* ===== PAGINATION ===== */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
            font-size: 13px;
        }

        .pagination-btn {
            padding: 5px 10px;
            border-radius: 6px;
            color: #555;
        }

        .pagination-current {
            background: #38bdf8;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
            justify-content: center;
            align-items: flex-start;
            padding-top: 70px;
            z-index: 9999;
        }

        .modal-box {
            background: #fff;
            width: 520px;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            animation: fadeModal 0.25s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .close-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: #f3f4f6;
            cursor: pointer;
            font-size: 18px;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-size: 13px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 13px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        /* ===== FOOTER ===== */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            background: #f1f5f9;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .btn-save {
            background: #22c55e;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
        }
    </style>

    <h2 class="title">Auto Response</h2>

    <div class="table-box">

        <div class="table-header">
            <div class="left-actions">
                <button onclick="openModal()" class="btn-add">+ Tambah Kata Kunci</button>
            </div>

            <div class="right-actions">
                <form method="GET">
                    <input type="text" name="search" placeholder="Cari keyword..." value="{{ request('search') }}">
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kata Kunci</th>
                    <th>Jawaban</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($keyword as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kata_kunci }}</td>
                        <td>{{ $item->jawaban }}</td>
                        <td class="aksi">

                            <button onclick='editData(@json($item))' class="icon-btn edit">
                                <i class="fas fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.keyword.destroy', $item->id) }}" method="POST"
                                data-title="{{ $item->kata_kunci }}">
                                @csrf @method('DELETE')
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
                Menampilkan {{ $keyword->firstItem() ?? 0 }} - {{ $keyword->lastItem() ?? 0 }}
                dari {{ $keyword->total() }} data
            </div>

            <!-- BUTTON -->
            <div class="pagination-custom">

                {{-- PREVIOUS --}}
                @if ($keyword->onFirstPage())
                    <span class="pagination-btn disabled">&#8249;</span>
                @else
                    <a href="{{ $keyword->previousPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8249;</a>
                @endif

                {{-- CURRENT PAGE --}}
                <span class="pagination-current">
                    {{ $keyword->currentPage() }}
                </span>

                {{-- NEXT --}}
                @if ($keyword->hasMorePages())
                    <a href="{{ $keyword->nextPageUrl() }}&search={{ request('search') }}"
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
                <h3 id="modalTitle">Tambah Keyword</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>

            <form id="formKeyword" method="POST">
                @csrf

                <div class="form-group">
                    <label>Kata Kunci</label>
                    <input type="text" name="kata_kunci" id="kata_kunci">
                </div>

                <div class="form-group">
                    <label>Jawaban</label>
                    <textarea name="jawaban" id="jawaban"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>

            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SUCCESS --}}
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
        const modal = document.getElementById('modal');
        const form = document.getElementById('formKeyword');

        /* MODAL */
        function openModal() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            form.reset();
            form.action = "{{ route('admin.keyword.store') }}";

            document.getElementById('modalTitle').innerText = 'Tambah Keyword';

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

            document.getElementById('modalTitle').innerText = 'Edit Keyword';
            kata_kunci.value = data.kata_kunci;
            jawaban.value = data.jawaban;

            form.action = "/admin/keyword/" + data.id;

            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);
        }

        /* DELETE FIX */
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                let btn = e.target.closest('.btn-delete');
                let form = btn.closest('form');
                let title = form.getAttribute('data-title');

                Swal.fire({
                    title: 'Yakin?',
                    text: `Keyword "${title}" akan dihapus`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then(res => {
                    if (res.isConfirmed) form.submit();
                });
            }
        });
    </script>

@endsection
