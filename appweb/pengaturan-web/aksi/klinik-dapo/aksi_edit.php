<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function hari_ini(){
	$hari = date ("D",strtotime(trim($_POST['tglsambutan'])));
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini ;
 
}

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set('Asia/Jakarta');	
$jam = date('H:i:s');

	$hariini = hari_ini();
	$tglsambutan =trim($_POST['tglsambutan']);$tglsambutan = date('Y-m-d', strtotime($tglsambutan));
	$judul = anti_injection(trim($_POST['judul']));
	$isisambutan = trim($_POST['isisambutan']);

	$pesanError = array();
	if (trim($tglsambutan)=="") {
		$pesanError[] = "Tanggal tidak boleh kosong";		
	}
	if (trim($judul)=="") {
		$pesanError[] = "Judul tidak boleh kosong";		
	}
	if (trim($isisambutan)=="") {
		$pesanError[] = "Isi klinik tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql3  = "UPDATE klinik_dapo SET judul='$judul',isi_klinik='$isisambutan',hari='$hariini',tanggal='$tglsambutan'
			WHERE id_klinik = '1'";
			$res=mysqli_query($dbconn,$sql3);	

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
