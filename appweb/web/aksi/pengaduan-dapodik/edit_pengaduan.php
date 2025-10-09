<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function getBulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

$idtransaksi = trim($_POST['idtransaksi']);

$sqlx = ("SELECT * FROM trans_pengaduan_dapodik p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$waktucreate = tgl_indo($sm['waktu_create']);

$nik = $sm['nik'];
$nama = strtoupper($sm['nama']);
$alamat = $sm['alamat'];
$noorder = strtoupper($sm['no_order']);
$nowa = $sm['no_wa'];

$bentukpendidikan = strtoupper($sm['bentuk_pendidikan']);
$npsn = $sm['npsn'];
$namasekolah = strtoupper($sm['nama_sekolah']);
$uraianmasalah = $sm['uraian_masalah'];

$statusakhir = strtoupper($sm['ket_status_akhir']);

if ($sm['bentuk_pendidikan'] == "PAUD") {
    $namabentuk = "TK / PAUD";
} else if ($sm['bentuk_pendidikan'] == "SD") {
    $namabentuk = "Sekolah Dasar";
} else if ($sm['bentuk_pendidikan'] == "SMP") {
    $namabentuk = "Sekolah Menengah Pertama";
} else if ($sm['bentuk_pendidikan'] == "PNF") {
    $namabentuk = "Pendidikan Non Formal";
}
mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Bukti Pengaduan Dapodik</h5>
        <p class="fs--1 mb-0 text-white">Tanda bukti pengaduan klinik dapodik No. <?php echo $noorder ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="card bg-light border border-200 mb-0">
        <div class="card-body text-900">
            <h5 class="card-title fs-0"><i class="fas fa-info-circle text-primary"></i> Tanda Terima Pengaduan Dapodik</h5>
            <p class="card-text fs--1 mb-2">
                Berikut data pengaduan Anda :
            </p>
            <ul class="fs--1 mb-2">
                <li><span class="fw-semi-bold">NO. <?php echo $noorder ?></span></li>
                <li><?php echo $waktucreate ?></li>
                <li><strong><?php echo $namabentuk ?></strong></li>
                <li><strong><?php echo $npsn ?></strong> - <?php echo $namasekolah ?></li>
            </ul>
            <ul class="fs--1 mb-2">
                <li><?php echo $nik ?></li>
                <li><?php echo $nama ?></li>
                <li><?php echo $alamat ?></li>
                <li>No. HP <code><?php echo $nowa ?></code></li>
                <li>Uraian Masalah:<br>
                    <span class="mb-0 mt-1 me-4">
                        <?php echo $uraianmasalah ?>
                    </span>
                </li>
            </ul>
            <p class="fs--1 mt-4 mb-0">
                ✅ <strong>Tips:</strong><br>
                - Catat No. Order Pengaduan <span class="fs-0 fw-semi-bold text-primary ms-2"><?php echo $noorder ?></span><br>
                - Gunakan nomor order untuk penelusuran <code>(Tracking Status Pengaduan)</code> Anda.<br>
                - Cek berkala <em>Status Pengaduan Anda</em>.
            </p>
        </div>
    </div>
</div>