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

$idsurveyor = anti_injection(trim($_POST['idsurveyor']));
$nmsurveyor = strtoupper(anti_injection(trim($_POST['nmsurveyor'])));
$iduniversitas = anti_injection(trim($_POST['iduniversitas']));
$idfakultas = anti_injection(trim($_POST['idfakultas']));
$idkecamatan = anti_injection(trim($_POST['idkecamatan']));
$iddesa = anti_injection(trim($_POST['iddesa']));
$nohp = anti_injection(trim($_POST['nohp']));

$sqlX = ("SELECT telepon FROM ats_surveyor_2025 WHERE telepon='" . $nohp . "' AND id_surveyor <> '" . $idsurveyor . "'");
$resultx = mysqli_query($dbconn, $sqlX);
$r = mysqli_fetch_assoc($resultx);

$pesanError = array();
if (strtolower($r['telepon']) == $nohp) {
	$pesanError[] = ucwords(strtolower($nohp)) . " terdeteksi sudah ada\nInput data NIM surveyor tidak boleh sama";
}
if (trim($idsurveyor) == "") {
	$pesanError[] = "Data Surveyor Tidak Terdeteksi";
}
if (trim($nmsurveyor) == "") {
	$pesanError[] = "Data Surveyor Tidak Terdeteksi";
}
if (trim($iduniversitas) == "") {
	$pesanError[] = "Data Universitas Tidak Terdeteksi";
}
if (trim($idfakultas) == "") {
	$pesanError[] = "Data Fakultas Tidak Terdeteksi";
}
if (trim($nohp) == "") {
	$pesanError[] = "Data NIM tidak boleh kosong";
}
if (trim($idkecamatan) == "") {
	$pesanError[] = "Data kecamatan tidak boleh kosong";
}
if (trim($iddesa) == "") {
	$pesanError[] = "Data desa tidak boleh kosong";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql2  = "UPDATE ats_surveyor_2025 SET nm_surveyor='$nmsurveyor',id_universitas='$iduniversitas',id_fakultas='$idfakultas',id_kecamatan='$idkecamatan',id_desa='$iddesa',telepon='$nohp' WHERE id_surveyor='" . $idsurveyor . "'";
	$res = mysqli_query($dbconn, $sql2);

	$password = md5($nohp);
	$sql3  = "UPDATE ats_user_2025 SET nm_user='$nmsurveyor',username='$nohp',password_user='$password',id_universitas='$iduniversitas',id_fakultas='$idfakultas',id_kecamatan='$idkecamatan' WHERE id_user='" . $idsurveyor . "' AND akses='surveyor'";
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
