@extends('admin.dashboard')

@section('title', 'Data Permohonan')

@section('admin')

    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">

            {{-- JUDUL UTAMA --}}
            <div class="page-heading mb-3">
                <div class="page-heading-copy">
                    <h3 class="h3 mb-1">Daftar Permohonan</h3>
                </div>
            </div>

            <section class="panel">

                {{-- PANEL FILTER DAN SEARCH (SEJAJAR DI BAWAH TULISAN JUDUL) --}}
                <div class="panel-header mb-3">
                    <form action="{{ route('admin.permohonan.index') }}" method="GET" class="w-100 d-flex justify-content-between align-items-center flex-wrap gap-2 m-0">

                        {{-- SISI KIRI: CONFIG ENTRIES & FILTER STATUS (BERDEKATAN) --}}
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            {{-- Show Entries --}}
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">Show</span>
                                <select name="per_page" class="form-select text-center" style="width: 70px; height: 38px; font-size: 13.5px; border-radius: 8px;" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-muted small">entries</span>
                            </div>

                            {{-- Filter Status (Digeser ke Kiri dekat Show Entries) --}}
                            <select name="status" class="form-select" style="height: 38px; font-size: 13px; border-radius: 8px; width: 150px;" onchange="this.form.submit()">
                                <option value="">-- Semua Status --</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>

                            {{-- Reset Button jika ada filter aktif --}}
                            @if(request()->anyFilled(['search', 'status']))
                                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center" style="height: 38px; border-radius: 8px; padding: 0 12px;">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            @endif
                        </div>

                        {{-- SISI KANAN: TOMBOL SEARCH --}}
                        <div class="search-box">
                            <input type="text" name="search" placeholder="Cari kode, nama, nomor..." value="{{ request('search') }}">
                            <button type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                    </form>
                </div>

                {{-- DATA TABLE CONTAINER --}}
                <div class="table-responsive rounded-3 border">
                    <table class="table align-middle mb-0">
                        <thead style="background: linear-gradient(90deg, #0b3d2e 0%, #146c43 100%);">
                            <tr>
                                <th width="60" class="text-white py-3 ps-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">No</th>
                                <th width="100" class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Kode</th>
                                <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Pemohon</th>
                                <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Layanan Utama</th>
                                <th class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Tanggal Masuk</th>
                                <th width="150" class="text-white py-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Status</th>
                                <th width="120" class="text-white py-3 text-end pe-3" style="font-size: 13px; font-weight: 600; letter-spacing: 0.5px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permohonans as $item)
                                <tr class="border-bottom">
                                    {{-- KOLOM NOMOR UTAMA --}}
                                    <td class="ps-3 text-secondary" style="font-size: 13.5px;">
                                        {{ ($permohonans->currentPage() - 1) * $permohonans->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="font-monospace fw-bold text-secondary" style="font-size: 13.5px;">
                                        #{{ $item->kode_permohonan }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #1e293b !important;">
                                        <div class="fw-bold">{{ $item->nama_pemohon }}</div>
                                        <small class="text-muted"><i class="bi bi-whatsapp text-success me-1"></i>{{ $item->nomor_hp }}</small>
                                    </td>
                                    <td style="font-size: 13.5px; color: #1e293b !important;">
                                        {{ $item->layanan->nama_layanan ?? '-' }}
                                    </td>
                                    <td style="font-size: 13.5px; color: #64748b !important;">
                                        {{ $item->created_at->translatedFormat('d M Y, H:i') }} WIB
                                    </td>

                                    {{-- DROPDOWN INLINE STATUS PILL SELECTION --}}
                                    <td>
                                        <form action="{{ route('admin.permohonan.update', $item->id) }}" method="POST" class="m-0 status-inline-form">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="catatan_admin" value="{{ $item->catatan_admin }}">

                                            <select name="status" class="form-select form-select-sm fw-semibold status-dropdown-pill @if($item->status == 'Pending') text-warning border-warning @elseif($item->status == 'Proses') text-info border-info @elseif($item->status == 'Selesai') text-success border-success @else text-danger border-danger @endif"
                                                    style="border-radius: 30px; height: 32px; padding: 2px 28px 2px 12px; font-size: 12.5px; cursor: pointer; background-position: right 8px center;"
                                                    onchange="confirmStatusUpdate(this)">
                                                <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="Ditolak" {{ $item->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </form>
                                    </td>

                                    <td class="text-end pe-3">
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-outline-info btn-sm btn-view"
                                                data-id="{{ $item->id }}"
                                                data-kode="{{ $item->kode_permohonan }}"
                                                data-pemohon="{{ $item->nama_pemohon }}"
                                                data-hp="{{ $item->nomor_hp }}"
                                                data-layanan="{{ $item->layanan->nama_layanan ?? '-' }}"
                                                data-status="{{ $item->status }}"
                                                data-catatan="{{ $item->catatan_admin }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <form action="{{ route('admin.permohonan.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete" data-title="{{ $item->kode_permohonan }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted" style="font-size: 13.5px;">
                                        Belum ada data permohonan masuk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION FOOTER --}}
                <div class="d-flex justify-content-between align-items-center mt-3 p-3">
                    <div class="text-muted" style="font-size: 13px;">
                        Menampilkan {{ $permohonans->firstItem() ?? 0 }} - {{ $permohonans->lastItem() ?? 0 }} dari {{ $permohonans->total() }} data Permohonan
                    </div>
                    <div class="d-flex align-items-center">
                        @if ($permohonans->onFirstPage())
                            <span class="px-2 text-muted" style="cursor: default;">&#8249;</span>
                        @else
                            <a href="{{ $permohonans->previousPageUrl() }}&search={{ request('search') }}&status={{ request('status') }}&per_page={{ request('per_page') }}" class="px-2 text-decoration-none">&#8249;</a>
                        @endif

                        <span class="px-3 py-1 mx-1 text-white" style="background-color: #146c43; border-radius: 4px; font-size: 13px;">
                            {{ $permohonans->currentPage() }}
                        </span>

                        @if ($permohonans->hasMorePages())
                            <a href="{{ $permohonans->nextPageUrl() }}&search={{ request('search') }}&status={{ request('status') }}&per_page={{ request('per_page') }}" class="px-2 text-decoration-none">&#8250;</a>
                        @endif
                    </div>
                </div>

            </section>
        </div>
    </main>

    {{-- MODAL PROCESS & UPDATE DETAIL --}}
    <div class="modal fade" id="modalProcessPermohonan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <form id="formPermohonan" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header custom-header" style="background: #146c43;">
                        <h5 class="modal-title">Periksa & Tindak Berkas</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2 mb-3 p-2 bg-light border rounded" style="font-size: 12.5px;">
                            <div class="col-6">
                                <span class="text-secondary d-block">Kode:</span>
                                <strong id="viewKode" class="font-monospace text-dark">-</strong>
                            </div>
                            <div class="col-6">
                                <span class="text-secondary d-block">Layanan:</span>
                                <strong id="viewLayananText" class="text-dark">-</strong>
                            </div>
                            <div class="col-6 mt-1">
                                <span class="text-secondary d-block">Pemohon:</span>
                                <strong id="viewPemohonText" class="text-dark">-</strong>
                            </div>
                            <div class="col-6 mt-1">
                                <span class="text-secondary d-block">No. HP WA:</span>
                                <strong id="viewHpText" class="text-dark">-</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status Berkas <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Pending">Pending (Menunggu Antrean)</option>
                                <option value="Proses">Proses (Verifikasi / Input Staff)</option>
                                <option value="Selesai">Selesai (Berkas Rampung / Notifikasi)</option>
                                <option value="Ditolak">Ditolak (Data Tidak Valid)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan Resmi Admin</label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="4" class="form-control" placeholder="Tulis instruksi tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save" style="background-color: #146c43;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CSS CUSTOM STYLING --}}
    <style>
        .panel-header { display: flex; align-items: center; justify-content: space-between; }
        .search-box { display: flex; align-items: center; }
        .search-box input {
            width: 240px; height: 38px; padding: 0 14px;
            border: 1px solid #d9e2ec; border-right: none;
            border-radius: 8px 0 0 8px; font-size: 13px; color: #334155; background: #fff;
        }
        .search-box input:focus { outline: none; border-color: #146c43; }
        .search-box button {
            width: 44px; height: 38px; border: none;
            background: #146c43; color: white; border-radius: 0 8px 8px 0; cursor: pointer;
        }
        .search-box button:hover { background: #0b3d2e; }

        .status-dropdown-pill { background-color: #ffffff; font-weight: 600; transition: all 0.2s ease; }
        .status-dropdown-pill:focus { box-shadow: 0 0 0 0.25rem rgba(20, 108, 67, 0.15); outline: none; }

        .action-buttons { display: flex; justify-content: flex-end; align-items: center; gap: 8px; }
        .btn-view, .btn-delete { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .custom-modal { border: none; border-radius: 12px; overflow: hidden; }
        .custom-header { color: white; border: none; padding: 12px 16px; }
        .modal-body .form-control, .modal-body .form-select { height: 38px; border-radius: 8px; border: 1px solid #dbe2ea; font-size: 13px; }
        .modal-body .form-control:focus, .modal-body .form-select:focus { border-color: #146c43; box-shadow: none; }
        .btn-cancel { border: none; background: #6c757d; color: white; padding: 7px 16px; border-radius: 8px; font-size: 13px; }
        .btn-save { border: none; color: white; padding: 7px 16px; border-radius: 8px; font-size: 13px; }

        @media (max-width: 768px) {
            .panel-header form { flex-direction: column; align-items: stretch !important; }
            .search-box { width: 100%; margin-top: 8px; }
            .search-box input { width: 100%; }
        }
    </style>

    {{-- INTERACTION JAVASCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('modalProcessPermohonan');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            const form = document.getElementById('formPermohonan');

            // 1. MODAL DETAIL VIEW
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('viewKode').innerText = '#' + this.dataset.kode;
                    document.getElementById('viewLayananText').innerText = this.dataset.layanan;
                    document.getElementById('viewPemohonText').innerText = this.dataset.pemohon;
                    document.getElementById('viewHpText').innerText = this.dataset.hp;
                    document.getElementById('status').value = this.dataset.status;
                    document.getElementById('catatan_admin').value = this.dataset.catatan || '';
                    form.action = "{{ url('admin/permohonan') }}/" + this.dataset.id;
                    modal.show();
                });
            });

            // 2. DETEKSI PERUBAHAN STATUS INSTAN DARI DROPDOWN TABEL
            window.confirmStatusUpdate = function(selectElement) {
                const targetStatus = selectElement.value;
                const innerForm = selectElement.closest('form');

                Swal.fire({
                    title: 'Ubah Status Berkas?',
                    text: `Apakah Anda yakin ingin memperbarui status permohonan menjadi "${targetStatus}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#146c43',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Ubah',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        innerForm.submit();
                    } else {
                        location.reload();
                    }
                });
            };

            // 3. ACTION HAPUS DATA VIA SWEETALERT2
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const formDelete = this.closest('form');
                    Swal.fire({
                        title: 'Hapus Permohonan?',
                        text: 'Berkas kode #' + this.dataset.title + ' akan dihapus permanen.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => { if (result.isConfirmed) formDelete.submit(); });
                });
            });
        });
    </script>

    {{-- ALERT TOAST NOTIFICATION --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session("success") }}',
                confirmButtonColor: '#146c43'
            });
        </script>
    @endif
@endsection
