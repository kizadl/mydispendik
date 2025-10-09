<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');

$iduser = anti_injection(trim($_POST['iduser']));
$nmuser = strtoupper(anti_injection(trim($_POST['nmuser'])));
$username = strtolower(anti_injection(trim($_POST['nmuser'])));
$username = "desk@" . preg_replace('/\s+/', '', $username);

$sqlX = ("SELECT nm_user FROM ats_user WHERE nm_user='" . $nmuser . "' AND id_user <> '" . $iduser . "' AND akses='desk'");
$resultx = mysqli_query($dbconn, $sqlX);
$r = mysqli_fetch_assoc($resultx);

$pesanError = array();
if (strtolower($r['nm_user']) == strtolower($nmuser)) {
	$pesanError[] = ucwords(strtolower($nmuser)) . " terdeteksi sudah ada\nEdit data operator desk tidak boleh sama";
}
if (trim($iduser) == "") {
	$pesanError[] = "Data Identitas operator desk Tidak Terdeteksi !";
}
if (trim($nmuser) == "") {
	$pesanError[] = "Data Operator Desk Tidak Terdeteksi";
}
if (trim($username) == "") {
	$pesanError[] = "Data username tidak boleh kosong";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql3  = "UPDATE ats_user SET nm_user='$nmuser',username='$username' WHERE id='" . $iduser . "' AND akses='desk'";
	$res = mysqli_query($dbconn, $sql3);

	if ($res) {
		$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($data);

mysqli_free_result($res);
mysqli_free_result($resultx);
mysqli_close($dbconn);
