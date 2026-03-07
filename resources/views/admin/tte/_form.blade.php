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

    .form-compact textarea.form-control {
        height: auto;
        min-height: 70px;
    }

    .form-compact .form-group {
        margin-bottom: 12px;
    }
</style>


<div class="row form-compact">


    <!-- NAMA -->
    <div class="col-md-6 form-group">

        <label>Nama Lengkap <span class="text-danger">*</span></label>

        <input type="text" name="nama_lengkap" class="form-control shadow-sm"
            value="{{ old('nama_lengkap', $edit ? $item->nama_lengkap : '') }}" required>

    </div>



    <!-- NIP -->
    <div class="col-md-6 form-group">

        <label>NIP</label>

        <input type="text" name="nip" class="form-control shadow-sm"
            value="{{ old('nip', $edit ? $item->nip : '') }}">

    </div>



    <!-- OPD -->
    <div class="col-md-6 form-group">

        <label>OPD</label>

        <input type="text" name="opd" class="form-control shadow-sm"
            value="{{ old('opd', $edit ? $item->opd : '') }}">

    </div>



    <!-- NO HP -->
    <div class="col-md-6 form-group">

        <label>No HP</label>

        <input type="text" name="no_hp" class="form-control shadow-sm"
            value="{{ old('no_hp', $edit ? $item->no_hp : '') }}">

    </div>



    <!-- JENIS PERMOHONAN -->
    <div class="col-md-12 form-group">

        <label>Jenis Permohonan TTE <span class="text-danger">*</span></label>

        @php
            $selectedJenis = old('jenis_permohonan', $edit ? $item->jenis_permohonan : '');
        @endphp


        <select name="jenis_permohonan" class="form-control shadow-sm" required>

            <option value="">-- Pilih Layanan --</option>

            <option value="Permohonan TTE Baru (Belum Mempunyai TTE)"
                {{ $selectedJenis == 'Permohonan TTE Baru (Belum Mempunyai TTE)' ? 'selected' : '' }}>
                Permohonan TTE Baru (Belum Mempunyai TTE)
            </option>

            <option value="Lupa Passphrase TTE" {{ $selectedJenis == 'Lupa Passphrase TTE' ? 'selected' : '' }}>
                Lupa Passphrase TTE
            </option>

            <option value="Pembaharuan TTE ( TTE Expired)"
                {{ $selectedJenis == 'Pembaharuan TTE ( TTE Expired)' ? 'selected' : '' }}>
                Pembaharuan TTE (TTE Expired)
            </option>

        </select>

    </div>


</div>
