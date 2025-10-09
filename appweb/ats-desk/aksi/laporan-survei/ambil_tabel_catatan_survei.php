<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idkecamatan = trim($_POST['idkecamatan']);
$iddesa = trim($_POST['iddesa']);

$sqlx = ("SELECT id_catatan,catatan FROM ats_catatan_survei");
		
$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
$no = 0;
while($t=mysqli_fetch_array($resultx)){
	$no++;
	if ($idkecamatan == "all") {

		$sqlcount = ("SELECT COUNT(p.id_siswa) AS jumCatatan,
		COUNT(IF(q.jenis_kelamin='L',p.id_siswa,null)) AS jumCatatanL,COUNT(IF(q.jenis_kelamin='P',p.id_siswa,null)) AS jumCatatanP
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND p.id_catatan = '" . $t['id_catatan'] . "'");

		$sqltotal = ("SELECT COUNT(id_siswa) AS jumTotCatatan FROM ats_detail_survei");

	} else if ($idkecamatan != "all" and $iddesa == "all") {

		$sqlcount = ("SELECT COUNT(p.id_siswa) AS jumCatatan,
		COUNT(IF(q.jenis_kelamin='L',p.id_siswa,null)) AS jumCatatanL,COUNT(IF(q.jenis_kelamin='P',p.id_siswa,null)) AS jumCatatanP
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND p.id_catatan = '" . $t['id_catatan'] . "' AND q.kd_kecamatan = '".$idkecamatan."'");

		$sqltotal = ("SELECT COUNT(p.id_siswa) AS jumTotCatatan 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan = '".$idkecamatan."'");

	} else if ($idkecamatan != "all" AND $iddesa !="all"){

		$sqlcount = ("SELECT COUNT(p.id_siswa) AS jumCatatan,
		COUNT(IF(q.jenis_kelamin='L',p.id_siswa,null)) AS jumCatatanL,COUNT(IF(q.jenis_kelamin='P',p.id_siswa,null)) AS jumCatatanP
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND p.id_catatan = '" . $t['id_catatan'] . "' AND q.kd_desa = '".$iddesa."'");

		$sqltotal = ("SELECT COUNT(p.id_siswa) AS jumTotCatatan 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa = '".$iddesa."'");

	}
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);
	$resulTotal = mysqli_query($dbconn,$sqltotal);$q= mysqli_fetch_assoc($resulTotal);

	if ($s['jumCatatan'] <= 0 OR $q['jumTotCatatan'] <= 0){
		$persentaseCatatan = "0,00";
	} else {
		$persentaseCatatan = number_format(($s['jumCatatan'] / $q['jumTotCatatan'] )* 100, 2, ',', '.');
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['namacatatan']=$t['catatan'];
	$row_array['idcatatan']=$t['id_catatan'];
	$row_array['jumCatatan']= number_format($s['jumCatatan'], 0, ',', '.');
	$row_array['jumCatatanL']= number_format($s['jumCatatanL'], 0, ',', '.');
	$row_array['jumCatatanP']= number_format($s['jumCatatanP'], 0, ',', '.');
	$row_array['jumTotCatatan']= number_format($q['jumTotCatatan'], 0, ',', '.');
	$row_array['persentaseCatatan']=$persentaseCatatan;
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
