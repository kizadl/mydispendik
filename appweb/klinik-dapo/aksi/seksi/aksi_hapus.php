<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idseksi=trim($_POST['idseksi']);
	
$qri="UPDATE tte_m_seksi SET dvs_model=NULL,dvs_uuid=NULL,dvs_seri=NULL,status_tte='TIDAK AKTIF',aktif='N' WHERE id_seksi='".$idseksi."'";	
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
