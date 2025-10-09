<?php
error_reporting(0);
require_once '../../../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

require_once '../../../../../services/csrf_helper.php';
header('Content-Type: application/json');
validate_csrf_token_or_exit($_POST['csrfToken'] ?? '');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set('Asia/Jakarta');	
$tglserver = date('Y-m-d H:i:s');

	$idoperator = anti_injection(trim($_POST['idoperator']));
	$pengirim = anti_injection(trim($_POST['pengirim']));
	$idtransaksi = anti_injection(trim($_POST['idtransaksi']));
	$idlayanan = anti_injection(trim($_POST['idlayanan']));
	$isipesan = anti_injection(trim($_POST['isipesan']));
	$idsekolah = anti_injection(trim($_POST['idsekolah']));

	$tglpesan = date('Y-m-d H:i:s');

	$pesanError = array();
	if (trim($idtransaksi)=="" OR trim($idlayanan)=="") {
		$pesanError[] = "Data mutasi siswa tidak terdeteksi";		
	}
	if (trim($idoperator)=="") {
		$pesanError[] = "Petugas operator tidak terdeteksi";		
	}
	if (trim($pengirim)=="") {
		$pesanError[] = "Pengirim tidak terdeteksi";		
	}
	if (trim($isipesan)=="") {
		$pesanError[] = "Isi pesan tidak boleh kosong";		
	}
	if (trim($idsekolah)=="") {
		$pesanError[] = "Data sekolah tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql3  = "INSERT INTO pesan_pengaduan_dapodik (id_transaksi,isi_pesan,pengirim,waktu_pesan,id_operator,id_sekolah) 
			VALUES ('$idtransaksi','$isipesan','$pengirim',NOW(),'$idoperator','$idsekolah')";
			$res=mysqli_query($dbconn,$sql3);	

		if($res){
			$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}	
	
	$new_token = rotate_csrf_token();
	$data = array('msg1'=>$errMsg,'msg2'=>$status, 'new_token' => $new_token);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>
