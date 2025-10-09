<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

	$idfaq = anti_injection(trim($_POST['idfaq']));
	$judul = anti_injection(trim($_POST['judul']));
	$isiuraianfaq = trim($_POST['isiuraianfaq']);

	$pesanError = array();
	if (trim($idfaq)=="") {
		$pesanError[] = "ID FAQ tidak terdeteksi";		
	}
	if (trim($judul)=="") {
		$pesanError[] = "Judul tidak boleh kosong";		
	}
	if (trim($isiuraianfaq)=="") {
		$pesanError[] = "Isi uraian faq tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql3  = "UPDATE faq_ppdb SET judul_faq='$judul',uraian_faq='$isiuraianfaq'
			WHERE id_faq = '".$idfaq."'";
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
