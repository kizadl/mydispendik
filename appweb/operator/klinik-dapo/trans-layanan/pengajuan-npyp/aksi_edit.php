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

$nmyayasan = strtoupper(anti_injection(trim($_POST['nmyayasan'])));
$nmpimpinan = anti_injection(trim($_POST['nmpimpinan']));

$propinsi = strtoupper(anti_injection(trim($_POST['propinsi'])));
$kota = strtoupper(anti_injection(trim($_POST['kota'])));
$kecamatan = strtoupper(anti_injection(trim($_POST['kecamatan'])));
$desa = strtoupper(anti_injection(trim($_POST['desa'])));
$idpropinsi = anti_injection(trim($_POST['idpropinsi']));
$idkota = anti_injection(trim($_POST['idkota']));
$idkecamatan = anti_injection(trim($_POST['idkecamatan']));
$iddesa = anti_injection(trim($_POST['iddesa']));

$dusun = strtoupper(anti_injection(trim($_POST['dusun'])));
$alamat = anti_injection(trim($_POST['alamat']));
$rt = strtoupper(anti_injection(trim($_POST['rt'])));
$rw = strtoupper(anti_injection(trim($_POST['rw'])));
$kodepos = anti_injection(trim($_POST['kodepos']));
$telepon = strtoupper(anti_injection(trim($_POST['telepon'])));
$fax = strtoupper(anti_injection(trim($_POST['fax'])));
$email = anti_injection(trim($_POST['email']));
$website = anti_injection(trim($_POST['website']));

$nopendirian = strtoupper(anti_injection(trim($_POST['nopendirian'])));
$tglpendirian = trim($_POST['tglpendirian']);
$tglpendirian = date('Y-m-d', strtotime($tglpendirian));
$nopengesahanpn = strtoupper(anti_injection(trim($_POST['nopengesahanpn'])));
$noskBH = strtoupper(anti_injection(trim($_POST['noskBH'])));
$tglskBH = trim($_POST['tglskBH']);
$tglskBH = date('Y-m-d', strtotime($tglskBH));

$lokasi = anti_injection(trim($_POST['lokasi']));
$noWA = anti_injection(trim($_POST['noWA']));

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

	$sql3  = "UPDATE tte_trans_pengajuan_npyp SET nm_yayasan='$nmyayasan',nm_pimpinan='$nmpimpinan',propinsi='$propinsi',
			kota='$kota',kecamatan='$kecamatan',desa='$desa',
			dusun='$dusun',alamat='$alamat',rw='$rw',rt='$rt',kode_pos='$kodepos',
			no_telepon='$telepon',no_fax='$fax',email='$email',website='$website',
			no_pendirian='$nopendirian',tgl_pendirian='$tglpendirian',no_pengesahan_pn='$nopengesahanpn',
			no_sk_menkumham='$noskBH',tgl_sk_menkumham='$tglskBH',lokasi='$lokasi',no_wa='$noWA',
			id_propinsi='$idpropinsi',id_kota='$idkota',id_kecamatan='$idkecamatan',id_desa='$iddesa',
			waktu_update=CURDATE() WHERE id_transaksi = '" . $idtransaksi . "'";
	$res = mysqli_query($dbconn, $sql3);

	//////////////// QRCODE //////////////////			
	if (!is_dir("../../../../data-layanan/data-qrcode-pengajuan-npyp"))
		mkdir("../../../../data-layanan/data-qrcode-pengajuan-npyp", 0777, true);

	$mdidsurat = md5($idtransaksi);
	$tempdir = "../../../../data-layanan/data-qrcode-pengajuan-npyp/";

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
