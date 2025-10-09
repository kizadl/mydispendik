<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idbidang = trim($_POST['idbidang']);

$qri = ("SELECT nm_bidang,nm_pejabat,jabatan,pangkat,nip,nik FROM tte_m_bidang WHERE id_bidang='" . $idbidang . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmbidang = $c['nm_bidang'];
$nmpejabat = $c['nm_pejabat'];
$jabatan = $c['jabatan'];
$pangkat = $c['pangkat'];
$nip = $c['nip'];
$nik = $c['nik'];
mysqli_free_result($dbquery);
mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data Bidang</h5>
        <p class="fs--1 mb-0 text-white">Silahkan edit data bidang</p>
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

    <input class="form-control" type="text" id="txtidopdE" value="<?php echo $idbidang; ?>" style="display:none;" />

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmopde" value="<?php echo $nmbidang; ?>" placeholder="Nama OPD" maxlength="100" autocomplete="off">
        <label for="txtnmopde">Nama Bidang</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmpejabatopde" value="<?php echo $nmpejabat; ?>" placeholder="Nama Kepala Dinas" maxlength="100" autocomplete="off">
        <label for="txtnmpejabatopde">Nama Kepala Bidang</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtjabatanopde" value="<?php echo $jabatan; ?>" placeholder="Jabatan" maxlength="100" autocomplete="off">
        <label for="txtjabatanopde">Jabatan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtpangkatopde" value="<?php echo $pangkat; ?>" placeholder="Pangkat" maxlength="25" autocomplete="off">
        <label for="txtpangkatopde">Pangkat</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnipopde" value="<?php echo $nip; ?>" placeholder="NIP" maxlength="25" autocomplete="off">
        <label for="txtnipopde">NIP</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnikopde" value="<?php echo $nik; ?>" placeholder="NIK" maxlength="25" autocomplete="off">
        <label for="txtnikopde">NIK</label>
    </div>

    <div class="card bg-light mb-0">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600"><b>Upload Tandatangan</b><br>File tandatangan harus file
                gambar (tandatangan) berextensi .png</p>
            <input class="form-control form-control-sm" id="btnUploadTTDOpdE" type="file" accept=".png" />
        </div>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanOPDE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $('#btnUploadTTDOpdE').bind('change', function() {
        var extensinya = $('#btnUploadTTDOpdE').val().toLowerCase();
        var regex = new RegExp("(.*?)\.(png)$");
        if (!(regex.test(extensinya))) {
            alert("File upload harus file berextensi .png");
            $('#btnUploadTTDOpdE').val(null);
        }
    });

    $("#cmdSimpanOPDE").click(function() {
        var idbidang = $('#txtidopdE').val();
        var nmbidang = $('#txtnmopde').val();
        var nmpejabat = $('#txtnmpejabatopde').val();
        var jabatan = $('#txtjabatanopde').val();
        var pangkat = $('#txtpangkatopde').val();
        var nip = $('#txtnipopde').val();
        var nik = $('#txtnikopde').val();

        var data = new FormData();
        data.append('upTTDKadisE', $("#btnUploadTTDOpdE")[0].files[0]);
        data.append('idbidang', idbidang);
        data.append('nmbidang', nmbidang);
        data.append('nmpejabat', nmpejabat);
        data.append('jabatan', jabatan);
        data.append('pangkat', pangkat);
        data.append('nip', nip);
        data.append('nik', nik);

        if (idbidang.length <= 0) {
            alert('Data bidang tidak terdeteksi')
        } else if (nmbidang.length <= 0) {
            $('#txtnmopde').focus();
            alert('Nama bidang masih kosong')
        } else if (nmpejabat.length <= 0) {
            $('#txtnmpejabatopde').focus();
            alert('Nama kepala bidang masih kosong')
        } else if (jabatan.length <= 0) {
            $('#txtjabatanopde').focus();
            alert('Jabatan masih kosong')
        } else if (pangkat.length <= 0) {
            $('#txtpangkatopde').focus();
            alert('Pangkat masih kosong')
        } else if (nip.length <= 0) {
            $('#txtnipopde').focus();
            alert('NIP masih kosong')
        } else if (nik.length <= 0) {
            $('#txtnikopde').focus();
            alert('NIK masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/bidang/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanOPDE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterBidang();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanOPDE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanOPDE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanOPDE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>