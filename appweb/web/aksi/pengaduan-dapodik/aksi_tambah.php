<?php
require_once '../../../services/config.php';
error_reporting(0);
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once '../../../services/csrf_helper.php';
header('Content-Type: application/json');
validate_csrf_token_or_exit($_POST['csrfToken'] ?? '');

$asal  = trim($_POST['asal'] ?? '');
$nik  = trim($_POST['nik'] ?? '');
$nama     	= trim($_POST['nama'] ?? '');
$alamat   = trim($_POST['alamat'] ?? '');
$noWA   = trim($_POST['noWA'] ?? '');
$bentukpendidikan   = trim($_POST['bentukpendidikan'] ?? '');
$npsn   = trim($_POST['npsn'] ?? '');$npsn   = strtoupper($npsn);
$namasekolah   = trim($_POST['namasekolah'] ?? '');
$masalah   = trim($_POST['masalah'] ?? '');

$errors = [];
if (!$asal || !$nik || !$nama || !$alamat || !$noWA || !$bentukpendidikan || !$npsn || !$namasekolah || !$masalah) $errors[] = "Data tidak lengkap";

if (!empty($_FILES['upPengaduan']['tmp_name'])) {
	$file = $_FILES['upPengaduan'];
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

$stmt = $dbconn->prepare("INSERT INTO trans_pengaduan_dapodik (npsn,nama_sekolah,nik,nama,alamat,no_wa,bentuk_pendidikan,uraian_masalah,pengirim,ket_level,waktu_create,waktu_update) 
VALUES (?,?,?,?,?,?,?,?,'umum','operator sekolah',NOW(),NOW())");
$stmt->bind_param("ssssssss", $npsn, $namasekolah, $nik, $nama, $alamat, $noWA, $bentukpendidikan, $masalah);
$stmt->execute();

$newId = $dbconn->insert_id; 

$noorder = date('ymd') . "." . $newId;
$stmtupdate = $dbconn->prepare("UPDATE trans_pengaduan_dapodik SET no_order=? WHERE id_transaksi=?");
$stmtupdate->bind_param("si", $noorder, $newId);
$stmtupdate->execute();

$folder = "../../../data-layanan/pengaduan-dapodik/";
if (!is_dir($folder)) mkdir($folder, 0777, true);
$target = $folder . $newId . ".pdf";
move_uploaded_file($_FILES['upPengaduan']['tmp_name'], $target);

$new_token = rotate_csrf_token();
echo json_encode(['msg1' => 'SUKSES!', 'msg2' => 'ok', 'new_id' => $newId, 'new_token' => $new_token]);
$stmt->close();
$dbconn->close();
