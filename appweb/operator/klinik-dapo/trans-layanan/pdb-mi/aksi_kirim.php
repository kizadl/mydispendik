<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d H:i:s');

$idoperator = anti_injection(trim($_POST['idoperator']));
$namaoperator = anti_injection(trim($_POST['namaoperator']));
$idsekolah = anti_injection(trim($_POST['idsekolah']));
$idtransaksi = anti_injection(trim($_POST['idtransaksi']));
$idlayanan = anti_injection(trim($_POST['idlayanan']));

$namasiswa = ucwords(strtolower(anti_injection(trim($_POST['namasiswa']))));
$noorder = strtoupper(anti_injection(trim($_POST['noorder'])));

$modetransaksi = anti_injection(trim($_POST['modetransaksi']));

$levelsurat = anti_injection(trim($_POST['levelsurat']));
$leveloperator = anti_injection(trim($_POST['leveloperator']));

$alasantolak = anti_injection(trim($_POST['alasantolak']));
$modetransaksi = anti_injection(trim($_POST['modetransaksi']));

$pesanError = array();
if (trim($idtransaksi) == "") {
	$pesanError[] = "Data transaksi tidak terdeteksi";
}
if (trim($idlayanan) == "") {
	$pesanError[] = "Data bidang tidak terdeteksi";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	if ($modetransaksi == "tolak") {
		$sql2  = "UPDATE tte_trans_verifikasi_pdb_mi SET ket_level='$leveloperator',stts_opt_dapodik='tolak',ket_status_akhir='tolak',waktu_opt_dapodik='$tglserver',waktu_update='$tglserver',id_opt_dapodik='$idoperator',nm_operator_dapodik='$namaoperator' WHERE id_transaksi='" . $idtransaksi . "'";
		$res = mysqli_query($dbconn, $sql2);

		$sqltolak  = "INSERT INTO tte_detail_tolak (id_transaksi,id_layanan,catatan_tolak,ket_level,waktu_tolak,status_akhir,id_verifikator) VALUES ('$idtransaksi','$idlayanan','$alasantolak','$leveloperator','$tglserver','tolak','$idoperator')";
		$res = mysqli_query($dbconn, $sqltolak);

	} else if ($modetransaksi == "terima") {
		$sql2  = "UPDATE tte_trans_verifikasi_pdb_mi SET ket_level='$leveloperator',stts_opt_dapodik='terima',ket_status_akhir='terima',waktu_opt_dapodik='$tglserver',waktu_update='$tglserver',id_opt_dapodik='$idoperator',nm_operator_dapodik='$namaoperator' WHERE id_transaksi='" . $idtransaksi . "'";
		$res = mysqli_query($dbconn, $sql2);
	}

	$isistatus = $noorder." - ".$namasiswa." Status Di".$modetransaksi." ".ucwords(strtolower($leveloperator));
	$sql3  = "INSERT INTO tte_detail_status (id_layanan,id_transaksi,isi_status,pengirim,nm_pengirim,waktu_status,id_sekolah) 
			VALUES ('$idlayanan','$idtransaksi','$isistatus','$leveloperator','$namaoperator','$tglserver','$idsekolah')";
			$res=mysqli_query($dbconn,$sql3);	

	if ($res) {
		$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($errMsg);

mysqli_free_result($res);
mysqli_close($dbconn);
