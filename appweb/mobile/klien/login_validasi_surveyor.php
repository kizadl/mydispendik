<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$modelhp = trim($_POST['modelhp']);
$idhp = trim($_POST['idhp']);
$serihp = trim($_POST['serihp']);
$telepon = trim($_POST['telepon']);

$sql = ("SELECT p.id_surveyor,p.id_fakultas,p.id_universitas,p.id_koordinator,p.id_kecamatan,p.id_desa,p.nm_surveyor,p.telepon,p.status_hp,p.dvs_model,p.dvs_uuid,p.dvs_seri FROM ats_surveyor p WHERE p.telepon='" . $telepon . "'");
$resultx = mysqli_query($dbconn, $sql);
$jumlah = mysqli_num_rows($resultx);

$myArray = array();

if ($jumlah > 0) {
	while ($t = $resultx->fetch_array(MYSQLI_ASSOC)) {
		$status =  $t['status_hp'];
		if ($jumlah >= 1) {
			$jumlahnya = 1;
		} else {
			$jumlahnya = 0;
		}

		if ($telepon !== $t['telepon']) {
			$ketpassword = "tidak";
		} else if ($telepon == $t['telepon']) {
			$ketpassword = "sama";
		}

		if ($status == "TIDAK AKTIF" and $ketpassword == "sama") {
			$sql3  = "UPDATE ats_surveyor set dvs_model='$modelhp',dvs_uuid='$idhp',dvs_seri='$serihp',status_hp='MENUNGGU AKTIVASI' WHERE id_surveyor='" . $t['id_surveyor'] . "'";
			$res = mysqli_query($dbconn, $sql3);
			$status = "MENUNGGU AKTIVASI";
			$hpmodeldb = $modelhp;
			$hpiddb = $idhp;
			$hpseridb = $serihp;
		} else {
			$hpmodeldb = $t['dvs_model'];
			$hpiddb = $t['dvs_uuid'];
			$hpseridb = $t['dvs_seri'];
		}

		$row_array = array();
		$row_array['hpmodeldb'] = $hpmodeldb;
		$row_array['hpiddb'] = $hpiddb;
		$row_array['hpseridb'] = $hpseridb;
		$row_array['jumol'] = $jumlahnya;
		$row_array['idsurveyor'] = $t['id_surveyor'];
		$row_array['idkecamatan'] = $t['id_kecamatan'];
		$row_array['status'] = $status;
		$row_array['username'] = $t['telepon'];
		$row_array['ketpassword'] = $ketpassword;
		$row_array['nmsurveyor'] = $t['nm_surveyor'];
		array_push($myArray, $row_array);
	}
} else {
	$row_array = array();
	$row_array['hpmodeldb'] = $modelhp;
	$row_array['hpiddb'] = $idhp;
	$row_array['hpseridb'] = $serihp;
	$row_array['jumol'] = $jumlah;
	$row_array['idsurveyor'] = "";
	$row_array['idkecamatan'] = "";
	$row_array['status'] = "";
	$row_array['username'] = "";
	$row_array['ketpassword'] = "";
	$row_array['nmsurveyor'] = "";
	array_push($myArray, $row_array);
}

echo json_encode($myArray);
$resultx->close();
$dbconn->close();
