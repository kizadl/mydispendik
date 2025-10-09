<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idkecamatan = trim($_POST['idkecamatan']);
$iddesa = trim($_POST['iddesa']);

$sqlx = ("SELECT id_catatan,catatan FROM ats_catatan_survei");
		
$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($resultx)){

	if ($idkecamatan == "all") {
		$sqlcount = ("SELECT COUNT(id_siswa) AS jumCatatan FROM ats_detail_survei WHERE id_catatan = '" . $t['id_catatan'] . "'");
	} else if ($idkecamatan != "all" and $iddesa == "all") {
		$sqlcount = ("SELECT COUNT(p.id_siswa) AS jumCatatan 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND p.id_catatan = '" . $t['id_catatan'] . "' AND q.kd_kecamatan = '".$idkecamatan."'");
	} else if ($idkecamatan != "all" AND $iddesa !="all"){
		$sqlcount = ("SELECT COUNT(p.id_siswa) AS jumCatatan 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND p.id_catatan = '" . $t['id_catatan'] . "' AND q.kd_desa = '".$iddesa."'");
	}
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['catatan']=$t['catatan'];
	$row_array['jumCatatan']= $s['jumCatatan'];
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
