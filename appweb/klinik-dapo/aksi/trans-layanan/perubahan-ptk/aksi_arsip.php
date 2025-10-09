<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d H:i:s');

$idtransaksi = anti_injection(trim($_POST['idtransaksi']));
$idlayanan = anti_injection(trim($_POST['idlayanan']));

$pesanError = array();
if (trim($idtransaksi) == "") {
	$pesanError[] = "Data transaksi tidak terdeteksi";
}
if (trim($idlayanan) == "") {
	$pesanError[] = "Data bidang tidak terdeteksi";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql2  = "UPDATE tte_trans_perubahan_ptk SET arsip_admin='Y' WHERE id_transaksi='" . $idtransaksi . "'";
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
echo json_encode($errMsg);

mysqli_free_result($res);
mysqli_close($dbconn);
