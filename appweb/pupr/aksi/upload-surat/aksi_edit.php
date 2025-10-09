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

	$idsekolah =anti_injection(trim($_POST['idsekolah']));
	$npsn =anti_injection(trim($_POST['npsn']));

	$lokasi_akta    = $_FILES['upSuratE']['tmp_name'];

	$pesanError = array();
	if (trim($idsekolah)=="") {
		$pesanError[] = "Sekolah tidak terdeteksi";		
	}
	if (trim($npsn)=="") {
		$pesanError[] = "Sekolah tidak terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$nmfilenya = $npsn.".pdf";
	
		$sql2  = "INSERT INTO detail_persetujuan_pupr (npsn,tgl_surat,file_surat,arsip) VALUES ('$npsn',CURDATE(),'$nmfilenya','N')";
			$res=mysqli_query($dbconn,$sql2);	
		
		if(!is_dir("../../../data-surat/".$npsn))
		mkdir("../../../data-surat/".$npsn,0777,true); 
		$path1 = "../../../data-surat/".$npsn."/".$nmfilenya;	
		
		if (!($lokasi_akta)==''){
			move_uploaded_file($lokasi_akta, $path1);
		}
		
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
