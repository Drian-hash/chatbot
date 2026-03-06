@php
    $edit = $edit ?? false;
@endphp

<style>
/* =========================
   MODAL CENTER & SIZE
========================= */
.modal-dialog {
    max-width: 820px;
}

.modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: 100vh;
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
    height: 34px;
    padding: 5px 10px;
    border-radius: 6px;
}

.form-compact .form-group {
    margin-bottom: 14px;
}
</style>

<div class="form-compact">

    <!-- Nama -->
    <div class="form-group">
        <label>Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text"
               name="nama_lengkap"
               class="form-control"
               value="{{ old('nama_lengkap', $edit ? $item->nama_lengkap : '') }}"
               required>
    </div>

    <!-- NIP -->
    <div class="form-group">
        <label>NIP</label>
        <input type="text"
               name="nip"
               class="form-control"
               value="{{ old('nip', $edit ? $item->nip : '') }}">
    </div>

    <!-- OPD -->
    <div class="form-group">
        <label>OPD</label>
        <input type="text"
               name="opd"
               class="form-control"
               value="{{ old('opd', $edit ? $item->opd : '') }}">
    </div>

    <!-- No HP -->
    <div class="form-group">
        <label>No HP</label>
        <input type="text"
               name="no_hp"
               class="form-control"
               value="{{ old('no_hp', $edit ? $item->no_hp : '') }}">
    </div>

    <!-- Jenis Permohonan SELECT -->
    <div class="form-group">
        <label>Jenis Permohonan TTE <span class="text-danger">*</span></label>

        @php
            $selectedJenis = old('jenis_permohonan', $edit ? $item->jenis_permohonan : '');
        @endphp

        <select name="jenis_permohonan"
                class="form-control"
                required>

            <option value="">-- Pilih Layanan --</option>

            <option value="Permohonan TTE Baru (Belum Mempunyai TTE)"
                {{ $selectedJenis == 'Permohonan TTE Baru (Belum Mempunyai TTE)' ? 'selected' : '' }}>
                Permohonan TTE Baru (Belum Mempunyai TTE)
            </option>

            <option value="Lupa Passphrase TTE"
                {{ $selectedJenis == 'Lupa Passphrase TTE' ? 'selected' : '' }}>
                Lupa Passphrase TTE
            </option>

            <option value="Pembaharuan TTE ( TTE Expired)"
                {{ $selectedJenis == 'Pembaharuan TTE ( TTE Expired)' ? 'selected' : '' }}>
                Pembaharuan TTE ( TTE Expired)
            </option>

        </select>
    </div>

</div>
