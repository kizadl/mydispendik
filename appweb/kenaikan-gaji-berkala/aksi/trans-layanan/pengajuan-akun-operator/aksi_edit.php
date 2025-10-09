<?php
error_reporting(0);
require_once '../../../../services/config.php';
include "../../../../phpqrcode/qrlib.php"; //QR code
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d H:i:s');

$QRCodeUrl = trim($_POST['QRCodeUrl']);
$idoperator = anti_injection(trim($_POST['idoperator']));
$idtransaksi = anti_injection(trim($_POST['idtransaksi']));
$idinstansi = anti_injection(trim($_POST['idinstansi']));
$idlayanan = anti_injection(trim($_POST['idlayanan']));

$npsn = anti_injection(trim($_POST['npsn']));
$eseremail = anti_injection(trim($_POST['eseremail']));
$passwordx = anti_injection(trim($_POST['passwordx']));
$nmoperator = strtoupper(anti_injection(trim($_POST['nmoperator'])));
$noWA = anti_injection(trim($_POST['noWA']));

$nosk = strtoupper(anti_injection(trim($_POST['nosk'])));
$tglsk = anti_injection(trim($_POST['tglsk']));$tglsk = date('Y-m-d', strtotime($tglsk));

$pesanError = array();
if (trim($idinstansi) == "" or trim($idlayanan) == "") {
	$pesanError[] = "Instansi atau layanan tidak terdeteksi";
}
if (trim($idtransaksi) == "") {
	$pesanError[] = "Transaksi tidak terdeteksi";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql3  = "UPDATE tte_trans_pengajuan_akun_operator SET npsn='$npsn',user_email_lembaga='$eseremail',password_user='$passwordx',
		nm_operator='$nmoperator',no_sk_operator='$nosk',tgl_sk_operator='$tglsk',no_wa='$noWA',
		waktu_update=CURDATE() WHERE id_transaksi = '" . $idtransaksi . "'";
	$res = mysqli_query($dbconn, $sql3);

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-akun-operator"))
		mkdir("../../../../data-layanan/data-qrcode-akun-operator", 0777, true);

	$mdidsurat = md5($idtransaksi);
	$tempdir = "../../../../data-layanan/data-qrcode-akun-operator/";

	$isiteks = $QRCodeUrl . $mdidsurat . ".html";
	$namafile = $mdidsurat . ".png";
	$quality = 'H'; //L,M,Q,H
	$ukuran = 5; //batasan 1 - 10
	$padding = 0;
	QRCode::png($isiteks, $tempdir . $namafile, $quality, $ukuran, $padding);
	//////////////////////////////////////////////////////////

	if ($res) {
		$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($data);

mysqli_free_result($res);
mysqli_close($dbconn);
