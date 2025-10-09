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
$iduser = anti_injection(trim($_POST['iduser']));
$idsekolah = anti_injection(trim($_POST['idsekolah']));

$berhentisekolah = anti_injection(trim($_POST['berhentisekolah']));
$berhenticovid = anti_injection(trim($_POST['berhenticovid']));
$alasan = anti_injection(trim($_POST['alasan']));
$idkegiatan = anti_injection(trim($_POST['idkegiatan']));
$sekolahlagi = anti_injection(trim($_POST['sekolahlagi']));
$idketerampilan = anti_injection(trim($_POST['idketerampilan']));
$telepon = anti_injection(trim($_POST['telepon']));

$pesanError = array();
if (trim($idsiswa) == "") {
	$pesanError[] = "Data Siswa Tidak Terdeteksi";
}
if (trim($iduser) == "") {
	$pesanError[] = "Data User Desk Tidak Terdeteksi";
}
if (trim($berhentisekolah) == "") {
	$pesanError[] = "Opsi berhenti sekolah masih kosong";
}
if (trim($berhenticovid) == "") {
	$pesanError[] = "Opsi berhenti ketika covid masih kosong";
}
if (trim($alasan) == "") {
	$pesanError[] = "Alasan tidak boleh kosong";
}
if (trim($idkegiatan) == "") {
	$pesanError[] = "Kegiatan siswa tidak boleh kosong";
}
if (trim($sekolahlagi) == "") {
	$pesanError[] = "Pilihan opsi sekolah lagi tidak boleh kosong";
}
if (trim($idketerampilan) == "") {
	$pesanError[] = "Keterampilan siswa tidak boleh kosong";
}
if (trim($telepon) == "") {
	$pesanError[] = "Nomor telepon tidak boleh kosong";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$qri = "DELETE FROM ats_detail_desk WHERE id_siswa='" . $idsiswa . "'";
	$res = mysqli_query($dbconn, $qri);

	if ($sekolahlagi == "Y") {
		$sql2  = "INSERT INTO ats_detail_desk (id_siswa,id_operator_desk,berhenti_sekolah,berhenti_covid,alasan,id_kegiatan_siswa,id_keterampilan_siswa,lanjut_sekolah,id_sekolah,no_telepon,tgl_desk) VALUES ('$idsiswa','$iduser','$berhentisekolah','$berhenticovid','$alasan','$idkegiatan','$idketerampilan','$sekolahlagi','$idsekolah','$telepon','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	} else if ($sekolahlagi == "N") {
		$sql2  = "INSERT INTO ats_detail_desk (id_siswa,id_operator_desk,berhenti_sekolah,berhenti_covid,alasan,id_kegiatan_siswa,id_keterampilan_siswa,lanjut_sekolah,no_telepon,tgl_desk) VALUES ('$idsiswa','$iduser','$berhentisekolah','$berhenticovid','$alasan','$idkegiatan','$idketerampilan','$sekolahlagi','$telepon','$tglserver')";
		$res = mysqli_query($dbconn, $sql2);
	}

	$qri3 = "UPDATE tbl_ats_2025 SET id_operator_desk='$iduser',desk='Y' WHERE id_siswa='" . $idsiswa . "'";
	$res = mysqli_query($dbconn, $qri3);

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
