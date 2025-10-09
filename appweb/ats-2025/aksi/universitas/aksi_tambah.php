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

$nmuniversitas = anti_injection(trim($_POST['nmuniversitas']));

$sqlX = ("SELECT nm_universitas FROM ats_universitas_2025 WHERE nm_universitas='" . $nmuniversitas . "'");
$resultx = mysqli_query($dbconn, $sqlX);
$r = mysqli_fetch_assoc($resultx);

$pesanError = array();
if (strtolower($r['nm_universitas']) == strtolower($nmuniversitas)) {
	$pesanError[] = ucwords(strtolower($nmseksi)) . " terdeteksi sudah ada\nInput data universitas tidak boleh sama";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql2  = "INSERT INTO ats_universitas_2025 (nm_universitas) VALUES ('$nmuniversitas')";
	$res = mysqli_query($dbconn, $sql2);

	if ($res) {
		$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($data);

mysqli_free_result($res);
mysqli_free_result($resultx);
mysqli_free_result($dbquery);
mysqli_close($dbconn);
