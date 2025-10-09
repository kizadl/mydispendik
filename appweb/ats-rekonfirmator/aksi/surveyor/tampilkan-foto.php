<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsiswa = trim($_POST['idsiswa']);
$idsurveyor = trim($_POST['idsurveyor']);

$qri = ("SELECT p.id_siswa,p.nama_siswa,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats
		 FROM tbl_ats_2025 p WHERE p.id_siswa='" . $idsiswa . "'");
$dbquery = mysqli_query($dbconn, $qri);
$t = mysqli_fetch_assoc($dbquery);

$namasiswa = ucwords(strtolower($t['nama_siswa']));
$alamat = ucwords(strtolower($t['alamat']));
$rt = $t['rt'];
$rw = $t['rw'];
$desa = ucwords(strtolower($t['desa']));
$kecamatan = ucwords(strtolower($t['kecamatan']));

$namasekolah = strtoupper($t['nama_sekolah']);
$bentukpendidikan = $t['bentuk_pendidikan'];
$tingkatpendidikan = $t['tingkat_pendidikan'];
$tahun = $t['tahun'];
$semester = $t['semester'];
$statusats = $t['status_ats'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Hasil Survei</h5>
        <p class="fs--1 mb-0 text-white">Data Foto Hasil Survei ATS</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $namasiswa; ?></strong><br>
                        <?php echo $alamat; ?> RT <?php echo $rt; ?> RW <?php echo $rw; ?> - <?php echo $desa; ?> - <?php echo $kecamatan; ?>
                        <br>
                        <strong><?php echo $namasekolah; ?></strong><br>
                        <?php echo $statusats; ?> Tahun <?php echo $tahun; ?> - Kelas <?php echo $tingkatpendidikan; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <img class="img-fluid rounded" src="../data-foto-rekonfirmator/<?php echo $idsiswa; ?>.jpg" alt="" />

</div>
