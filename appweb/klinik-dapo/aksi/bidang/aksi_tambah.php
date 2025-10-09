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

	$nmbidang = anti_injection(trim($_POST['nmbidang']));
	$nmpejabat = anti_injection(trim($_POST['nmpejabat']));
	$jabatan = anti_injection(trim($_POST['jabatan']));
	$pangkat = strtoupper(anti_injection(trim($_POST['pangkat'])));	
	$nip = anti_injection(trim($_POST['nip']));
	$nik = anti_injection(trim($_POST['nik']));

	$lokasi_akta    = $_FILES['upTTDKadis']['tmp_name'];

	$username = strtolower(anti_injection(trim($_POST['nik'])));$username = preg_replace('/\s+/', '', $username);
	$password = md5($_POST['nik']);
	
	$sqlX = ("SELECT nm_bidang FROM tte_m_bidang WHERE nm_bidang='".$nmbidang."' OR nik='".$nik."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['nm_bidang'])==strtolower($nmbidang)) {
		$pesanError[] = ucwords(strtolower($nmbidang))." terdeteksi sudah ada\nInput data bidang tidak boleh sama";	
	}		
	if (trim($nmbidang)=="") {
		$pesanError[] = "Data Bidang Tidak Terdeteksi";		
	}
	if (trim($nmpejabat)=="") {
		$pesanError[] = "Data Kepala Bidang Tidak Terdeteksi";		
	}
	if (trim($jabatan)=="") {
		$pesanError[] = "Data jabatan tidak boleh kosong";		
	}	
	if (trim($pangkat)=="") {
		$pesanError[] = "Data pangkat tidak boleh kosong";		
	}	
	if (trim($nip)=="") {
		$pesanError[] = "Data nip tidak boleh kosong";		
	}	
	if (trim($nik)=="") {
		$pesanError[] = "Data nik tidak boleh kosong";		
	}	
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "INSERT INTO tte_m_bidang (nm_bidang,nm_pejabat,jabatan,pangkat,nip,nik,username,password) VALUES ('$nmopd','$nmpejabat','$jabatan','$pangkat','$nip','$nik','$username','$password')";
		$res=mysqli_query($dbconn,$sql2);

		$qri = ("SELECT MAX(id_bidang) AS idneopd FROM tte_m_bidang ORDER BY id_bidang DESC");
		$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
		$idneopd = $c['idneopd'];

		if(!is_dir("../../../data-ttd/bidang"))
		mkdir("../../../data-ttd/bidang",0777,true); 
		$path1 = "../../../data-ttd/bidang/".$idneopd.".png";	
		
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
	mysqli_free_result($resultx);mysqli_free_result($dbquery);
	mysqli_close($dbconn);
?>
