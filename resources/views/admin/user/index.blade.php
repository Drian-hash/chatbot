@extends('admin.dashboard')

@section('title', 'Data User')

@section('admin')

<main class="dashboard-content">

    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">

            <div class="page-heading-copy">

                <div>
                    <h2 class="h3 mb-1">Data User</h2>

                    <p class="text-muted mb-0">
                        Kelola data pengguna chatbot.
                    </p>
                </div>

            </div>

        </div>

        <section class="panel">

            <div class="panel-header">

                <div>

                    <h2 class="h5 mb-1 section-title">
                        <span>Daftar User</span>
                    </h2>

                </div>

                <div class="d-flex align-items-center gap-2">

                    {{-- EXPORT --}}
                    <a href="{{ route('admin.user.export') }}"
                       class="btn btn-outline-success btn-sm">

                        <i class="bi bi-file-earmark-excel"></i>
                        Export

                    </a>

                    {{-- SEARCH --}}
                    <form action="{{ route('admin.user.index') }}"
                          method="GET">

                        <div class="search-box">

                            <input
                                type="text"
                                name="search"
                                placeholder="Cari user..."
                                value="{{ request('search') }}">

                            <button type="submit">
                                <i class="bi bi-search"></i>
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <div class="table-responsive rounded-3 border">

                <table class="table align-middle mb-0">

                    <thead style="background: linear-gradient(90deg, #0b3d2e 0%, #146c43 100%);">

                        <tr>

                            <th width="70" class="text-white py-3 ps-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">No</th>
                            <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Nama User</th>
                            <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">No WhatsApp</th>
                            <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Tanggal Daftar</th>
                            <th width="120" class="text-white py-3 text-end pe-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $item)

                            <tr class="border-bottom">

                                <td class="ps-3 text-secondary" style="font-size: 13.5px;">

                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}

                                </td>

                                <td style="font-size: 13.5px; color: #1e293b !important; font-weight: 400;">

                                    {{ $item->name }}

                                </td>

                                <td style="font-size: 13.5px; color: #1e293b !important; font-weight: 400;">

                                    {{ $item->phone ?? '-' }}

                                </td>

                                <td style="font-size: 13.5px; color: #1e293b !important; font-weight: 400;">

                                    {{ $item->created_at->format('d M Y H:i') }}

                                </td>

                                <td class="text-end pe-3">

                                    <div class="d-flex justify-content-end align-items-center gap-1 flex-nowrap">

                                        {{-- VIEW BUTTON --}}
                                        <button type="button" class="btn btn-sm btn-outline-info btn-action-custom"
                                            data-name="{{ $item->name }}"
                                            data-phone="{{ $item->phone ?? '-' }}"
                                            data-date="{{ $item->created_at->format('d F Y H:i') }}"
                                            title="Detail User">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        {{-- DELETE BUTTON --}}
                                        <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST" class="delete-form d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-action-custom btn-delete"
                                                data-title="{{ $item->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center py-4 text-muted" style="font-size: 13.5px;">

                                    Belum ada data user

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 p-3">

                <div class="text-muted" style="font-size: 13px;">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data user
                </div>

                <div class="d-flex align-items-center">
                    @if ($users->onFirstPage())
                        <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}&search={{ request('search') }}"
                            class="px-2 text-decoration-none">&#8249;</a>
                    @endif

                    <span class="px-3 py-1 mx-1 text-white"
                        style="background-color: #5dd5f9; border-radius: 4px; font-size: 13px;">
                        {{ $users->currentPage() }}
                    </span>

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}&search={{ request('search') }}"
                            class="px-2 text-decoration-none">&#8250;</a>
                    @else
                        <span class="px-2 text-muted" style="cursor: default;">&#8250;</span>
                    @endif
                </div>
            </div>

        </section>

    </div>

</main>

