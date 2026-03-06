@php
    $edit = $edit ?? false;
@endphp

<style>
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
</style>

<div class="row form-compact">

    <!-- Kode Kategori -->
    <div class="col-md-6 form-group">
        <label>Kode Kategori <span class="text-danger">*</span></label>
        <input type="text"
               name="kode_kategori"
               class="form-control shadow-sm"
               placeholder="Contoh: 1.1"
               value="{{ old('kode_kategori', $edit ? $item->kode_kategori : '') }}"
               required>
    </div>

    <!-- Status Aktif -->
    <div class="col-md-6 form-group d-flex align-items-end">
        <div class="form-check mt-2">
            <input type="checkbox"
                   name="is_active"
                   class="form-check-input"
                   {{ old('is_active', $edit ? $item->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label">
                Aktif
            </label>
        </div>
    </div>

    <!-- Keterangan -->
    <div class="col-md-12 form-group">
        <label>Keterangan <span class="text-danger">*</span></label>
        <textarea name="keterangan"
                  rows="3"
                  class="form-control shadow-sm"
                  required>{{ old('keterangan', $edit ? $item->keterangan : '') }}</textarea>
    </div>

</div>
