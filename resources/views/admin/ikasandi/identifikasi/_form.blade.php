@php
    $edit = $edit ?? false;
@endphp

<style>
.modal-dialog { max-width: 680px; }
.modal-header { padding: 14px 20px; }
.modal-body { padding: 18px 22px; }
.modal-footer { padding: 12px 20px; }

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

    <!-- KATEGORI -->
    <div class="col-md-6 form-group">
        <label>Kategori <span class="text-danger">*</span></label>

        <select name="kategori_id"
                class="form-control shadow-sm"
                required>

            @foreach($kategoriList as $k)

                <option value="{{ $k->id }}"
                    {{ old('kategori_id', $edit ? $item->kategori_id : '') == $k->id ? 'selected' : '' }}>

                    {{ $k->kode_kategori }}

                </option>

            @endforeach

        </select>
    </div>

    <!-- KODE SOAL -->
    <div class="col-md-6 form-group">

        <label>Kode Soal <span class="text-danger">*</span></label>

        <input type="text"
               name="kode_soal"
               class="form-control shadow-sm"
               value="{{ old('kode_soal', $edit ? $item->kode_soal : '') }}"
               required>

    </div>

    <!-- PERTANYAAN -->
    <div class="col-md-12 form-group">

        <label>Pertanyaan <span class="text-danger">*</span></label>

        <textarea name="pertanyaan"
                  class="form-control shadow-sm"
                  required>{{ old('pertanyaan', $edit ? $item->pertanyaan : '') }}</textarea>

    </div>

    <!-- NILAI -->
    <div class="col-md-6 form-group">

        <label>Nilai <span class="text-danger">*</span></label>

        <select name="nilai"
                class="form-control shadow-sm"
                id="nilaiSelect{{ $item->id }}"
                required>

            @for($i=0;$i<=5;$i++)

                <option value="{{ $i }}"
                    {{ old('nilai', $edit ? $item->nilai : 0) == $i ? 'selected' : '' }}>

                    {{ $i }}

                </option>

            @endfor

        </select>

    </div>

    <!-- KETERANGAN NILAI -->
    <div class="col-md-6 form-group">

        <label>Keterangan Indeks</label>

        <input type="text"
               id="keteranganNilai{{ $item->id }}"
               class="form-control shadow-sm"
               readonly>

    </div>

    <!-- UPLOAD BUKTI -->
    <div class="col-md-12 form-group">

        <label>Upload Bukti Dukung (PDF / JPG / PNG)</label>

        <div class="upload-box"
             id="uploadBox{{ $item->id }}"
             onclick="document.getElementById('buktiInput{{ $item->id }}').click()">

            <i class="fas fa-cloud-upload-alt"></i>

            <div class="upload-text">
                Klik atau tarik file ke sini
            </div>

            <div id="fileName{{ $item->id }}" class="file-name"></div>

        </div>

        <input type="file"
               id="buktiInput{{ $item->id }}"
               name="bukti_dukung"
               accept=".pdf,.jpg,.jpeg,.png"
               hidden>

        @if($edit && $item->bukti_dukung)

            <small class="d-block mt-2">

                File saat ini:

                <a href="{{ asset('storage/'.$item->bukti_dukung) }}"
                   target="_blank"
                   class="text-primary font-weight-bold">

                    Lihat File

                </a>

            </small>

        @endif

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const nilaiSelect = document.getElementById("nilaiSelect{{ $item->id }}");
    const keteranganInput = document.getElementById("keteranganNilai{{ $item->id }}");

    const keteranganMap = {

        0: "Belum ada penerapan kontrol",
        1: "Masih tahap perencanaan",
        2: "Sudah dirancang tapi belum lengkap",
        3: "Sudah diterapkan sebagian",
        4: "Sudah diterapkan konsisten",
        5: "Sudah optimal & dilakukan evaluasi"

    };

    function updateKeterangan(){

        keteranganInput.value = keteranganMap[nilaiSelect.value] || "";

    }

    nilaiSelect.addEventListener("change", updateKeterangan);

    updateKeterangan();


    const uploadBox = document.getElementById("uploadBox{{ $item->id }}");
    const fileInput = document.getElementById("buktiInput{{ $item->id }}");
    const fileName = document.getElementById("fileName{{ $item->id }}");


    uploadBox.addEventListener("dragover", function(e){

        e.preventDefault();

        uploadBox.style.borderColor = "#5dd5f9";
        uploadBox.style.background = "#eef9ff";

    });


    uploadBox.addEventListener("dragleave", function(){

        uploadBox.style.borderColor = "#b8c2cc";
        uploadBox.style.background = "#f8fafc";

    });


    uploadBox.addEventListener("drop", function(e){

        e.preventDefault();

        fileInput.files = e.dataTransfer.files;

        showFileName();

    });


    fileInput.addEventListener("change", showFileName);


    function showFileName(){

        if(fileInput.files.length > 0){

            fileName.innerText = "File dipilih: " + fileInput.files[0].name;

        }

    }

});

</script>
