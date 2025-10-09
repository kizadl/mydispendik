<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Tambah Data Pengaduan Dapodik</h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi data pengaduan dapodik</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-2 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        📢 Isi dan lengkapi data isian <strong>Pengaduan Dapodik</strong> <i>NIK, Nama Lengkap, Alamat, No. HP/WA, Bentuk Pendidikan, Uraian Masalah dan Upload File (*.pdf)</i><br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-body px-3 py-3 mb-0">

            <div class="form-floating mb-3 mt-2">
                <input type="text" class="form-control form-control-sm" id="txtnikdapo" value="" maxlength="16" placeholder="NIK" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <label for="txtnikdapo">NIK</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnamalengkapdapo" value="" maxlength="50" placeholder="Nama Lengkap" autocomplete="off">
                <label for="txtnamalengkapdapo">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtalamatdapo" value="" maxlength="200" placeholder="Alamat" autocomplete="off">
                <label for="txtalamatdapo">Alamat</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnowadapo" value="" maxlength="20" placeholder="No. WA" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <label for="txtnowadapo">No. HP WhatsApp (Aktif)</label>
            </div>

            <div class="form-floating mb-0">
                <select class="form-select form-select-sm js-choice px-3" id="cbobentukpendidikandapo" size="1" required="required"
                    data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Bentuk Pendidikan</option>
                    <option value="PAUD">PAUD</option>
                    <option value="SD">Sekolah Dasar</option>
                    <option value="SMP">Sekolah Menengah Pertama</option>
                    <option value="PNF">Pendidikan Non Formal</option>
                </select>
                <label for="cbobentukpendidikandapo">Bentuk Pendidikan</label>
            </div>

        </div>
    </div>

    <div class="row mb-2">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body align-items-center">
                    <div class="mb-0 mt-0">
                        <label for="txtmasalahdapo">Uraian Masalah</label>
                        <textarea class="form-control form-control-sm fs--1" id="txtmasalahdapo" placeholder="Uraian Masalah" style="height: 80px"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header">
            <h5 class="mb-0 fs--1">Upload File</h5>
        </div>
        <div class="card-body bg-light">
            <input class="form-control form-control-sm mb-0 mt-0" type="file" id="btnUploadDapo" accept=".pdf" required />
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPengaduanDapo">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnikdapo").val("");
        $("#txtnamalengkapdapo").val("");
        $("#txtalamatdapo").val("");
        $("#txtnowadapo").val("");
        $("#cbobentukpendidikandapo").val("");
        $("#txtmasalahdapo").val("");
    });

    $('#btnUploadDapo').on('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                showError('🔴 Hanya PDF yang diperbolehkan');
                this.value = '';
            } else if (file.size > 30 * 1024 * 1024) { // misal batas 5MB
                showError('🔴 Ukuran file maksimum 30 MB');
                this.value = '';
            }
        }
    });

    $("#cmdsimpanPengaduanDapo").click(function() {
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();  
        var namasekolah = $("#lblnminstansi").val();
        var npsn = $("#llnpsnsekolah").val();

        var nik = $("#txtnikdapo").val();
        var nama = $("#txtnamalengkapdapo").val();
        var alamat = $("#txtalamatdapo").val();
        var noWA = $("#txtnowadapo").val();
        var bentukpendidikan = $("#cbobentukpendidikandapo").val();
        var masalah = $("#txtmasalahdapo").val();

        if (idinstansi.length <= 0) {
            return showError("🔴 Data sekolah masih kosong");
        } else if (nik.length <= 15) {
            $("#txtnikdapo").focus();
            return showError("🔴 Data NIK tidak valid !!");
        } else if (nama.length <= 0) {
            $("#txtnamalengkapdapo").focus();
            return showError("🔴 Data nama masih kosong !!");
        } else if (alamat.length <= 0) {
            $("#txtalamatdapo").focus();
            return showError("🔴 Data alamat masih kosong !!");
        } else if (noWA.length <= 8) {
            $("#txtnowadapo").focus();
            return showError("🔴 Data No. WA tidak valid !!");
        } else if (bentukpendidikan.length <= 0) {
            $("#cbobentukpendidikandapo").focus();
            return showError("🔴 Bentuk pendidikan masih kosong");
        } else if (masalah.length <= 0) {
            $("#txtmasalahdapo").focus();
            return showError("🔴 Uraian masalah masih kosong");
        }

        var fileInput = $("#btnUploadDapo")[0];
        if (!fileInput.files.length) {
            return showError("🔴 Pilih file PDF terlebih dahulu");
        }
        var file = fileInput.files[0];
        if (file.type !== "application/pdf") {
            return showError("🔴 Format yang diizinkan hanya PDF");
        }
        if (file.size > 30 * 1024 * 1024) {
            return showError("🔴 Maksimum ukuran file 30 MB");
        }

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var data = new FormData();
        data.append("csrfToken", csrfToken);

        data.append("upPengaduan", file);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('namasekolah', namasekolah);
        data.append('npsn', npsn);

        data.append('nik', nik);
        data.append('nama', nama);
        data.append('alamat', alamat);
        data.append('noWA', noWA);
        data.append('bentukpendidikan', bentukpendidikan);
        data.append('masalah', masalah);

        var urlnya = "klinik-dapo/trans-layanan/pengaduan-dapodik/aksi_tambah.php";
        $.ajax({
            type: "POST",
            url: urlnya,
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#cmdsimpanPengaduanDapo").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.new_token) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', resp.new_token);
                }
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modEditDataLarge').modal('hide');
                    }, 1000);
                    showSuccess("🟢 Proses penyimpanan data berhasil");
                    isiPengaduanDapodik();
                } else if (resp.msg2 == 'err_val') {
                    showError("🔴 Tidak lengkap! Proses simpan tidak berhasil\n" + resp.msg1);
                    $("#cmdsimpanPengaduanDapo").removeAttr("disabled");
                } else {
                    showError("🔴 Gagal !! Proses simpan tidak berhasil");
                    $("#cmdsimpanPengaduanDapo").removeAttr("disabled");
                }
            },
            error: function() {
                showError('❌ Koneksi bermasalah periksa internet');
                $("#cmdsimpanPengaduanDapo").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    });
</script>