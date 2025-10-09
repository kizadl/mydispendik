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
	$nmlayanan = anti_injection(trim($_POST['nmlayanan']));
	$awalan = strtoupper(anti_injection(trim($_POST['awalan'])));	
	$urutan = anti_injection(trim($_POST['urutan']));
	$akhiran = strtoupper(anti_injection(trim($_POST['akhiran'])));

	$pesanError = array();
	if (trim($idlayanan)=="") {
		$pesanError[] = "Data Layanan Tidak Terdeteksi";		
	}
	if (trim($nmlayanan)=="") {
		$pesanError[] = "Data layanan tidak boleh kosong";		
	}
	if (trim($awalan)=="") {
		$pesanError[] = "Data awalan surat tidak boleh kosong";		
	}
	if (trim($urutan)=="") {
		$pesanError[] = "Data nomor urut tidak boleh kosong";		
	}
	if (trim($akhiran)=="") {
		$pesanError[] = "Data akhiran surat tidak boleh kosong";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "UPDATE tte_m_layanan SET layanan='$nmlayanan',awal_no_surat='$awalan',no_urut='$urutan',akhir_no_surat='$akhiran' WHERE id_layanan='".$idlayanan."'";
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
