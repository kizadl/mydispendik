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

$sql3  = "UPDATE tte_trans_mutasi_siswa SET no_surat='$nosurat',tgl_surat='$tglsurat',no_wa='$noWA',nama_siswa='$nmsiswa',kelamin='$kelamin',
		tempat_lahir='$tmplahir',tgl_lahir='$tgllahir',agama='$agama',kelas='$kelas',nis='$nis',nik='$nik',
		nama_ortu='$nmortu',pekerjaan_ortu='$pekerjaanortu',asal_sekolah='$nmsekolahasal',npsn_asal_sekolah='$npsnasal',
		mutasi_ke='$nmsekolahmutasi',npsn_mutasi='$npsnmutasi',alasan_mutasi='$alasanmutasi',
		no_suket_mutasi='$nosuketsanggup',tgl_suket_mutasi='$tglsuketsanggup',no_suket_pindah='$nosuketpindah',tgl_suket_pindah='$tglsuketpindah',
		waktu_update=CURDATE() WHERE id_transaksi = '".$idtransaksi."'";
		$res = mysqli_query($dbconn, $sql3);

if ($ketrekom == 'ada') {
	$sqlrekom  = "UPDATE tte_trans_mutasi_siswa SET file_rekomendasi='ada',rekomendasi='$rekomdari',no_rekomendasi='$norekom',tgl_rekomendasi='$tglrekom' WHERE id_transaksi='" . $idtransaksi . "'";
	$res = mysqli_query($dbconn, $sqlrekom);
}

//////////////// QRCODE //////////////////			
if (!is_dir("../../../../data-layanan/data-qrcode-mutasi-siswa"))
	mkdir("../../../../data-layanan/data-qrcode-mutasi-siswa", 0777, true);

$mdidsurat = md5($idtransaksi);
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
mysqli_close($dbconn);
?>