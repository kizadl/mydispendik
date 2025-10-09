<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$qrilay = ("SELECT layanan FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
mysqli_free_result($dblayanan);

$sqlx = ("SELECT nama,nik,nip,nuptk,nm_sekolah,npsn,no_wa,
			ijazah_s1,nm_pt,prog_studi,no_ijazah,thn_lulus FROM tte_trans_perubahan_ptk WHERE id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$nmkepsek = $sm['nama'];
$nik = $sm['nik'];
$nip = strtoupper($sm['nip']);
$nuptk = strtoupper($sm['nuptk']);
$nmsekolahasal = strtoupper($sm['nm_sekolah']);
$npsnasal = strtoupper($sm['npsn']);
$noWA = $sm['no_wa'];

$ijazahs1 = $sm['ijazah_s1'];
if ($ijazahs1 == "Y") {
    $hidrekom = "";
    $chkrekomval = "checked";
    $namapt = strtoupper($sm['nm_pt']);
    $progstudy = strtoupper($sm['prog_studi']);
    $noijazah = strtoupper($sm['no_ijazah']);
    $thnlulus = $sm['thn_lulus'];
} else if ($ijazahs1 == "N") {
    $hidrekom = "display:none";
    $chkrekomval = "";
    $namapt = "";
    $progstudy = "";
    $noijazah = "";
    $thnlulus = "";
}
mysqli_free_result($restps);
mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data <?php echo $layanan ?></h5>
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

    <input type="text" class="form-control form-control-sm" id="txtidTransaksiPTKE" value="<?php echo $idtransaksi ?>" hidden>
    <input type="text" class="form-control form-control-sm" id="txtidlayananPTKE" value="<?php echo $idlayanan ?>" hidden>

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
                    <input type="text" class="form-control form-control-sm" id="txtnamaPTKE" value="<?php echo $nmkepsek ?>" maxlength="100" placeholder="Nama lengkap" autocomplete="off">
                    <label for="txtnamaPTKE">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtnikPTKE" value="<?php echo $nik ?>" maxlength="20" placeholder="NIK" autocomplete="off">
                    <label for="txtnikPTKE">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnipPTKE" value="<?php echo $nip ?>" maxlength="35" placeholder="NIP" autocomplete="off">
                    <label for="txtnipPTKE">NIP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnuptkPTKE" value="<?php echo $nuptk ?>" maxlength="35" placeholder="NUPTK" autocomplete="off">
                    <label for="txtnuptkPTKE">NUPTK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsekolahasalPTKE" value="<?php echo $nmsekolahasal ?>" maxlength="100" placeholder="Sekolah" autocomplete="off">
                    <label for="txtnmsekolahasalPTKE">Nama Sekolah</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnpsnasalPTKE" value="<?php echo $npsnasal ?>" maxlength="50" placeholder="NPSN" autocomplete="off">
                    <label for="txtnpsnasalPTKE">NPSN</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaPTKE" value="<?php echo $noWA ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaPTKE">No. HP WhatsApp (WA) Aktif</label>
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

            <input type="text" id="lblchkijazahPTKEE" value="<?php echo $ijazahs1 ?>" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkijazahPTKE" type="checkbox" <?php echo $chkrekomval ?> />
                <label class="form-check-label" for="chkijazahPTKE">Ijazah S1 Ke atas</label>
            </div>
            <div id="area-ijazah-ptkE" style="<?php echo $hidrekom ?>">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmuniversitasPTKE" value="<?php echo $namapt ?>" maxlength="50" placeholder="Perguruan tinggi" autocomplete="off">
                    <label for="txtnmuniversitasPTKE">Nama Perguruan Tinggi</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtproGstudyPTKE" value="<?php echo $progstudy ?>" maxlength="50" placeholder="Program study" autocomplete="off">
                    <label for="txtproGstudyPTKE">Program Study</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnoijazahPTKE" value="<?php echo $noijazah ?>" maxlength="50" placeholder="Nomor ijazah" autocomplete="off">
                    <label for="txtnoijazahPTKE">Nomor Ijazah</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="number" class="form-control form-control-sm" id="txtthnlulusPTKE" value="<?php echo $thnlulus ?>" maxlength="4" placeholder="Tahun lulus" autocomplete="off">
                    <label for="txtthnlulusPTKE">Tahun Lulus</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPTKE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $("#chkijazahPTKE").on("change", function() {
        $("#txtnmuniversitasPTKE").val("");
        $("#txtproGstudyPTKE").val("");
        $("#txtnoijazahPTKE").val("");
        $("#txtthnlulusPTKE").val("");
        if ($(this).is(':checked')) {
            $("#lblchkijazahPTKEE").val("Y");
            $("#area-ijazah-ptkE").fadeIn();
        } else {
            $("#lblchkijazahPTKEE").val("N");
            $("#area-ijazah-ptkE").fadeOut("slow");
        }
    });

    $("#cmdsimpanPTKE").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();

        var idlayanan = $("#txtidlayananPTKE").val();
        var idtransaksi = $("#txtidTransaksiPTKE").val();

        var nmkepsek = $("#txtnamaPTKE").val();
        var nik = $("#txtnikPTKE").val();
        var nip = $("#txtnipPTKE").val();
        var nuptk = $("#txtnuptkPTKE").val();
        var sekolahasal = $("#txtnmsekolahasalPTKE").val();
        var npsnasal = $("#txtnpsnasalPTKE").val();
        var noWA = $("#txtnowaPTKE").val();

        var chkijazah = $("#lblchkijazahPTKEE").val();
        var namapt = $("#txtnmuniversitasPTKE").val();
        var progstudy = $("#txtproGstudyPTKE").val();
        var noijazah = $("#txtnoijazahPTKE").val();
        var thnlulusijazah = $("#txtthnlulusPTKE").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);

        data.append('idtransaksi', idtransaksi);
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

        if (idlayanan.length <= 0 || idtransaksi.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmkepsek.length <= 0) {
            $("#txtnamaPTKE").focus();
            alert("Nama pegawai masih kosong")
        } else if (nik.length <= 0) {
            $("#txtnikPTKE").focus();
            alert("NIK masih kosong")
        } else if (nip.length <= 0) {
            $("#txtnipPTKE").focus();
            alert("NIP masih kosong")
        } else if (nuptk.length <= 0) {
            $("#txtnuptkPTKE").focus();
            alert("NUPTK masih kosong")
        } else if (sekolahasal.length <= 0) {
            $("#txtnmsekolahasalPTKE").focus();
            alert("Sekolah asal masih kosong")
        } else if (npsnasal.length <= 0) {
            $("#txtnpsnasalPTKE").focus();
            alert("NPSN sekolah asal masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaPTKE").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (chkijazah == "Y" && namapt == "") {
            $("#txtnmuniversitasPTKE").focus();
            alert("Nama perguruan tinggi masih kosong")
        } else if (chkijazah == "Y" && progstudy == "") {
            $("#txtproGstudyPTKE").focus();
            alert("Program study masih kosong")
        } else if (chkijazah == "Y" && noijazah == "") {
            $("#txtnoijazahPTKE").focus();
            alert("Nomor ijazah masih kosong")
        } else if (chkijazah == "Y" && thnlulusijazah == "") {
            $("#txtthnlulusPTKE").focus();
            alert("Tahun lulus ijazah masih kosong")
        } else {
            var urlnya = "klinik-dapo/trans-layanan/perubahan-ptk/aksi_edit.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanPTKE").attr("disabled", "disabled");
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
                        $("#cmdsimpanPTKE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanPTKE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanPTKE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>