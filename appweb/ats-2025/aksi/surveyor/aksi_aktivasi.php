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
$idsurveyor = anti_injection(trim($_POST['idsurveyor']));
$status = strtoupper(anti_injection(trim($_POST['status'])));

if ($status == "TIDAK AKTIF") {
	$sql  = "UPDATE ats_surveyor_2025 SET dvs_model=NULL,dvs_uuid=NULL,dvs_seri=NULL,status_hp='$status' WHERE id_surveyor='" . $idsurveyor . "'";
	$res = mysqli_query($dbconn, $sql);
} else {
	$sql  = "UPDATE ats_surveyor_2025 SET status_hp='$status' WHERE id_surveyor='" . $idsurveyor . "'";
	$res = mysqli_query($dbconn, $sql);
}

if ($res) {
	$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
} else {
	$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
}
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);
