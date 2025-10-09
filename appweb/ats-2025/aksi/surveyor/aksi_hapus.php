<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsurveyor = trim($_POST['idsurveyor']);

$qri = "DELETE FROM ats_surveyor_2025 WHERE id_surveyor='" . $idsurveyor . "'";
$res = mysqli_query($dbconn, $qri);

$qri2 = "DELETE FROM ats_user_2025 WHERE id_user='" . $idsurveyor . "' AND akses='surveyor'";
$res = mysqli_query($dbconn, $qri2);

$qri3 = "UPDATE tbl_ats_2025 SET id_surveyor=NULL WHERE id_surveyor='" . $idsurveyor . "'";
$res = mysqli_query($dbconn, $qri3);

if ($res) {
	$errMsg .= "SUKSES ! Selamat, data sudah dihapus.";
} else {
	$errMsg .= "GAGAL ! Data tidak terhapus !<br>Error time limit.";
}
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);
