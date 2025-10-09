<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');	

$tglserver=date('Y-m-d');
$sqlser = ("SELECT aktivasi,sinkron FROM set_server WHERE id_server='1'");		
$resultser = mysqli_query($dbconn,$sqlser);$u= mysqli_fetch_assoc($resultser);$aktivasiserver = $u['aktivasi'];$sinkronklien = $u['sinkron'];

$modelhp = trim($_POST['modelhp']);$idhp = trim($_POST['idhp']);$serihp = trim($_POST['serihp']);
$sql = ("SELECT p.status FROM saksi p WHERE p.dvs_model='".$modelhp."' and p.dvs_uuid='".$idhp."' and p.dvs_seri='".$serihp."'");		
$resultx = mysqli_query($dbconn,$sql);
$jumlah = mysqli_num_rows($resultx);

$myArray = array();
if($jumlah>=1){ 
	$t= mysqli_fetch_assoc($resultx);	
	$row_array = array();
	$row_array['jumol']=$jumlah;$row_array['tglserver']=$tglserver;
	$row_array['aktivasiserver']=$aktivasiserver;$row_array['sinkronklien']=$sinkronklien;$row_array['status']=$t['status'];	
	array_push($myArray,$row_array);
}else{
	$row_array = array();
	$row_array['jumol']=0;	$row_array['tglserver']=$tglserver;
	$row_array['aktivasiserver']=$aktivasiserver;$row_array['sinkronklien']=$sinkronklien;$row_array['status']="";
	array_push($myArray,$row_array);
}

echo json_encode($myArray);
$resultser->close();$resultx->close();
$dbconn->close();
?>