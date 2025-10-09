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

	$idseksi = anti_injection(trim($_POST['idseksi']));
	$nmseksi = anti_injection(trim($_POST['nmseksi']));
	$idbidang = anti_injection(trim($_POST['idbidang']));
	$nmpejabat = anti_injection(trim($_POST['nmpejabat']));
	$jabatan = anti_injection(trim($_POST['jabatan']));
	$pangkat = strtoupper(anti_injection(trim($_POST['pangkat'])));	
	$nip = anti_injection(trim($_POST['nip']));
	$nik = anti_injection(trim($_POST['nik']));

	$password = md5($nik);

	$username = strtolower(anti_injection(trim($_POST['nik'])));$username = preg_replace('/\s+/', '', $username);

	$sqlX = ("SELECT nm_seksi FROM tte_m_seksi WHERE nm_seksi='".$nmseksi."' AND id_seksi <> '".$idseksi."' OR nik='".$nik."' AND id_seksi <> '".$idseksi."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['nm_seksi'])==strtolower($nmseksi)) {
		$pesanError[] = ucwords(strtolower($nmseksi))." terdeteksi sudah ada\nEdit data seksi tidak boleh sama";	
	}	
	if (trim($idseksi)=="") {
		$pesanError[] = "Data Identitas Seksi Tidak Terdeteksi !";		
	}
	if (trim($nmseksi)=="") {
		$pesanError[] = "Data Seksi Tidak Terdeteksi";		
	}
	if (trim($idbidang)=="") {
		$pesanError[] = "Data Bidang Tidak Terdeteksi";		
	}
	if (trim($nmpejabat)=="") {
		$pesanError[] = "Data Kepala Seksi Tidak Terdeteksi";		
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
	
		$sql2  = "UPDATE tte_m_seksi SET nm_seksi='$nmseksi',id_bidang='$idbidang',nm_pejabat='$nmpejabat',jabatan='$jabatan',pangkat='$pangkat',nip='$nip',nik='$nik',username='$username',password='$password' WHERE id_seksi='".$idseksi."'";
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
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>
