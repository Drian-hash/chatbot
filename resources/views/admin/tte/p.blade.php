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
        height: 32px;
        padding: 3px 10px;
        border-radius: 6px;
    }

    .form-compact .form-group {
        margin-bottom: 12px;
    }

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

    <!-- NAMA -->
    <div class="col-md-6 form-group">

         <label>Nama Lengkap <span class="text-danger">*</span></label>

        <input type="text" name="nama_lengkap" class="form-control shadow-sm"
            value="{{ old('nama_lengkap', $edit ? $item->nama_lengkap : '') }}" required>

    </div>


    <!-- USERNAME -->
    <div class="col-md-6 form-group">

        <label>Username <span class="text-danger">*</span></label>

        <input type="text" name="username" class="form-control shadow-sm"
            value="{{ old('username', $edit ? $user->username : '') }}" required>

    </div>


    <!-- EMAIL -->
    <div class="col-md-6 form-group">

        <label>Email <span class="text-danger">*</span></label>

        <input type="email" name="email" class="form-control shadow-sm"
            value="{{ old('email', $edit ? $user->email : '') }}" required>

    </div>


    <!-- NO HP -->
    <div class="col-md-6 form-group">

        <label>No HP</label>

        <input type="text" name="no_hp" class="form-control shadow-sm"
            value="{{ old('no_hp', $edit ? $user->no_hp : '') }}">

    </div>


    <!-- PASSWORD -->
    <div class="col-md-6 form-group">

        <label>Password {{ $edit ? '' : '*' }}</label>

        <input type="password" name="password" class="form-control shadow-sm" {{ $edit ? '' : 'required' }}>

        @if ($edit)
            <small class="text-muted">
                Kosongkan jika tidak ingin mengubah password
            </small>
        @endif

    </div>


    <!-- STATUS -->
    <div class="col-md-6 form-group">

        <label>Status</label>

        <select name="status" class="form-control shadow-sm">

            <option value="aktif" {{ old('status', $edit ? $user->status : '') == 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="nonaktif" {{ old('status', $edit ? $user->status : '') == 'nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>

        </select>

    </div>


    <!-- FOTO -->
    <div class="col-md-12 form-group">

        <label>Upload Foto</label>

        <div class="upload-box" onclick="document.getElementById('fotoInput{{ $edit ? $user->id : 'new' }}').click()">

            <i class="fas fa-cloud-upload-alt"></i>

            <div class="upload-text">
                Klik atau tarik foto ke sini
            </div>

            <div id="fileName{{ $edit ? $user->id : 'new' }}" class="file-name"></div>

        </div>


        <input type="file" id="fotoInput{{ $edit ? $user->id : 'new' }}" name="foto" accept=".jpg,.jpeg,.png"
            hidden>


        @if ($edit && $user->foto)
            <small class="d-block mt-2">

                Foto saat ini:

                <br>

                <img src="{{ asset('uploads/user/' . $user->foto) }}" width="60"
                    class="rounded-circle border mt-1">

            </small>
        @endif

    </div>


</div>



