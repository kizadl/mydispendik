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

	$sql3  = "INSERT INTO tte_trans_pengajuan_npyp (nm_yayasan,nm_pimpinan,propinsi,kota,kecamatan,desa,
			dusun,alamat,rw,rt,kode_pos,no_telepon,no_fax,email,website,
			no_pendirian,tgl_pendirian,no_pengesahan_pn,
			no_sk_menkumham,tgl_sk_menkumham,lokasi,no_wa,
			ket_level,waktu_opt_sekolah,waktu_create,waktu_update,id_opt_sekolah,id_layanan,id_sekolah,id_propinsi,id_kota,id_kecamatan,id_desa) 
			VALUES ('$nmyayasan','$nmpimpinan','$propinsi','$kota','$kecamatan','$desa',
			'$dusun','$alamat','$rw','$rt','$kodepos','$telepon','$fax','$email','$website',
			'$nopendirian','$tglpendirian','$nopengesahanpn',
			'$noskBH','$tglskBH','$lokasi','$noWA',
			'operator sekolah','$tglserver','$tglserver','$tglserver','$idoperator','$idlayanan','$idinstansi','$idpropinsi','$idkota','$idkecamatan','$iddesa')";
	$res = mysqli_query($dbconn, $sql3);

	$sqlid = ("SELECT MAX(id_transaksi) AS idnyasurat FROM tte_trans_pengajuan_npyp ORDER BY id_transaksi DESC");
	$resultCariID = mysqli_query($dbconn, $sqlid);
	$t = mysqli_fetch_assoc($resultCariID);
	$idsuratx = $t['idnyasurat'];

	$noorder = date('ymd') . "." . $idlayanan . "." . $idsuratx;
	$sqlOrder  = "UPDATE tte_trans_pengajuan_npyp SET no_order='$noorder' WHERE id_transaksi='" . $idsuratx . "'";
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
	if (!is_dir("../../../../data-layanan/data-qrcode-pengajuan-npyp"))
		mkdir("../../../../data-layanan/data-qrcode-pengajuan-npyp", 0777, true);

	$mdidsurat = md5($idsuratx);
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
mysqli_free_result($resultCariID);
mysqli_close($dbconn);
