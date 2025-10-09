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
$idinstansi = anti_injection(trim($_POST['idinstansi']));
$idlayanan = anti_injection(trim($_POST['idlayanan']));
$idtransaksi = anti_injection(trim($_POST['idtransaksi']));

$nmkepsek = anti_injection(trim($_POST['nmkepsek']));
$nik = anti_injection(trim($_POST['nik']));
$nip = strtoupper(anti_injection(trim($_POST['nip'])));
$nuptk = strtoupper(anti_injection(trim($_POST['nuptk'])));
$sekolahasal = strtoupper(anti_injection(trim($_POST['sekolahasal'])));
$npsnasal = anti_injection(trim($_POST['npsnasal']));
$noWA = anti_injection(trim($_POST['noWA']));

$nmsekolahtugas = strtoupper(anti_injection(trim($_POST['nmsekolahtugas'])));
$npsntugas = strtoupper(anti_injection(trim($_POST['npsntugas'])));
$statuspenugasan = anti_injection(trim($_POST['statuspenugasan']));

$nosurattugas = strtoupper(anti_injection(trim($_POST['nosurattugas'])));
$tglsurattugas = trim($_POST['tglsurattugas']);
$tglsurattugas = date('Y-m-d', strtotime($tglsurattugas));
$tmtsurattugas = trim($_POST['tmtsurattugas']);
$tmtsurattugas = date('Y-m-d', strtotime($tmtsurattugas));

$chkijazah = anti_injection(trim($_POST['chkijazah']));
$namapt = strtoupper(anti_injection(trim($_POST['namapt'])));
$progstudy = strtoupper(anti_injection(trim($_POST['progstudy'])));
$noijazah = strtoupper(anti_injection(trim($_POST['noijazah'])));
$thnlulusijazah = anti_injection(trim($_POST['thnlulusijazah']));

$pesanError = array();
if (trim($idinstansi) == "" or trim($idlayanan) == "") {
	$pesanError[] = "Instansi atau layanan tidak terdeteksi";
}
if (trim($idoperator) == "") {
	$pesanError[] = "Petugas operator tidak terdeteksi";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	if ($chkijazah == "Y"){

		$sql3  = "UPDATE tte_trans_perubahan_ptk SET nama='$nmkepsek',nik='$nik',nip='$nip',nuptk='$nuptk',
		nm_sekolah='$sekolahasal',npsn='$npsnasal',no_wa='$noWA',
		ijazah_s1='Y',nm_pt='$namapt',prog_studi='$progstudy',no_ijazah='$noijazah',thn_lulus='$thnlulusijazah',
		waktu_update=CURDATE() WHERE id_transaksi = '" . $idtransaksi . "'";
		$res = mysqli_query($dbconn, $sql3);

	} else if ($chkijazah == "N"){

		$sql3  = "UPDATE tte_trans_perubahan_ptk SET nama='$nmkepsek',nik='$nik',nip='$nip',nuptk='$nuptk',
		nm_sekolah='$sekolahasal',npsn='$npsnasal',no_wa='$noWA',
		ijazah_s1='N',nm_pt=NULL,prog_studi=NULL,no_ijazah=NULL,thn_lulus=NULL,
		waktu_update=CURDATE() WHERE id_transaksi = '" . $idtransaksi . "'";
		$res = mysqli_query($dbconn, $sql3);

	}

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-perubahan-ptk"))
		mkdir("../../../../data-layanan/data-qrcode-perubahan-ptk", 0777, true);

	$mdidsurat = md5($idtransaksi);
	$tempdir = "../../../../data-layanan/data-qrcode-perubahan-ptk/";

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
?>