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

$nmsiswa = strtoupper(anti_injection(trim($_POST['nmsiswa'])));
$nik = anti_injection(trim($_POST['nik']));
$tmplahir = strtoupper(anti_injection(trim($_POST['tmplahir'])));
$tgllahir = trim($_POST['tgllahir']);
$tgllahir = date('Y-m-d', strtotime($tgllahir));
$kelamin = anti_injection(trim($_POST['kelamin']));
$agama = anti_injection(trim($_POST['agama']));
$wn = strtoupper(anti_injection(trim($_POST['wn'])));
$nmibukandung = strtoupper(anti_injection(trim($_POST['nmibukandung'])));
$noWA = anti_injection(trim($_POST['noWA']));

$alamat = trim($_POST['alamat']);
$propinsi = strtoupper(anti_injection(trim($_POST['propinsi'])));
$kota = strtoupper(anti_injection(trim($_POST['kota'])));
$kecamatan = strtoupper(anti_injection(trim($_POST['kecamatan'])));
$desa = strtoupper(anti_injection(trim($_POST['desa'])));

$idpropinsi = anti_injection(trim($_POST['idpropinsi']));
$idkota = anti_injection(trim($_POST['idkota']));
$idkecamatan = anti_injection(trim($_POST['idkecamatan']));
$iddesa = anti_injection(trim($_POST['iddesa']));

$nmsekolah = strtoupper(anti_injection(trim($_POST['nmsekolah'])));
$npsn = strtoupper(anti_injection(trim($_POST['npsn'])));
$nisn = strtoupper(anti_injection(trim($_POST['nisn'])));
$rombel = strtoupper(anti_injection(trim($_POST['rombel'])));

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

	$sql3  = "INSERT INTO tte_trans_verifikasi_pdb_mi (nama_siswa,nik,nisn,nm_sekolah,npsn,rombel,
			kelamin,tempat_lahir,tgl_lahir,nm_ibu_kandung,agama,kewarganegaraan,no_wa,
			alamat,desa,kecamatan,kabupaten,propinsi,
			ket_level,waktu_opt_sekolah,waktu_create,waktu_update,id_opt_sekolah,id_layanan,id_sekolah,id_propinsi,id_kota,id_kecamatan,id_desa) 
			VALUES ('$nmsiswa','$nik','$nisn','$nmsekolah','$npsn','$rombel','$kelamin','$tmplahir','$tgllahir','$nmibukandung','$agama','$wn','$noWA',
			'$alamat','$desa','$kecamatan','$kota','$propinsi',
			'operator sekolah','$tglserver','$tglserver','$tglserver','$idoperator','$idlayanan','$idinstansi','$idpropinsi','$idkota','$idkecamatan','$iddesa')";
	$res = mysqli_query($dbconn, $sql3);

	$sqlid = ("SELECT MAX(id_transaksi) AS idnyasurat FROM tte_trans_verifikasi_pdb_mi ORDER BY id_transaksi DESC");
	$resultCariID = mysqli_query($dbconn, $sqlid);
	$t = mysqli_fetch_assoc($resultCariID);
	$idsuratx = $t['idnyasurat'];

	$noorder = date('ymd') . "." . $idlayanan . "." . $idsuratx;
	$sqlOrder  = "UPDATE tte_trans_verifikasi_pdb_mi SET no_order='$noorder' WHERE id_transaksi='" . $idsuratx . "'";
	$res = mysqli_query($dbconn, $sqlOrder);

	$sqlx = ("SELECT id_persyaratan,mode_upload FROM tte_m_persyaratan WHERE aktif='Y' AND id_layanan='" . $idlayanan . "'");
	$result = mysqli_query($dbconn, $sqlx);
	while ($t = mysqli_fetch_array($result)) {
		$idpersyaratan = $t['id_persyaratan'];$modeupload = $t['mode_upload'];
		$sql6  = "INSERT INTO tte_detail_trans_persyaratan (id_transaksi,id_layanan,id_persyaratan,mode_upload,ket_persyaratan) 
			VALUES ('$idsuratx','$idlayanan','$idpersyaratan','$modeupload','TIDAK ADA')";
		$res = mysqli_query($dbconn, $sql6);
	}

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-pdb-mi"))
		mkdir("../../../../data-layanan/data-qrcode-pdb-mi", 0777, true);

	$mdidsurat = md5($idsuratx);
	$tempdir = "../../../../data-layanan/data-qrcode-pdb-mi/";

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
