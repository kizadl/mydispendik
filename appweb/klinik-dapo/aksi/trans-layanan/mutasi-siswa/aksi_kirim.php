<?php
error_reporting(0);
require_once '../../../../services/config.php';
require_once '../../../../dompdf/autoload.inc.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d H:i:s');

$idoperator = anti_injection(trim($_POST['idoperator']));
$namaoperator = anti_injection(trim($_POST['namaoperator']));
$idsekolah = anti_injection(trim($_POST['idsekolah']));
$idbidang = anti_injection(trim($_POST['idbidang']));
$idtransaksi = anti_injection(trim($_POST['idtransaksi']));
$idlayanan = anti_injection(trim($_POST['idlayanan']));
$leveltransaksi = anti_injection(trim($_POST['leveltransaksi']));
$leveloperator = anti_injection(trim($_POST['leveloperator']));

$statusaksioperator = anti_injection(trim($_POST['statusaksioperator']));
$levelnext = anti_injection(trim($_POST['levelnext']));

$nosurat = strtoupper(trim($_POST['nosurat']));

$sqlbidang = ("SELECT nm_bidang,nm_pejabat,jabatan,nip FROM tte_m_bidang WHERE id_bidang='" . $idbidang . "'");
$resbidang = mysqli_query($dbconn, $sqlbidang);
$bd = mysqli_fetch_assoc($resbidang);
$nmbidang = $bd['nm_bidang'];
$nmpejabat = $bd['nm_pejabat'];
$jabatan = $bd['jabatan'];
$nip = $bd['nip'];

$pesanError = array();
if (trim($idtransaksi) == "") {
	$pesanError[] = "Data mutasi siswa tidak terdeteksi";
}
if (trim($idbidang) == "") {
	$pesanError[] = "Data bidang tidak terdeteksi";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	if ($statusaksioperator == "belum") {
		$sql2  = "UPDATE tte_trans_mutasi_siswa SET id_bidang='$idbidang',nm_bidang='$nmbidang',nm_kabid='$nmpejabat',jabatan_kabid='$jabatan',nip_kabid='$nip',ket_level='$levelnext',stts_opt_dapodik='terkirim',waktu_opt_dapodik='$tglserver',waktu_update='$tglserver',id_opt_dapodik='$idoperator',nm_operator_dapodik='$namaoperator' WHERE id_transaksi='" . $idtransaksi . "'";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($statusaksioperator == "terkirim") {
		$sql2  = "UPDATE tte_trans_mutasi_siswa SET id_bidang='$idbidang',nm_bidang='$nmbidang',nm_kabid='$nmpejabat',jabatan_kabid='$jabatan',nip_kabid='$nip',waktu_update='$tglserver' WHERE id_transaksi='" . $idtransaksi . "'";
		$res = mysqli_query($dbconn, $sql2);
	}

	$isistatus = $nosurat." Terkirim ke ".ucwords(strtolower($levelnext." - ".$nmbidang));
	$sql3  = "INSERT INTO tte_detail_status (id_layanan,id_transaksi,isi_status,pengirim,nm_pengirim,waktu_status,id_sekolah) 
			VALUES ('$idlayanan','$idtransaksi','$isistatus','$leveloperator','$namaoperator','$tglserver','$idsekolah')";
			$res=mysqli_query($dbconn,$sql3);	

	$dompdf = new Dompdf\Dompdf();
	//$html = file_get_contents("https://jelita-dpmptsp.jemberkab.go.id/operator/printsuratpdf-".$idlayanan."-".$mdsurat.".html");
	$html = file_get_contents("http://localhost/mydispendik/klinik-dapo/printsuratpdf-" . $idtransaksi . ".html");

	$dompdf->loadHtml($html);
	$dompdf->set_option('isRemoteEnabled', TRUE);
	$dompdf->setPaper('Folio', 'portrait');
	$dompdf->render();

	if (!is_dir("../../../../data-layanan/mutasi-siswa/" . $idtransaksi . "/surat-rekomendasi"))
		mkdir("../../../../data-layanan/mutasi-siswa/" . $idtransaksi . "/surat-rekomendasi", 0777, true);
	$tempdir = "../../../../data-layanan/mutasi-siswa/" . $idtransaksi . "/surat-rekomendasi/";
	$output = $dompdf->output();
	file_put_contents($tempdir . $idtransaksi . '.pdf', $output);



	if ($res) {
		$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($errMsg);

mysqli_free_result($res);
mysqli_free_result($resbidang);
mysqli_close($dbconn);
