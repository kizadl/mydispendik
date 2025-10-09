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

$idfakultas = anti_injection(trim($_POST['idfakultas']));
$nmfakultas = anti_injection(trim($_POST['nmfakultas']));
$iduniversitas = anti_injection(trim($_POST['iduniversitas']));

$sqlX = ("SELECT nm_fakultas FROM ats_fakultas_2025 WHERE nm_fakultas='" . $nmfakultas . "' AND id_universitas = '" . $iduniversitas . "' AND id_fakultas <> '" . $idfakultas . "'");
$resultx = mysqli_query($dbconn, $sqlX);
$r = mysqli_fetch_assoc($resultx);

$pesanError = array();
if (strtolower($r['nm_fakultas']) == strtolower($nmfakultas)) {
	$pesanError[] = ucwords(strtolower($nmfakultas)) . " terdeteksi sudah ada\nEdit data fakultas tidak boleh sama";
}
if (trim($idfakultas) == "") {
	$pesanError[] = "Data Identitas Fakultas Tidak Terdeteksi !";
}
if (trim($nmfakultas) == "") {
	$pesanError[] = "Data Fakultas Tidak Terdeteksi";
}
if (trim($iduniversitas) == "") {
	$pesanError[] = "Data Universitas Tidak Terdeteksi";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql2  = "UPDATE ats_fakultas_2025 SET nm_fakultas='$nmfakultas',id_universitas='$iduniversitas' WHERE id_fakultas='" . $idfakultas . "'";
	$res = mysqli_query($dbconn, $sql2);

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
