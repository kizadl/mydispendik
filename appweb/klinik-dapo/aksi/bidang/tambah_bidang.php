<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Tambah Data Bidang</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data bidang</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Bidang</strong> dibawah ini.<br />
                        Isi data <strong>NIK</strong> dengan benar. Data NIK akan ditetapkan sebagai <strong>Username dan Password</strong>.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmopd" value="" placeholder="Nama bidang" maxlength="100" autocomplete="off">
        <label for="txtnmopd">Nama Bidang</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmkadisopd" value="" placeholder="Nama Kepala bidang" maxlength="100" autocomplete="off">
        <label for="txtnmkadisopd">Nama Kepala Bidang</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtjabatanopd" value="" placeholder="Jabatan" maxlength="100" autocomplete="off">
        <label for="txtjabatanopd">Jabatan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtpangkatopd" value="" placeholder="Pangkat" maxlength="25" autocomplete="off">
        <label for="txtpangkatopd">Pangkat</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnipopd" value="" placeholder="NIP" maxlength="25" autocomplete="off">
        <label for="txtnipopd">NIP</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnikopd" value="" placeholder="NIK" maxlength="25" autocomplete="off">
        <label for="txtnikopd">NIK</label>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600"><b>Upload Tandatangan</b><br>File tandatangan harus file
                gambar (tandatangan) berextensi .png</p>
            <input class="form-control form-control-sm" id="btnUploadTTDOpd" type="file" accept=".png" />
        </div>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanOPD">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnmopd").val("");
        $("#txtnmkadisopd").val("");
        $("#txtjabatanopd").val("");
        $("#txtpangkatopd").val("");
        $("#txtnipopd").val("");
        $("#txtnikopd").val("");
    });

    $('#btnUploadTTDOpd').bind('change', function() {
        var extensinya = $('#btnUploadTTDOpd').val().toLowerCase();
        var regex = new RegExp("(.*?)\.(png)$");
        if (!(regex.test(extensinya))) {
            alert("File upload harus file berextensi .png");
            $('#btnUploadTTDOpd').val(null);
        }
    });

    $("#cmdSimpanOPD").click(function() {
        var nmbidang = $('#txtnmopd').val();
        var nmpejabat = $('#txtnmkadisopd').val();
        var jabatan = $('#txtjabatanopd').val();
        var pangkat = $('#txtpangkatopd').val();
        var nip = $('#txtnipopd').val();
        var nik = $('#txtnikopd').val();

        var data = new FormData();
        data.append('upTTDKadis', $("#btnUploadTTDOpd")[0].files[0]);
        data.append('nmbidang', nmbidang);
        data.append('nmpejabat', nmpejabat);
        data.append('jabatan', jabatan);
        data.append('pangkat', pangkat);
        data.append('nip', nip);
        data.append('nik', nik);

        if (nmbidang.length <= 0) {
            $('#txtnmopd').focus();
            alert('Nama bidang masih kosong')
        } else if (nmpejabat.length <= 0) {
            $('#txtnmkadisopd').focus();
            alert('Nama kepala bidang masih kosong')
        } else if (jabatan.length <= 0) {
            $('#txtjabatanopd').focus();
            alert('Jabatan masih kosong')
        } else if (pangkat.length <= 0) {
            $('#txtpangkatopd').focus();
            alert('Pangkat masih kosong')
        } else if (nip.length <= 0) {
            $('#txtnipopd').focus();
            alert('NIP masih kosong')
        } else if (nik.length <= 0) {
            $('#txtnikopd').focus();
            alert('NIK masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/bidang/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanOPD").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterBidang();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanOPD").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanOPD").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanOPD").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>