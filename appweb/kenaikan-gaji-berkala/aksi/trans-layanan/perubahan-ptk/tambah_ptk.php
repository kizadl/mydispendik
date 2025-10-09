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
mysqli_close($dbconn);
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
                        Isi dan lengkapi form isian data <strong><?php echo $layanan ?></strong>
                        (Data Pegawai dan Data Ijazah).</br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Pegawai</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnamaPTK" value="" maxlength="100" placeholder="Nama lengkap" autocomplete="off">
                    <label for="txtnamaPTK">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtnikPTK" value="" maxlength="20" placeholder="NIK" autocomplete="off">
                    <label for="txtnikPTK">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnipPTK" value="" maxlength="35" placeholder="NIP" autocomplete="off">
                    <label for="txtnipPTK">NIP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnuptkPTK" value="" maxlength="35" placeholder="NUPTK" autocomplete="off">
                    <label for="txtnuptkPTK">NUPTK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsekolahasalPTK" value="" maxlength="100" placeholder="Sekolah" autocomplete="off">
                    <label for="txtnmsekolahasalPTK">Nama Sekolah</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnpsnasalPTK" value="" maxlength="50" placeholder="NPSN" autocomplete="off">
                    <label for="txtnpsnasalPTK">NPSN</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaPTK" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaPTK">No. HP WhatsApp (WA) Aktif</label>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Ijazah S1 Keatas <code>(** Opsional ** Tidak Wajib hanya untuk yang ijazah S1 Ke atas **)</code></h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <input type="text" id="lblchkIjazahPTK" value="" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkijazahKS" type="checkbox" />
                <label class="form-check-label" for="chkijazahKS">Ijazah S1 Ke atas</label>
            </div>
            <div id="area-ijazah-ganti-kepsek" style="display:none">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmuniversitasPTK" value="" maxlength="50" placeholder="Perguruan tinggi" autocomplete="off">
                    <label for="txtnmuniversitasPTK">Nama Perguruan Tinggi</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtproGstudyPTK" value="" maxlength="50" placeholder="Program study" autocomplete="off">
                    <label for="txtproGstudyPTK">Program Study</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnoijazahPTK" value="" maxlength="50" placeholder="Nomor ijazah" autocomplete="off">
                    <label for="txtnoijazahPTK">Nomor Ijazah</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="number" class="form-control form-control-sm" id="txtthnlulusPTK" value="" maxlength="4" placeholder="Tahun lulus" autocomplete="off">
                    <label for="txtthnlulusPTK">Tahun Lulus</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPTK">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        $("#txtnamaPTK").val("");
        $("#txtnikPTK").val("");
        $("#txtnipPTK").val("");
        $("#txtnuptkPTK").val("");
        $("#txtnmsekolahasalPTK").val("");
        $("#txtnpsnasalPTK").val("");
        $("#txtnowaPTK").val("");

        $("#lblchkIjazahPTK").val("N");
        $("#txtnmuniversitasPTK").val("");
        $("#txtproGstudyPTK").val("");
        $("#txtnoijazahPTK").val("");
        $("#txtthnlulusPTK").val("");
    });

    $("#chkijazahKS").on("change", function() {
        $("#txtnmuniversitasPTK").val("");
        $("#txtproGstudyPTK").val("");
        $("#txtnoijazahPTK").val("");
        $("#txtthnlulusPTK").val("");
        if ($(this).is(':checked')) {
            $("#lblchkIjazahPTK").val("Y");
            $("#area-ijazah-ganti-kepsek").fadeIn();
        } else {
            $("#lblchkIjazahPTK").val("N");
            $("#area-ijazah-ganti-kepsek").fadeOut("slow");
        }
    });

    $("#cmdsimpanPTK").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
        var idlayanan = "5";

        var nmkepsek = $("#txtnamaPTK").val();
        var nik = $("#txtnikPTK").val();
        var nip = $("#txtnipPTK").val();
        var nuptk = $("#txtnuptkPTK").val();
        var sekolahasal = $("#txtnmsekolahasalPTK").val();
        var npsnasal = $("#txtnpsnasalPTK").val();
        var noWA = $("#txtnowaPTK").val();

        var chkijazah = $("#lblchkIjazahPTK").val();
        var namapt = $("#txtnmuniversitasPTK").val();
        var progstudy = $("#txtproGstudyPTK").val();
        var noijazah = $("#txtnoijazahPTK").val();
        var thnlulusijazah = $("#txtthnlulusPTK").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

        data.append('nmkepsek', nmkepsek);
        data.append('nik', nik);
        data.append('nip', nip);
        data.append('nuptk', nuptk);
        data.append('sekolahasal', sekolahasal);
        data.append('npsnasal', npsnasal);
        data.append('noWA', noWA);

        data.append('chkijazah', chkijazah);
        data.append('namapt', namapt);
        data.append('progstudy', progstudy);
        data.append('noijazah', noijazah);
        data.append('thnlulusijazah', thnlulusijazah);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmkepsek.length <= 0) {
            $("#txtnamaPTK").focus();
            alert("Nama pegawai masih kosong")
        } else if (nik.length <= 0) {
            $("#txtnikPTK").focus();
            alert("NIK masih kosong")
        } else if (nip.length <= 0) {
            $("#txtnipPTK").focus();
            alert("NIP masih kosong")
        } else if (nuptk.length <= 0) {
            $("#txtnuptkPTK").focus();
            alert("NUPTK masih kosong")
        } else if (sekolahasal.length <= 0) {
            $("#txtnmsekolahasalPTK").focus();
            alert("Sekolah asal masih kosong")
        } else if (npsnasal.length <= 0) {
            $("#txtnpsnasalPTK").focus();
            alert("NPSN sekolah asal masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaPTK").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (chkijazah == "Y" && namapt == "") {
            $("#txtnmuniversitasPTK").focus();
            alert("Nama perguruan tinggi masih kosong")
        } else if (chkijazah == "Y" && progstudy == "") {
            $("#txtproGstudyPTK").focus();
            alert("Program study masih kosong")
        } else if (chkijazah == "Y" && noijazah == "") {
            $("#txtnoijazahPTK").focus();
            alert("Nomor ijazah masih kosong")
        } else if (chkijazah == "Y" && thnlulusijazah == "") {
            $("#txtthnlulusPTK").focus();
            alert("Tahun lulus ijazah masih kosong")
        } else {
            var urlnya = "aksi/trans-layanan/perubahan-ptk/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanPTK").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiPerubahanJenisPTK();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanPTK").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanPTK").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanPTK").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>