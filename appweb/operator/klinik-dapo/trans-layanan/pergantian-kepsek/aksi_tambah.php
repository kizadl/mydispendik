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

		$sql3  = "INSERT INTO tte_trans_pergantian_kepsek (nama,nik,nip,nuptk,
			nm_sekolah_asal,npsn_asal,no_wa,
			nm_sekolah_tugas,npsn_tugas,stts_penugasan,
			no_surat_tugas,tgl_surat_tugas,tmt_surat_tugas,
			ijazah_s1,nm_pt,prog_studi,no_ijazah,thn_lulus,
			ket_level,waktu_opt_sekolah,waktu_create,waktu_update,id_opt_sekolah,id_layanan,id_sekolah) 
			VALUES ('$nmkepsek','$nik','$nip','$nuptk',
			'$sekolahasal','$npsnasal','$noWA',
			'$nmsekolahtugas','$npsntugas','$statuspenugasan',
			'$nosurattugas','$tglsurattugas','$tmtsurattugas',
			'Y','$namapt','$progstudy','$noijazah','$thnlulusijazah',
			'operator sekolah','$tglserver','$tglserver','$tglserver','$idoperator','$idlayanan','$idinstansi')";
		$res = mysqli_query($dbconn, $sql3);

	} else if ($chkijazah == "N"){

		$sql3  = "INSERT INTO tte_trans_pergantian_kepsek (nama,nik,nip,nuptk,
			nm_sekolah_asal,npsn_asal,no_wa,
			nm_sekolah_tugas,npsn_tugas,stts_penugasan,
			no_surat_tugas,tgl_surat_tugas,tmt_surat_tugas,
			ijazah_s1,
			ket_level,waktu_opt_sekolah,waktu_create,waktu_update,id_opt_sekolah,id_layanan,id_sekolah) 
			VALUES ('$nmkepsek','$nik','$nip','$nuptk',
			'$sekolahasal','$npsnasal','$noWA',
			'$nmsekolahtugas','$npsntugas','$statuspenugasan',
			'$nosurattugas','$tglsurattugas','$tmtsurattugas',
			'N',
			'operator sekolah','$tglserver','$tglserver','$tglserver','$idoperator','$idlayanan','$idinstansi')";
		$res = mysqli_query($dbconn, $sql3);

	}

	$sqlid = ("SELECT MAX(id_transaksi) AS idnyasurat FROM tte_trans_pergantian_kepsek ORDER BY id_transaksi DESC");
	$resultCariID = mysqli_query($dbconn, $sqlid);
	$t = mysqli_fetch_assoc($resultCariID);
	$idsuratx = $t['idnyasurat'];

	$noorder = date('ymd') . "." . $idlayanan . "." . $idsuratx;
	$sqlOrder  = "UPDATE tte_trans_pergantian_kepsek SET no_order='$noorder' WHERE id_transaksi='" . $idsuratx . "'";
	$res = mysqli_query($dbconn, $sqlOrder);

	$sqlx = ("SELECT id_persyaratan,mode_upload FROM tte_m_persyaratan WHERE aktif='Y' AND id_layanan='" . $idlayanan . "'");
	$result = mysqli_query($dbconn, $sqlx);
	while ($t = mysqli_fetch_array($result)) {
		$idpersyaratan = $t['id_persyaratan'];
		$modeupload = $t['mode_upload'];
		$sql6  = "INSERT INTO tte_detail_trans_persyaratan (id_transaksi,id_layanan,id_persyaratan,mode_upload,ket_persyaratan) 
			VALUES ('$idsuratx','$idlayanan','$idpersyaratan','$modeupload','TIDAK ADA')";
		$res = mysqli_query($dbconn, $sql6);
	}

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-pergantian-kepsek"))
		mkdir("../../../../data-layanan/data-qrcode-pergantian-kepsek", 0777, true);

	$mdidsurat = md5($idsuratx);
	$tempdir = "../../../../data-layanan/data-qrcode-pergantian-kepsek/";

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
mysqli_free_result($resultCariID);
mysqli_close($dbconn);
