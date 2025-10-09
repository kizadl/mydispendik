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
$leveltransaksi = anti_injection(trim($_POST['leveltransaksi']));
$leveloperator = anti_injection(trim($_POST['leveloperator']));

$statusaksioperator = anti_injection(trim($_POST['statusaksioperator']));
$levelnext = anti_injection(trim($_POST['levelnext']));

$nosurat = strtoupper(trim($_POST['nosurat']));

$pesanError = array();
if (trim($idtransaksi) == "") {
	$pesanError[] = "Data mutasi siswa tidak terdeteksi";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {


	$sql2  = "UPDATE tte_trans_mutasi_siswa SET ket_level='operator dapodik',stts_opt_sekolah='terkirim',waktu_opt_sekolah='$tglserver',waktu_update='$tglserver',id_opt_sekolah='$idoperator' WHERE id_transaksi='" . $idtransaksi . "'";
	$res = mysqli_query($dbconn, $sql2);

	$isistatus = $nosurat . " Terkirim ke operator dapodik";
	$sql3  = "INSERT INTO tte_detail_status (id_layanan,id_transaksi,isi_status,pengirim,nm_pengirim,waktu_status,id_sekolah) 
			VALUES ('$idlayanan','$idtransaksi','$isistatus','$leveloperator','$namaoperator','$tglserver','$idsekolah')";
	$res = mysqli_query($dbconn, $sql3);


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
mysqli_free_result($resbidang);
mysqli_close($dbconn);
