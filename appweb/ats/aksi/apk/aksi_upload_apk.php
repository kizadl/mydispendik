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
$tglserver = date('Y-m-d');

	$versiapk = ucwords(strtolower(anti_injection(trim($_POST['versiapk']))));
	$tglrilis = trim($_POST['tglrilis']);
	$tglrilis = date('Y-m-d', strtotime($tglrilis));

	$lokasi_akta = $_FILES['upDistribusiAPK']['tmp_name'];
	$lokasi_tutor = $_FILES['upTutorial']['tmp_name'];

	$pesanError = array();
	if (trim($versiapk)=="") {
		$pesanError[] = "Versi rilis tidak boleh kosong";		
	}
	if (trim($tglrilis)=="") {
		$pesanError[] = "Tanggal rilis tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	
	
		$sql2  = "UPDATE m_versi_apk SET aktif='N' WHERE ket_apk='ats'";
		$res=mysqli_query($dbconn,$sql2);	

		$sql3  = "INSERT INTO m_versi_apk (versi_apk,tgl_rilis,ket_apk) VALUES ('$versiapk','$tglrilis','ats')";
		$res = mysqli_query($dbconn, $sql3);

		$qriup = ("SELECT MAX(id_versi) AS idupload FROM m_versi_apk ORDER BY id_versi DESC");
		$dbupload = mysqli_query($dbconn, $qriup);
		$b = mysqli_fetch_assoc($dbupload);
		$idupload = $b['idupload'];

		if(!is_dir("../../../data-apk/".$idupload))
		mkdir("../../../data-apk/".$idupload,0777,true); 
		$path1 = "../../../data-apk/".$idupload."/".$versiapk.".rar";	
		$path2 = "../../../data-apk/".$idupload."/".$versiapk.".pdf";	
			
		if (!($lokasi_akta)==''){
			move_uploaded_file($lokasi_akta, $path1);
		}

		if (!($lokasi_tutor)==''){
			move_uploaded_file($lokasi_tutor, $path2);
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
