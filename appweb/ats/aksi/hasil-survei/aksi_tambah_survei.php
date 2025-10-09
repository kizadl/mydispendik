<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');
$tglserver = date("Y-m-d H:i:s");

$idsiswa = anti_injection(trim($_POST['idsiswa']));
$idsurveyor = anti_injection(trim($_POST['idsurveyor']));
$idcatatan = anti_injection(trim($_POST['idcatatan']));
$catatan = anti_injection(trim($_POST['catatan']));
$pilihan = anti_injection(trim($_POST['pilihan']));

$pesanError = array();
if (trim($idsiswa) == "") {
	$pesanError[] = "Data Siswa Tidak Terdeteksi";
}
if (trim($idsurveyor) == "") {
	$pesanError[] = "Data Surveyor Tidak Terdeteksi";
}
if (trim($catatan) == "") {
	$pesanError[] = "Catatan masih kosong";
}
if (trim($pilihan) == "") {
	$pesanError[] = "Pilihan opsi survei tidak boleh kosong";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$qri = "DELETE FROM ats_detail_survei WHERE id_siswa='" . $idsiswa . "'";
	$res = mysqli_query($dbconn, $qri);

	if ($pilihan == "pilihan1") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,lulus_melanjutkan,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan2") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,pindah_sekolah,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan3") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,melanjutkan_ln,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan4") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,melanjutkan_pesantren,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan5") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,ltm,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan6") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,do,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan7") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,mengundurkan_diri,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan8") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,putus_sekolah,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan9") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,hilang,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan10") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,meninggal_dunia,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($pilihan == "pilihan11") {
		$sql2  = "INSERT INTO ats_detail_survei (id_siswa,id_surveyor,aktif_kembali,id_catatan,catatan,tgl_survei) VALUES ('$idsiswa','$idsurveyor','Y','$idcatatan','$catatan','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	}


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
