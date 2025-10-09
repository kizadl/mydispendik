<?php
require_once '../../../../services/config.php';
error_reporting(0);
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once '../../../../services/csrf_helper.php';
header('Content-Type: application/json');
validate_csrf_token_or_exit($_POST['csrfToken'] ?? '');

$idoperator  = trim($_POST['idoperator'] ?? '');
$idinstansi  = trim($_POST['idinstansi'] ?? '');
$idtransaksi  = trim($_POST['idtransaksi'] ?? '');
$nik  = trim($_POST['nik'] ?? '');
$nama     	= trim($_POST['nama'] ?? '');
$alamat   = trim($_POST['alamat'] ?? '');
$noWA   = trim($_POST['noWA'] ?? '');
$bentukpendidikan   = trim($_POST['bentukpendidikan'] ?? '');

$namasekolah   = trim($_POST['namasekolah'] ?? '');
$npsn   = trim($_POST['npsn'] ?? '');

$masalah   = trim($_POST['masalah'] ?? '');

$errors = [];
if (!$idtransaksi ||!$idinstansi || !$nik || !$nama || !$alamat || !$noWA || !$bentukpendidikan || !$namasekolah || !$npsn || !$masalah) $errors[] = "Data tidak lengkap";

if (!empty($_FILES['upPengaduanE']['tmp_name'])) {
	$file = $_FILES['upPengaduanE'];
	if ($file['error'] !== UPLOAD_ERR_OK) {
		$errors[] = "Error upload file ({$file['error']})";
	} else {
		$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		if ($ext !== 'pdf') $errors[] = "Hanya PDF yang diizinkan";
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		if (finfo_file($finfo, $file['tmp_name']) !== 'application/pdf') {
			$errors[] = "File bukan PDF valid";
		}
		finfo_close($finfo);
	}
}

if ($errors) {
	echo json_encode(['msg1' => implode('; ', $errors), 'msg2' => 'err_val']);
	exit;
}

$stmtupdate = $dbconn->prepare("UPDATE trans_pengaduan_dapodik SET npsn=?,nama_sekolah=?,nik=?,nama=?,alamat=?,no_wa=?,bentuk_pendidikan=?,uraian_masalah=?,waktu_update=NOW(),id_opt_sekolah=? WHERE id_transaksi=?");
$stmtupdate->bind_param("sssssssssi", $npsn, $namasekolah, $nik, $nama, $alamat, $noWA, $bentukpendidikan, $masalah, $idoperator, $idtransaksi);
$stmtupdate->execute();

$folder = "../../../../data-layanan/pengaduan-dapodik/";
if (!is_dir($folder)) mkdir($folder, 0777, true);
$target = $folder . $idtransaksi . ".pdf";
move_uploaded_file($_FILES['upPengaduanE']['tmp_name'], $target);

$new_token = rotate_csrf_token();
echo json_encode(['msg1' => 'SUKSES!', 'msg2' => 'ok', 'new_token' => $new_token]);
$stmtupdate->close();
$dbconn->close();
