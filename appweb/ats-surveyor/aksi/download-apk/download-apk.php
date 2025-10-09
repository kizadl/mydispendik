<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "../../../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');

$qricbg = ("SELECT versi_apk,tgl_rilis FROM m_versi_apk WHERE id_versi='1'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$versiapk = ucwords(strtolower($c['versi_apk']));
$tglrilis = tgl_indo($c['tgl_rilis']);
mysqli_free_result($dbcabang); mysqli_close($dbconn);
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Download APK <?php echo $versiapk ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan download apk <?php echo $versiapk ?> rilis update <?php echo $tglrilis ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Baca petunjuk instalasi apk <strong><?php echo $versiapk ?> rilis update <?php echo $tglrilis ?></strong>
                        dibawah ini<br />
                        Tombol <strong>Download Apk <?php echo $versiapk ?></strong>  untuk mendownload apk.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="lblversiapk" value="<?php echo $versiapk; ?>" readonly="readonly" hidden />

    <img class="img-fluid rounded mb-3" src="../../../data-apk/<?php echo $versiapk ?>.jpg" alt="" />
 
    <div class="d-grid gap-2 mb-2">
        <button class="btn btn-info rounded-pill me-1 mb-1" type="button" id="cmdDownloadApkClient">Download Apk <?php echo $versiapk ?></button>
    </div>

</div>

<script>

    $("#cmdDownloadApkClient").click(function() {
        var versiapk = $("#lblversiapk").val();
        var urlnya = "../../../data-apk/"+versiapk+".rar";
        window.open(urlnya , '_blank');
    });

</script>