<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}	
	$idseksi = anti_injection(trim($_POST['idseksi']));
	$status = strtoupper(anti_injection(trim($_POST['status'])));
		
	if ($status == "TIDAK AKTIF"){
		$sql  = "UPDATE m_sub_bagian SET dvs_model=NULL,dvs_uuid=NULL,dvs_seri=NULL,status_tte='$status' WHERE id_sub_bagian='".$idseksi."'";
		$res=mysqli_query($dbconn,$sql);
	} else {
		$sql  = "UPDATE m_sub_bagian SET status_tte='$status' WHERE id_sub_bagian='".$idseksi."'";
		$res=mysqli_query($dbconn,$sql);
	}
	
	if($res){
		$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
	}else{
		$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
	}	
	echo json_encode($errMsg);	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>
