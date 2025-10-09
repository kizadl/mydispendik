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

$nmsekolah = strtoupper(anti_injection(trim($_POST['nmsekolah'])));
$alamat = anti_injection(trim($_POST['alamat']));
$propinsi = strtoupper(anti_injection(trim($_POST['propinsi'])));
$kota = strtoupper(anti_injection(trim($_POST['kota'])));
$kecamatan = strtoupper(anti_injection(trim($_POST['kecamatan'])));
$desa = strtoupper(anti_injection(trim($_POST['desa'])));

$idpropinsi = anti_injection(trim($_POST['idpropinsi']));
$idkota = anti_injection(trim($_POST['idkota']));
$idkecamatan = anti_injection(trim($_POST['idkecamatan']));
$iddesa = anti_injection(trim($_POST['iddesa']));

$jenjang = anti_injection(trim($_POST['jenjang']));
$status = anti_injection(trim($_POST['status']));
$kepemilikan = anti_injection(trim($_POST['kepemilikan']));
$luasmilik = anti_injection(trim($_POST['luasmilik']));
$luasnonmilik = anti_injection(trim($_POST['luasnonmilik']));
$noWA = anti_injection(trim($_POST['noWA']));

$noskoperasional = strtoupper(anti_injection(trim($_POST['noskoperasional'])));
$tglskoperasional = trim($_POST['tglskoperasional']);$tglskoperasional = date('Y-m-d', strtotime($tglskoperasional));
$tglselesaisk = trim($_POST['tglselesaisk']);$tglselesaisk = date('Y-m-d', strtotime($tglselesaisk));
$noskpendirian = strtoupper(anti_injection(trim($_POST['noskpendirian'])));
$tglskpendirian = trim($_POST['tglskpendirian']);$tglskpendirian = date('Y-m-d', strtotime($tglskpendirian));
$lonlat = anti_injection(trim($_POST['lonlat']));

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

	$sql3  = "UPDATE tte_trans_pengajuan_npsn SET nama='$nmsekolah',alamat='$alamat',desa='$desa',kecamatan='$kecamatan',kabupaten='$kota',propinsi='$propinsi',
		jenjang='$jenjang',status_sekolah='$status',kepemilikan='$kepemilikan',luas_tanah_milik='$luasmilik',luas_tanah_bukan_milik='$luasnonmilik',
		no_sk_operasional='$noskoperasional',tgl_sk_operasional='$tglskoperasional',tgl_selesai_sk_operasional='$tglselesaisk',
		no_sk_pendirian='$noskpendirian',tgl_sk_pendirian='$tglskpendirian',lonlat_lokasi='$lonlat',no_wa='$noWA',
		id_propinsi='$idpropinsi',id_kabupaten='$idkota',id_kecamatan='$idkecamatan',id_desa='$iddesa',
		waktu_update=CURDATE() WHERE id_transaksi = '" . $idtransaksi . "'";
	$res = mysqli_query($dbconn, $sql3);

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-pengajuan-npsn"))
		mkdir("../../../../data-layanan/data-qrcode-pengajuan-npsn", 0777, true);

	$mdidsurat = md5($idtransaksi);
	$tempdir = "../../../../data-layanan/data-qrcode-pengajuan-npsn/";

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
