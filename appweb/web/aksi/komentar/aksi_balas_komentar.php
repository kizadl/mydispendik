<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

require_once '../../../services/csrf_helper.php';
header('Content-Type: application/json');
validate_csrf_token_or_exit($_POST['csrfToken'] ?? '');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');

$idkomentar = anti_injection(trim($_POST['idkomentar']));
$nama = anti_injection(strtoupper(trim($_POST['nama'])));
$email = anti_injection(trim($_POST['email']));
$komentar = anti_injection(trim($_POST['komentar']));

$pesanError = array();
if (trim($nama) == "") {
	$pesanError[] = "Data Nama Tidak Terdeteksi";
}
if (trim($email) == "") {
	$pesanError[] = "Data Email Tidak Terdeteksi";
}
if (trim($komentar) == "") {
	$pesanError[] = "Data komentar tidak boleh kosong";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql2  = "INSERT INTO komentar (nama,email,isi_komentar,tgl_komentar,jam_komentar,ket_komentar,id_balas) 
				VALUES ('$nama','$email','$komentar',CURDATE(),CURTIME(),'balasan','$idkomentar')";
	$res = mysqli_query($dbconn, $sql2);

	if ($res) {
		$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}

$new_token = rotate_csrf_token();
$data = array('msg1' => $errMsg, 'msg2' => $status, 'new_token' => $new_token);
echo json_encode($data);

mysqli_free_result($res);
//mysqli_free_result($result);
mysqli_close($dbconn);
