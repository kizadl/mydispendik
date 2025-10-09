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

$tglsurat = trim($_POST['tglsurat']);
$tglsurat = date('Y-m-d', strtotime($tglsurat));
$nosurat = strtoupper(anti_injection(trim($_POST['nosurat'])));

$nmsiswa = strtoupper(anti_injection(trim($_POST['nmsiswa'])));
$nik = anti_injection(trim($_POST['nik']));
$nis = strtoupper(anti_injection(trim($_POST['nis'])));
$kelas = strtoupper(anti_injection(trim($_POST['kelas'])));
$tmplahir = strtoupper(anti_injection(trim($_POST['tmplahir'])));
$tgllahir = trim($_POST['tgllahir']);
$tgllahir = date('Y-m-d', strtotime($tgllahir));
$kelamin = anti_injection(trim($_POST['kelamin']));
$agama = anti_injection(trim($_POST['agama']));
$nmortu = strtoupper(anti_injection(trim($_POST['nmortu'])));
$pekerjaanortu = strtoupper(anti_injection(trim($_POST['pekerjaanortu'])));
$noWA = anti_injection(trim($_POST['noWA']));

$nmsekolahasal = strtoupper(anti_injection(trim($_POST['nmsekolahasal'])));
$npsnasal = strtoupper(anti_injection(trim($_POST['npsnasal'])));
$nmsekolahmutasi = strtoupper(anti_injection(trim($_POST['nmsekolahmutasi'])));
$npsnmutasi = strtoupper(anti_injection(trim($_POST['npsnmutasi'])));
$alasanmutasi = anti_injection(trim($_POST['alasanmutasi']));

$nosuketpindah = strtoupper(anti_injection(trim($_POST['nosuketpindah'])));
$tglsuketpindah = trim($_POST['tglsuketpindah']);
$tglsuketpindah = date('Y-m-d', strtotime($tglsuketpindah));

$nosuketsanggup = strtoupper(anti_injection(trim($_POST['nosuketsanggup'])));
$tglsuketsanggup = trim($_POST['tglsuketsanggup']);
$tglsuketsanggup = date('Y-m-d', strtotime($tglsuketsanggup));

$ketrekom = trim($_POST['ketrekom']);
$rekomdari = strtoupper(anti_injection(trim($_POST['rekomdari'])));
$norekom = strtoupper(anti_injection(trim($_POST['norekom'])));
$tglrekom = trim($_POST['tglrekom']);
$tglrekom = date('Y-m-d', strtotime($tglrekom));

$pesanError = array();
if (trim($idinstansi) == "" or trim($idlayanan) == "") {
	$pesanError[] = "Instansi atau layanan tidak terdeteksi";
}
if (trim($idoperator) == "") {
	$pesanError[] = "Petugas operator tidak terdeteksi";
}
if (trim($tglsurat) == "") {
	$pesanError[] = "Tanggal surat tidak boleh kosong";
}
if (trim($nosurat) == "") {
	$pesanError[] = "Nomor surat tidak boleh kosong";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sqlCari = ("SELECT awal_no_surat,no_urut,akhir_no_surat FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
	$resultCari = mysqli_query($dbconn, $sqlCari);
	$s = mysqli_fetch_assoc($resultCari);
	$nourut = $s['no_urut'] + 1;
	$nosuratbaru = $s['awal_no_surat'] . $nourut . $s['akhir_no_surat'];

	$sql3  = "INSERT INTO tte_trans_mutasi_siswa (no_surat,tgl_surat,no_wa,nama_siswa,kelamin,tempat_lahir,tgl_lahir,agama,kelas,nis,nik,nama_ortu,pekerjaan_ortu,asal_sekolah,npsn_asal_sekolah,
	mutasi_ke,npsn_mutasi,alasan_mutasi,no_suket_mutasi,tgl_suket_mutasi,no_suket_pindah,tgl_suket_pindah
	,ket_level,waktu_opt_sekolah,waktu_create,waktu_update,id_opt_sekolah,id_layanan,id_sekolah) 
			VALUES ('$nosuratbaru','$tglsurat','$noWA','$nmsiswa','$kelamin','$tmplahir','$tgllahir','$agama','$kelas','$nis','$nik','$nmortu','$pekerjaanortu','$nmsekolahasal','$npsnasal',
			'$nmsekolahmutasi','$npsnmutasi','$alasanmutasi','$nosuketsanggup','$tglsuketsanggup','$nosuketpindah','$tglsuketpindah',
			'operator sekolah','$tglserver','$tglserver','$tglserver','$idoperator','$idlayanan','$idinstansi')";
	$res = mysqli_query($dbconn, $sql3);

	$sqlid = ("SELECT MAX(id_transaksi) AS idnyasurat FROM tte_trans_mutasi_siswa ORDER BY id_transaksi DESC");
	$resultCariID = mysqli_query($dbconn, $sqlid);
	$t = mysqli_fetch_assoc($resultCariID);
	$idsuratx = $t['idnyasurat'];

	$noorder = date('ymd') . "." . $idlayanan . "." . $idsuratx;
	$sqlOrder  = "UPDATE tte_trans_mutasi_siswa SET no_order='$noorder' WHERE id_transaksi='" . $idsuratx . "'";
	$res = mysqli_query($dbconn, $sqlOrder);

	$sql5  = "UPDATE tte_m_layanan SET no_urut='$nourut' WHERE id_layanan='" . $idlayanan . "'";
	$res = mysqli_query($dbconn, $sql5);

	$sqlx = ("SELECT id_persyaratan,mode_upload FROM tte_m_persyaratan WHERE aktif='Y' AND id_layanan='" . $idlayanan . "'");
	$result = mysqli_query($dbconn, $sqlx);
	while ($t = mysqli_fetch_array($result)) {
		$idpersyaratan = $t['id_persyaratan'];$modeupload = $t['mode_upload'];
		$sql6  = "INSERT INTO tte_detail_trans_persyaratan (id_transaksi,id_layanan,id_persyaratan,mode_upload,ket_persyaratan) 
			VALUES ('$idsuratx','$idlayanan','$idpersyaratan','$modeupload','TIDAK ADA')";
		$res = mysqli_query($dbconn, $sql6);
	}

	if ($ketrekom == 'ada') {
		$sqlrekom  = "UPDATE tte_trans_mutasi_siswa SET file_rekomendasi='ada',rekomendasi='$rekomdari',no_rekomendasi='$norekom',tgl_rekomendasi='$tglrekom' WHERE id_transaksi='" . $idsuratx . "'";
		$res = mysqli_query($dbconn, $sqlrekom);
	}

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-mutasi-siswa"))
		mkdir("../../../../data-layanan/data-qrcode-mutasi-siswa", 0777, true);

	$mdidsurat = md5($idsuratx);
	$tempdir = "../../../../data-layanan/data-qrcode-mutasi-siswa/";

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
mysqli_free_result($resultCari);
mysqli_free_result($resultCariID);
mysqli_close($dbconn);
