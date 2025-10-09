<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT id_surveyor,nm_surveyor,telepon,id_universitas,id_fakultas,id_kecamatan FROM ats_surveyor ORDER BY id_surveyor ASC");
$result = mysqli_query($dbconn, $sqlx);
while ($t = mysqli_fetch_array($result)) {
	$idsurveyor = $t['id_surveyor'];
	$nmsurveyor = $t['nm_surveyor'];
	$telepon = $t['telepon'];
	$iduniversitas = $t['id_universitas'];
	$idfakultas = $t['id_fakultas'];
	$idkecamatan = $t['id_kecamatan'];
	$password = md5($t['telepon']);

	$sqlCR = ("SELECT id_user,username FROM ats_user WHERE id_user='". $t['id_surveyor']."' AND akses='surveyor' AND username='".$t['telepon']."'");
	$resultcr = mysqli_query($dbconn, $sqlCR);$jumuser = mysqli_num_rows($resultcr);
	if ($jumuser <= 0){
		$sql4  = "INSERT INTO ats_user (id_user,nm_user,username,password_user,akses,id_universitas,id_fakultas,id_kecamatan) VALUES ('$idsurveyor','$nmsurveyor','$telepon','$password','surveyor','$iduniversitas','$idfakultas','$idkecamatan')";
			$res=mysqli_query($dbconn,$sql4);
	}
	
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
mysqli_close($dbconn);
