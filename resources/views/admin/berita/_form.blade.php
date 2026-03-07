@php
    $edit = $edit ?? false;
@endphp

<style>
    /* =========================
    MODAL SIZE (POPUP LEBIH KECIL)
    ========================= */
    .modal-dialog {
        max-width: 680px;
    }

    .modal-header {
        padding: 14px 20px;
    }

    .modal-body {
        padding: 18px 22px;
    }

    .modal-footer {
        padding: 12px 20px;
    }

    /* =========================
    FORM STYLE
    ========================= */

    .form-compact label {
        font-size: 13.5px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #495057;
    }

    .form-compact .form-control {
        font-size: 14px;
        height: 30px;
        padding: 3px 10px;
        border-radius: 6px;
    }

    .form-compact textarea.form-control {
        height: auto;
        min-height: 65px;
    }

    .form-compact .form-group {
        margin-bottom: 10px;
    }

    /* =========================
    UPLOAD BOX MODERN
    ========================= */

    .upload-box {
        border: 1.5px dashed #b8c2cc;
        border-radius: 8px;
        padding: 14px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .upload-box:hover {
        border-color: #5dd5f9;
        background: #eef9ff;
    }

    .upload-box i {
        font-size: 24px;
        color: #5dd5f9;
        margin-bottom: 6px;
    }

    .upload-text {
        font-size: 14px;
        color: #6c757d;
    }

    .file-name {
        font-size: 13px;
        margin-top: 8px;
        color: #28a745;
        font-weight: 500;
    }
</style>

<div class="row form-compact">

    <!-- Kode -->
    <div class="col-md-6 form-group">
        <label>Kode <span class="text-danger">*</span></label>
        <input type="text" name="kode" class="form-control shadow-sm"
            value="{{ old('kode', $edit ? $item->kode : '') }}" required>
    </div>

    <!-- Nomor Surat -->
    <div class="col-md-6 form-group">
        <label>Nomor Surat <span class="text-danger">*</span></label>
        <input type="text" name="nomor_surat" class="form-control shadow-sm"
            value="{{ old('nomor_surat', $edit ? $item->nomor_surat : '') }}" required>
    </div>

    <!-- Tujuan -->
    <div class="col-md-6 form-group">
        <label>Tujuan Surat <span class="text-danger">*</span></label>
        <input type="text" name="tujuan_surat" class="form-control shadow-sm"
            value="{{ old('tujuan_surat', $edit ? $item->tujuan_surat : '') }}" required>
    </div>

    <!-- Tanggal -->
    <div class="col-md-6 form-group">
        <label>Tanggal Surat <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_surat" class="form-control shadow-sm"
            value="{{ old('tanggal_surat', $edit ? $item->tanggal_surat : '') }}" required>
    </div>

    <!-- Isi Ringkas -->
    <div class="col-md-12 form-group">
        <label>Isi Ringkas <span class="text-danger">*</span></label>
        <textarea name="isi_ringkas" rows="3" class="form-control shadow-sm" required>{{ old('isi_ringkas', $edit ? $item->isi_ringkas : '') }}</textarea>
    </div>

    <!-- Keterangan -->
    <div class="col-md-12 form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" rows="2" class="form-control shadow-sm">{{ old('keterangan', $edit ? $item->keterangan : '') }}</textarea>
    </div>

    <!-- Upload Bukti -->
    <div class="col-md-12 form-group">
        <label>Upload Bukti (PDF / JPG / PNG)</label>

        <div class="upload-box" onclick="document.getElementById('buktiInput').click()">
            <i class="fas fa-cloud-upload-alt"></i>
            <div class="upload-text">
                Klik atau tarik file ke sini
            </div>
            <div id="fileName" class="file-name"></div>
        </div>

        <input type="file" id="buktiInput" name="bukti_surat" accept=".pdf,.jpg,.jpeg,.png" hidden>

        @if ($edit && $item->bukti_url)
            <small class="d-block mt-2">
                File saat ini:
                <a href="{{ $item->bukti_url }}" target="_blank" class="text-primary font-weight-bold">
                    Lihat File
                </a>
            </small>
        @endif
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const uploadBox = document.querySelector(".upload-box");
        const fileInput = document.getElementById("buktiInput");
        const fileName = document.getElementById("fileName");

        uploadBox.addEventListener("dragover", function(e) {
            e.preventDefault();
            uploadBox.style.borderColor = "#5dd5f9";
            uploadBox.style.background = "#e6f7ff";
        });

        uploadBox.addEventListener("dragleave", function() {
            uploadBox.style.borderColor = "#b8c2cc";
            uploadBox.style.background = "#f8fafc";
        });

        uploadBox.addEventListener("drop", function(e) {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            showFileName();
        });

        fileInput.addEventListener("change", showFileName);

        function showFileName() {
            if (fileInput.files.length > 0) {
                fileName.innerText = "File dipilih: " + fileInput.files[0].name;
            }
        }

    });
</script>
