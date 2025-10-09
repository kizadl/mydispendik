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

	$idoperator = anti_injection(trim($_POST['idoperator']));
	$idpengaduan = anti_injection(trim($_POST['idpengaduan']));
	$idbidang = anti_injection(trim($_POST['idbidang']));

	$pesanError = array();
	if (trim($idpengaduan)=="") {
		$pesanError[] = "Data Pengaduan Tidak Terdeteksi";		
	}
	if (trim($idbidang)=="") {
		$pesanError[] = "Data Bidang Tidak Terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE pengaduan SET tgl_distribusi=CURDATE(),jam_distribusi=CURTIME(),stts_pengaduan='distribusi',id_bidang='$idbidang',id_operator_distribusi='$idoperator'
				WHERE id_pengaduan='".$idpengaduan."'"; 
		$res=mysqli_query($dbconn,$sql2);

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
	mysqli_close($dbconn);
?>
