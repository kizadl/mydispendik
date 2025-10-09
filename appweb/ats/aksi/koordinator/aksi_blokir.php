<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}	
	$idkoordinator = anti_injection(trim($_POST['idkoordinator']));
	$status = anti_injection(trim($_POST['status']));
		
	$sql  = "UPDATE ats_koordinator SET blokir='$status' WHERE id_koordinator='".$idkoordinator."'";
	$res=mysqli_query($dbconn,$sql);

	$sql2  = "UPDATE ats_user SET blokir='$status' WHERE id_user='".$idkoordinator."' AND akses='koordinator'";
	$res=mysqli_query($dbconn,$sql2);
	
	if($res){
		$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
	}else{
		$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
	}	
	echo json_encode($errMsg);	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>