<div class="modal fade custom-dynamic-fade" id="modalViewUser" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-custom-top">

        <div class="modal-content custom-modal">

            <div class="modal-header custom-header">

                <h5 class="modal-title">
                    Detail Pengguna Chatbot
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">Nama Pengguna</label>
                    <div id="viewName" class="p-2 border rounded bg-light text-dark" style="font-size: 13.5px; min-height: 38px;"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">No WhatsApp</label>
                    <div id="viewPhone" class="p-2 border rounded bg-light text-dark" style="font-size: 13.5px; min-height: 38px;"></div>
                </div>

                <div>
                    <label class="form-label fw-semibold text-secondary">Tanggal Terdaftar Sistem</label>
                    <div id="viewDate" class="p-2 border rounded bg-light text-dark" style="font-size: 13.5px; min-height: 38px;"></div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>

    </div>

</div>

<style>

/* =========================================
   SEARCH BOX
========================================= */

.search-box{
    display:flex;
    align-items:center;
}

.search-box input{
    width:220px;
    height:40px;

    padding:0 14px;

    border:1px solid #d9e2ec;
    border-right:none;

    border-radius:10px 0 0 10px;

    font-size:13px;
    color: #334155;
    background: #fff;
}

.search-box input:focus {
    outline: none;
    border-color: #2563eb;
}

.search-box button{
    width:48px;
    height:40px;

    border:none;

    background:#2563eb;
    color:white;

    border-radius:0 10px 10px 0;
    cursor: pointer;
}

.search-box button:hover{
    background:#1d4ed8;
}

/* =========================================
   PANEL HEADER
========================================= */

.panel-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
}

.btn-action-custom {
    width: 30px !important;
    height: 30px !important;
    padding: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 6px !important;
}
.btn-action-custom i {
    font-size: 13px !important;
}

/* =========================================
   MODAL CUSTOM DESIGN & POSITION
========================================= */

/* ⚡ FIX: Mengecilkan lebar maksimal modal menjadi 400px agar lebih ramping */
.modal-custom-top {
    max-width: 400px !important;
    margin: 6vh auto 1.75rem auto !important;
}

.custom-modal {
    border: none;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, .12), 0 5px 15px rgba(0, 0, 0, .08);
    transition: transform 0.3s ease-out;
}

.custom-dynamic-fade .modal-content {
    transform: translateY(20px);
    opacity: 0;
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.25s ease;
}

.custom-dynamic-fade.show .modal-content {
    transform: translateY(0);
    opacity: 1;
}

.custom-header {
    background: #5f73e6;
    color: white;
    border: none;
    padding: 14px 18px;
}

.custom-header .modal-title {
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.modal-body {
    padding: 20px;
}

.modal-body label {
    display: block;
    margin-bottom: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #4b5563;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modal-body .border {
    background-color: #f8fafc !important;
    border-color: #e2e8f0 !important;
    padding: 10px 12px !important;
    border-radius: 8px !important;
    transition: all 0.2s;
}

.modal-body .border:hover {
    border-color: #cbd5e1 !important;
    background-color: #f1f5f9 !important;
}

.modal-footer {
    border-top: 1px solid #f1f5f9;
    padding: 12px 20px;
    background-color: #fafafa;
}

.btn-cancel {
    border: none;
    background: #64748b;
    color: white;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-cancel:hover {
    background: #475569;
}

@media(max-width:768px){
    .search-box{
        width:100%;
    }
    .search-box input{
        width:100%;
    }
    .modal-custom-top {
        max-width: 92% !important;
        margin: 4vh auto !important;
    }
}

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | EVENT: DETECT & SHOW MODAL DETAIL USER
        |--------------------------------------------------------------------------
        */
        const viewModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalViewUser'));

        document.querySelectorAll('.btn-outline-info').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('viewName').innerText = this.dataset.name;
                document.getElementById('viewPhone').innerText = this.dataset.phone;
                document.getElementById('viewDate').innerText = this.dataset.date;
                viewModal.show();
            });
        });

        /*
        |--------------------------------------------------------------------------
        | EVENT: DETECT & CONFIRM DELETE USER VIA SWEETALERT2
        |--------------------------------------------------------------------------
        */
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const formDelete = this.closest('form');
                const userName = this.dataset.title;

                Swal.fire({
                    title: 'Hapus User?',
                    text: 'Pengguna "' + userName + '" akan dihapus permanen dari sistem.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formDelete.submit();
                    }
                });
            });
        });

    });
</script>

@endsection
