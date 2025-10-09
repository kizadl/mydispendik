<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idlayanan = trim($_POST['idlayanan']);
$qrilay = ("SELECT layanan FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
mysqli_free_result($dblayanan);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Input Data <?php echo $layanan ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi data <?php echo $layanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong><?php echo $layanan ?></strong></br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                        </br><strong>Catatan :</strong> Password terdiri dari huruf besar kecil, angka dan simbul, minimal 8 karakter.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Operator Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="number" class="form-control form-control-sm" id="txtnpsnAkun" value="" maxlength="20" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsnAkun">NPSN</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtuseremailAkun" value="" maxlength="50" placeholder="User email lembaga" autocomplete="off">
                <label for="txtuseremailAkun">User Email Lembaga</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtpasswordAkun" value="" maxlength="20" placeholder="Password" autocomplete="off">
                <label for="txtpasswordAkun">Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnmoperatorAkun" value="" maxlength="50" placeholder="Nama operator sekolah" autocomplete="off">
                <label for="txtnmoperatorAkun">Nama Operator Sekolah</label>
            </div>

            <div class="form-floating mb-1">
                <input type="number" class="form-control form-control-sm" id="txtnowaAkun" value="" maxlength="25" placeholder="No. WA" autocomplete="off">
                <label for="txtnowaAkun">No. HP WhatsApp (Aktif) Operator Sekolah</label>
            </div>

        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">SK Operator Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnoskoperatorAkun" value="" maxlength="50" placeholder="No. SK Operasional" autocomplete="off">
                <label for="txtnoskoperatorAkun">No. SK Operator</label>
            </div>

            <div class="form-floating mb-1">
                <input class="form-control form-control-sm datetimepicker" id="txttglskoperatorAkun" value="" type="text" placeholder="Tanggal SK Operasional" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglskoperatorAkun">Tanggal SK Operator</label>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanAkunOpt">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnpsnAkun").val("");
        $("#txtuseremailAkun").val("");
        $("#txtpasswordAkun").val("");
        $("#txtnmoperatorAkun").val("");
        $("#txtnowaAkun").val("");
        $("#txtnoskoperatorAkun").val("");
        $("#txttglskoperatorAkun").val("");
    });

    function validasiEmail() {
        var rs = document.getElementById("txtuseremailAkun").value;
        var atps=rs.indexOf("@");
        var dots=rs.lastIndexOf(".");
        if (atps < 1 || dots == rs.length) {
            alert("Alamat email tidak valid.");
            return false;
        }
    }

    $("#cmdsimpanAkunOpt").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var idlayanan = "7";
        
        var rs = document.getElementById("txtuseremailAkun").value;
        var atps=rs.indexOf("@");
        var dots=rs.lastIndexOf(".");

        var npsn = $("#txtnpsnAkun").val();
        var eseremail = $("#txtuseremailAkun").val();
        var passwordx = $("#txtpasswordAkun").val();
        var nmoperator = $("#txtnmoperatorAkun").val();
        var noWA = $("#txtnowaAkun").val();
        var nosk = $("#txtnoskoperatorAkun").val();
        var tglsk = $("#txttglskoperatorAkun").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

        data.append('npsn', npsn);
        data.append('eseremail', eseremail);
        data.append('passwordx', passwordx);
        data.append('nmoperator', nmoperator);
        data.append('noWA', noWA);
        data.append('nosk', nosk);
        data.append('tglsk', tglsk);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (npsn.length <= 0) {
            $("#txtnpsnAkun").focus();
            alert("NPSN masih kosong")
        } else if (eseremail.length <= 0) {
            $("#txtuseremailAkun").focus();
            alert("User email lembaga masih kosong")
        } else if (atps < 1 || dots == rs.length) {
            $("#txtuseremailAkun").focus();
            alert("Alamat email tidak valid.");
        } else if (passwordx.length <= 7) {
            $("#txtpasswordAkun").focus();
            alert("Password tidak valid")
        } else if (nmoperator.length <= 0) {
            $("#txtnmoperatorAkun").focus();
            alert("Operator sekolah masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaAkun").focus();
            alert("No. WA masih kosong")
        } else if (nosk.length <= 0) {
            $("#txtnoskoperatorAkun").focus();
            alert("No. SK operator sekolah masih kosong")
        } else if (tglsk.length <= 0) {
            $("#txttglskoperatorAkun").focus();
            alert("Tanggal SK operator sekolah masih kosong")
        } else {
            validasiEmail()
            var urlnya = "klinik-dapo/trans-layanan/pengajuan-akun-operator/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanAkunOpt").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiPengajuanAkun();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanAkunOpt").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanAkunOpt").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanAkunOpt").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>