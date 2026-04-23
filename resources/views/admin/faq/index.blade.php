@extends('admin.dashboard')

@section('title', 'FAQ')

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

        .btn-import-outline {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 9px 14px;
            border-radius: 8px;
            cursor: pointer;
        }

        .filter-layanan {
            padding: 6px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .right-actions input {
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 200px;
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

    <h2 class="title">Data FAQ</h2>

    <div class="table-box">

        <div class="table-header">

            <div class="left-actions">
                <button onclick="openModal()" class="btn-add">+ Tambah FAQ</button>

                <select class="filter-layanan">
                    <option>Semua Layanan</option>
                    @foreach ($layanan as $l)
                        <option>{{ $l->nama_layanan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="right-actions">

                <form id="formImport" action="{{ route('admin.faq.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="fileInput" hidden>
                    <button type="button" class="btn-import-outline" onclick="fileInput.click()">
                        <i class="fas fa-upload"></i> Import
                    </button>
                </form>

                <form method="GET">
                    <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
                </form>

            </div>

        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                    <th>Views</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($faq as $item)
                    <tr>
                        <td>{{ ($faq->currentPage() - 1) * $faq->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->layanan->nama_layanan }}</td>
                        <td>{{ $item->pertanyaan }}</td>
                        <td>{{ $item->jawaban }}</td>
                        <td><b>{{ $item->jumlah_ditanya ?? 0 }}x</b></td>
                        <td class="aksi">
                            <button class="icon-btn edit" onclick='editData(@json($item))'>
                                <i class="fas fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.faq.destroy', $item->id) }}" method="POST"
                                data-title="{{ $item->pertanyaan }}">
                                @csrf @method('DELETE')
                                <button type="button" class="icon-btn delete btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px;color:#999;">
                            Belum ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">

            <!-- INFO -->
            <div class="pagination-info">
                Menampilkan {{ $faq->firstItem() ?? 0 }} - {{ $faq->lastItem() ?? 0 }}
                dari {{ $faq->total() }} data
            </div>

            <!-- BUTTON -->
            <div class="pagination-custom">

                {{-- PREVIOUS --}}
                @if ($faq->onFirstPage())
                    <span class="pagination-btn disabled">&#8249;</span>
                @else
                    <a href="{{ $faq->previousPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8249;</a>
                @endif

                {{-- CURRENT PAGE --}}
                <span class="pagination-current">
                    {{ $faq->currentPage() }}
                </span>

                {{-- NEXT --}}
                @if ($faq->hasMorePages())
                    <a href="{{ $faq->nextPageUrl() }}&search={{ request('search') }}" class="pagination-btn">&#8250;</a>
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
                <span id="modalTitle">Tambah FAQ</span>
                <span onclick="closeModal()" style="cursor:pointer;">&times;</span>
            </div>

            <form id="formFaq" method="POST">
                @csrf

                <div class="form-group">
                    <label>Layanan</label>
                    <select name="layanan_id" id="layanan_id">
                        @foreach ($layanan as $l)
                            <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Pertanyaan</label>
                    <textarea name="pertanyaan" id="pertanyaan"></textarea>
                </div>

                <div class="form-group">
                    <label>Jawaban</label>
                    <textarea name="jawaban" id="jawaban"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>

            </form>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'flex';
            document.getElementById('formFaq').reset();
            document.getElementById('formFaq').action = "{{ route('admin.faq.store') }}";
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function editData(data) {
            openModal();
            document.getElementById('modalTitle').innerText = 'Edit FAQ';

            layanan_id.value = data.layanan_id;
            pertanyaan.value = data.pertanyaan;
            jawaban.value = data.jawaban;

            let form = document.getElementById('formFaq');
            form.action = "/admin/faq/" + data.id;

            if (!form.querySelector('input[name=_method]')) {
                let m = document.createElement('input');
                m.type = 'hidden';
                m.name = '_method';
                m.value = 'PUT';
                form.appendChild(m);
            }
        }
    </script>

@endsection
