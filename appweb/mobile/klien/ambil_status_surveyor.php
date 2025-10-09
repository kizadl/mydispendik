<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$tglserver = date('Y-m-d');
$sqlser = ("SELECT aktivasi_ats,sinkron_ats FROM set_server WHERE id_server='1'");
$resultser = mysqli_query($dbconn, $sqlser);
$u = mysqli_fetch_assoc($resultser);
$aktivasiserver = $u['aktivasi_ats'];
$sinkronklien = $u['sinkron_ats'];

$modelhp = trim($_POST['modelhp']);
$idhp = trim($_POST['idhp']);
$serihp = trim($_POST['serihp']);
$sql = ("SELECT p.id_surveyor,p.id_fakultas,p.id_universitas,p.id_koordinator,p.id_kecamatan,p.id_desa,p.nm_surveyor,p.telepon,p.status_hp FROM ats_surveyor p WHERE p.dvs_model='" . $modelhp . "' and p.dvs_uuid='" . $idhp . "' and p.dvs_seri='" . $serihp . "'");
$resultx = mysqli_query($dbconn, $sql);
$jumlah = mysqli_num_rows($resultx);

$myArray = array();
if ($jumlah >= 1) {
	$t = mysqli_fetch_assoc($resultx);
	$row_array = array();
	$row_array['jumol'] = $jumlah;
	$row_array['tglserver'] = $tglserver;
	$row_array['aktivasiserver'] = $aktivasiserver;
	$row_array['sinkronklien'] = $sinkronklien;
	$row_array['idsurveyor'] = $t['id_surveyor'];
	$row_array['idkecamatan'] = $t['id_kecamatan'];
	$row_array['nmsurveyor'] = $t['nm_surveyor'];
	$row_array['telepon'] = $t['telepon'];
	$row_array['status'] = $t['status_hp'];

	array_push($myArray, $row_array);
} else {
	$row_array = array();
	$row_array['jumol'] = 0;
	$row_array['tglserver'] = $tglserver;
	$row_array['aktivasiserver'] = $aktivasiserver;
	$row_array['sinkronklien'] = $sinkronklien;
	$row_array['idsaksi'] = "";
	$row_array['idkecamatan'] = "";
	$row_array['nama'] = "";
	$row_array['telepon'] = "";
	$row_array['status'] = "";
	array_push($myArray, $row_array);
}

echo json_encode($myArray);
$resultser->close();
$resultx->close();
$dbconn->close();
