<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idsekolah = trim($_POST['idsekolah']);
$idbidang = trim($_POST['idbidang']);
$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['layanan']);
$nosurat = trim($_POST['nosurat']);

$namasiswa = strtoupper(trim($_POST['namasiswa']));
$kelas = strtoupper(trim($_POST['kelas']));
$asalsekolah = strtoupper(trim($_POST['asalsekolah']));
$mutasike = strtoupper(trim($_POST['mutasike']));
$alasanmutasi = ucwords(strtolower(trim($_POST['alasanmutasi'])));

$ketlevel = trim($_POST['ketlevel']);
$sttsoptdapodik = trim($_POST['sttsoptdapodik']);
if ($sttsoptdapodik == "belum") {
    $pengiriman = "Baru";
} else if ($sttsoptdapodik == "terkirim") {
    $pengiriman = "Kirim Ulang";
}
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white fs-0">Teruskan Rekomendasi <?php echo $nmlayanan ?></h5>
        <p class="fs--1 mb-0 text-white">Meneruskan data rekomendasi <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body align-items-center">
                    <p class="fs--1 mt-0 mb-2">
                        <strong><?php echo $namasiswa ?><br />Kelas : <?php echo $kelas ?></strong><br /><br />
                        <?php echo $asalsekolah ?> <?php echo $nmlayanan ?> Ke <?php echo $mutasike ?> <br>
                        <strong>Alasan :</strong> <?php echo $alasanmutasi ?>
                    </p>
                    <p class="fs--1 mt-0 mb-0">
                        Tekan tombol <strong>Teruskan Rekomendasi</strong> untuk menerima atau meneruskan surat rekomendasi</br>
                        Status pengiriman : <strong><?php echo $pengiriman ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidsuratKirim" value="<?php echo $idtransaksi ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidlayananKirim" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransidinstansiKirim" value="<?php echo $idsekolah ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransketlevelsuratKirim" value="<?php echo $ketlevel ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txtstatusaksiOperatorKirim" value="<?php echo $sttsoptdapodik ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttransnosuratKirim" value="<?php echo $nosurat ?>" readonly="readonly" style="display:none" />

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-success me-3" type="button" id="cmdTeruskanSurat">Teruskan rekomendasi</button>
</div>

<script type="text/javascript" charset="utf-8">
 
    $("#cmdTeruskanSurat").click(function() {
        
        var idoperator = $('#lbleditor').val();
        var namaoperator = $('#lblnamaeditor').val();
        var idsekolah = $('#txttransidinstansiKirim').val();
        var idtransaksi = $('#txttransidsuratKirim').val();
        var idlayanan = $('#txttransidlayananKirim').val();
        var leveloperator = $('#lblnamalevel').val();
        var leveltransaksi = $('#txttransketlevelsuratKirim').val();
        var statusaksioperator = $('#txtstatusaksiOperatorKirim').val();
 
        var levelnext = "operator dapodik";
        var levelprev = "operator sekolah";
        
        var nosurat = $('#txttransnosuratKirim').val();

        var data = new FormData();
        data.append('idoperator', idoperator);
        data.append('namaoperator', namaoperator);
        data.append('idsekolah', idsekolah);
        data.append('idtransaksi', idtransaksi);
        data.append('idlayanan', idlayanan);
        data.append('leveltransaksi', leveltransaksi);
        data.append('leveloperator', leveloperator);
        data.append('statusaksioperator', statusaksioperator);

        data.append('levelnext', levelnext);
        data.append('levelprev', levelprev);

        data.append('nosurat', nosurat);

        if (idsekolah.length <= 0) {
            alert('Data sekolah tidak terdeteksi')
        } else if (idtransaksi.length <= 0) {
            alert('Data mutasi tidak terdeteksi')
        } else {
            $.ajax({
                type: "POST",
                url: "klinik-dapo/trans-layanan/mutasi-siswa/aksi_kirim.php",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#loading").fadeIn();
                    document.body.style.cursor = "wait";
                },
                success: function(resp) {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    setTimeout(function() {
                        $('#modBebasData').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiMutasiSiswa();
                    isiNotifikasiStatus();
                },
                error: function() {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    alert('Koneksi bermasalah periksa internet');
                },
            });

        };

    });
</script>