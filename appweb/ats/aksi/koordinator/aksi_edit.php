<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set('Asia/Jakarta');
	
	$idkoordinator = anti_injection(trim($_POST['idkoordinator']));
	$iduniversitas = anti_injection(trim($_POST['iduniversitas']));
	$idfakultas = anti_injection(trim($_POST['idfakultas']));
	$nmkoordinator = strtoupper(anti_injection(trim($_POST['nmkoordinator'])));	

	$username = "koordinator".$iduniversitas."-".$idfakultas."@".$idkoordinator;

	$sqlX = ("SELECT nm_koordinator FROM ats_koordinator WHERE nm_koordinator='".$nmkoordinator."' AND id_koordinator <> '".$idkoordinator."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['nm_koordinator'])==strtolower($nmkoordinator)) {
		$pesanError[] = ucwords(strtolower($nmkoordinator))." terdeteksi sudah ada\nEdit data koordinator tidak boleh sama";	
	}	
	if (trim($idkoordinator)=="") {
		$pesanError[] = "Data Identitas koordinator Tidak Terdeteksi !";		
	}	
	if (trim($nmkoordinator)=="") {
		$pesanError[] = "Data Koordinator Tidak Terdeteksi";		
	}
	if (trim($iduniversitas)=="") {
		$pesanError[] = "Data Universitas Tidak Terdeteksi";		
	}
	if (trim($idfakultas)=="") {
		$pesanError[] = "Data Fakultas Tidak Terdeteksi";		
	}
	if (trim($username)=="") {
		$pesanError[] = "Data username tidak boleh kosong";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	
		
		$sql2  = "UPDATE ats_koordinator SET nm_koordinator='$nmkoordinator',username='$username',id_universitas='$iduniversitas',id_fakultas='$idfakultas' WHERE id_koordinator='".$idkoordinator."'";
			$res=mysqli_query($dbconn,$sql2);
			
		$sql3  = "UPDATE ats_user SET nm_user='$nmkoordinator',username='$username',id_universitas='$iduniversitas',id_fakultas='$idfakultas' WHERE id_user='".$idkoordinator."' AND akses='koordinator'";
			$res=mysqli_query($dbconn,$sql3);
		
		if($res){
			$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}			
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>
