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

	$iduniversitas = anti_injection(trim($_POST['iduniversitas']));
	$idfakultas = anti_injection(trim($_POST['idfakultas']));
	$nmkoordinator = strtoupper(anti_injection(trim($_POST['nmkoordinator'])));	
	
	$sqlX = ("SELECT nm_koordinator FROM ats_koordinator WHERE nm_koordinator='".$nmkoordinator."' AND id_universitas='".$iduniversitas."' AND id_fakultas='".$idfakultas."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['nm_operator'])==strtolower($nmkoordinator)) {
		$pesanError[] = ucwords(strtolower($nmkoordinator))." terdeteksi sudah ada\nInput data koordinator tidak boleh sama";	
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
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "INSERT INTO ats_koordinator (nm_koordinator,id_universitas,id_fakultas) VALUES ('$nmkoordinator','$iduniversitas','$idfakultas')";
			$res=mysqli_query($dbconn,$sql2);

		$qrioperator = ("SELECT MAX(id_koordinator) AS idnekoor FROM ats_koordinator ORDER BY id_koordinator DESC");
		$dboperator = mysqli_query($dbconn, $qrioperator);$op = mysqli_fetch_assoc($dboperator);
		$idnekoor = $op['idnekoor'];

		$username = "koordinator".$iduniversitas."-".$idfakultas."@".$idnekoor;
		$password = md5("koordinator");

		$sql3  = "UPDATE ats_koordinator SET username='$username',password_koordinator='$password' WHERE id_koordinator='".$idnekoor."'";
		$res=mysqli_query($dbconn,$sql3);	

		$sql4  = "INSERT INTO ats_user (id_user,nm_user,username,password_user,akses,id_universitas,id_fakultas) VALUES ('$idnekoor','$nmkoordinator','$username','$password','koordinator','$iduniversitas','$idfakultas')";
		$res=mysqli_query($dbconn,$sql4);

		if($res){
			$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}			
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>
