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

	$idlayanan = anti_injection(trim($_POST['idlayanan']));
	$nmpersyaratan = strtoupper(anti_injection(trim($_POST['nmpersyaratan'])));
	$nmfile = strtolower(anti_injection(trim($_POST['nmfile'])));
	$kriteria = anti_injection(trim($_POST['kriteria']));

	$pesanError = array();
	if (trim($idlayanan)=="") {
		$pesanError[] = "Data Layanan Tidak Terdeteksi";		
	}
	if (trim($nmpersyaratan)=="") {
		$pesanError[] = "Data persyaratan tidak boleh kosong";		
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

		$sql2  = "INSERT INTO tte_m_persyaratan_gaji_berkala (id_layanan,persyaratan,nama_file,mode_upload,aktif) VALUES ('$idlayanan','$nmpersyaratan','$nmfile','$kriteria','Y')";
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
