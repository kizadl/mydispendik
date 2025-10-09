<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idsurveyor=trim($_POST['idsurveyor']);
	
$qri="UPDATE ats_surveyor SET id_koordinator=NULL WHERE id_surveyor='".$idsurveyor."'";	
$res=mysqli_query($dbconn,$qri);

if($res){
	$errMsg .="SUKSES ! Selamat, data sudah dihapus.";
}else{
	$errMsg .="GAGAL ! Data tidak terhapus !<br>Error time limit.";
}	
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);	
?>
