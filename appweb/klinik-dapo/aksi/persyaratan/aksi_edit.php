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
	
	$idsyarat = anti_injection(trim($_POST['idsyarat']));	
	$nmpersyaratan = strtoupper(anti_injection(trim($_POST['nmpersyaratan'])));
	$nmfile = strtolower(anti_injection(trim($_POST['nmfile'])));
	$kriteria = anti_injection(trim($_POST['kriteria']));

	$pesanError = array();
	if (trim($idsyarat)=="") {
		$pesanError[] = "Data Persyaratan Tidak Terdeteksi";		
	}
	if (trim($nmpersyaratan)=="") {
		$pesanError[] = "Data Persyaratan Tidak Terdeteksi";		
	}
	if (trim($nmfile)=="") {
		$pesanError[] = "Data nama file tidak boleh kosong";		
	}
	if (trim($kriteria)=="") {
		$pesanError[] = "Mode upload tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE tte_m_persyaratan SET persyaratan='$nmpersyaratan',nama_file='$nmfile',mode_upload='$kriteria' WHERE id_persyaratan='".$idsyarat."'";
		$res=mysqli_query($dbconn,$sql2);			

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
	mysqli_close($dbconn);
?>
