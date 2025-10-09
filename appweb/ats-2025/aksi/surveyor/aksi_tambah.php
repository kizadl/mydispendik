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

$nmsurveyor = strtoupper(anti_injection(trim($_POST['nmsurveyor'])));
$iduniversitas = anti_injection(trim($_POST['iduniversitas']));
$idfakultas = anti_injection(trim($_POST['idfakultas']));
$nohp = anti_injection(trim($_POST['nohp']));
$idkecamatan = anti_injection(trim($_POST['idkecamatan']));
$iddesa = anti_injection(trim($_POST['iddesa']));

$sqlX = ("SELECT telepon FROM ats_surveyor_2025 WHERE telepon='" . $nohp . "'");
$resultx = mysqli_query($dbconn, $sqlX);
$r = mysqli_fetch_assoc($resultx);

$pesanError = array();
if (strtolower($r['telepon']) == $nohp) {
	$pesanError[] = ucwords(strtolower($nohp)) . " terdeteksi sudah ada\nInput data NIM surveyor tidak boleh sama";
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

	$sql2  = "INSERT INTO ats_surveyor_2025 (nm_surveyor,id_universitas,id_fakultas,id_kecamatan,id_desa,telepon) VALUES ('$nmsurveyor','$iduniversitas','$idfakultas','$idkecamatan','$iddesa','$nohp')";
	$res = mysqli_query($dbconn, $sql2);

	$qrioperator = ("SELECT MAX(id_surveyor) AS idnekoor FROM ats_surveyor_2025 ORDER BY id_surveyor DESC");
	$dboperator = mysqli_query($dbconn, $qrioperator);
	$op = mysqli_fetch_assoc($dboperator);
	$idnekoor = $op['idnekoor'];

	$password = md5($nohp);
	$sql4  = "INSERT INTO ats_user_2025 (id_user,nm_user,username,password_user,akses,id_universitas,id_fakultas,id_kecamatan) VALUES ('$idnekoor','$nmsurveyor','$nohp','$password','surveyor','$iduniversitas','$idfakultas','$idkecamatan')";
	$res = mysqli_query($dbconn, $sql4);

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
mysqli_close($dbconn);
