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
if (trim($idtransaksi) == "") {
	$pesanError[] = "Transaksi tidak terdeteksi";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql3  = "UPDATE tte_trans_verifikasi_pdb_mi SET nama_siswa='$nmsiswa',nik='$nik',nisn='$nisn',nm_sekolah='$nmsekolah',npsn='$npsn',
		rombel='$rombel',kelamin='$kelamin',tempat_lahir='$tmplahir',tgl_lahir='$tgllahir',nm_ibu_kandung='$nmibukandung',agama='$agama',
		kewarganegaraan='$wn',no_wa='$noWA',alamat='$alamat',desa='$desa',
		kecamatan='$kecamatan',kabupaten='$kota',propinsi='$propinsi',
		id_propinsi='$idpropinsi',id_kota='$idkota',id_kecamatan='$idkecamatan',id_desa='$iddesa',
		waktu_update=CURDATE() WHERE id_transaksi = '" . $idtransaksi . "'";
	$res = mysqli_query($dbconn, $sql3);

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-pdb-mi"))
		mkdir("../../../../data-layanan/data-qrcode-pdb-mi", 0777, true);

	$mdidsurat = md5($idtransaksi);
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
mysqli_close($dbconn);
