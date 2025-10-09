<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function hari_ini(){
	$hari = date ("D",strtotime(trim($_POST['tglinformasi'])));
 
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
	$idpengumuman = anti_injection(trim($_POST['idpengumuman']));
	$tglinformasi =trim($_POST['tglinformasi']);$tglinformasi = date('Y-m-d', strtotime($tglinformasi));
	$judul = anti_injection(trim($_POST['judul']));
	$headline = strtoupper(anti_injection(trim($_POST['headline'])));
	$isiinformasi = trim($_POST['isiinformasi']);
	$linkyoutube = anti_injection(trim($_POST['linkyoutube']));

	$pesanError = array();
	if (trim($idpengumuman)=="") {
		$pesanError[] = "ID pengumuman tidak terdeteksi";		
	}
	if (trim($tglinformasi)=="") {
		$pesanError[] = "Tanggal tidak boleh kosong";		
	}
	if (trim($judul)=="") {
		$pesanError[] = "Judul tidak boleh kosong";		
	}
	if (trim($headline)=="") {
		$pesanError[] = "Headline tidak boleh kosong";		
	}
	if (trim($isiinformasi)=="") {
		$pesanError[] = "Isi informasi tidak boleh kosong";		
	}
	if (trim($linkyoutube)=="") {
		$pesanError[] = "Link youtube tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		if ($headline == "Y"){
			$sql4  = "UPDATE podcast SET headline='N'";
			$res=mysqli_query($dbconn,$sql4);	
		}

		$sql3  = "UPDATE podcast SET judul='$judul',headline='$headline',isi_podcast='$isiinformasi',link_youtube='$linkyoutube',hari='$hariini',tanggal='$tglinformasi'
			WHERE id_podcast = '".$idpengumuman."'";
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
