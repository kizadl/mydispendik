<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idkoordinator = trim($_POST['idkoordinator']);

$qri = "UPDATE ats_koordinator_2025 SET aktif='N' WHERE id_koordinator='" . $idkoordinator . "'";
$res = mysqli_query($dbconn, $qri);

$qri2 = "DELETE FROM ats_user_2025 WHERE id_user='" . $idkoordinator . "' AND akses='koordinator'";
$res = mysqli_query($dbconn, $qri2);

$qri3 = "UPDATE ats_surveyor_2025 SET id_koordinator=NULL WHERE id_koordinator='" . $idkoordinator . "'";
$res = mysqli_query($dbconn, $qri3);

if ($res) {
	$errMsg .= "SUKSES ! Selamat, data sudah dihapus.";
} else {
	$errMsg .= "GAGAL ! Data tidak terhapus !<br>Error time limit.";
}
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);
