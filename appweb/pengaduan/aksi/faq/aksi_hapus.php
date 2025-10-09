<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idfaq=trim($_POST['idfaq']);

$sql4  = "DELETE FROM faq_ppdb WHERE id_faq='".$idfaq."'";
$res=mysqli_query($dbconn,$sql4);	

if($res){
	$errMsg ="Selamat, proses menghapus data sukses.";
}else{
	$errMsg ="GAGAL ! Data tidak terhapus !<br>Error time limit.";
}	
echo json_encode($errMsg);
mysqli_free_result($res);
mysqli_close($dbconn);	
?>
