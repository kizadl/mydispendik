<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

function anti_injection($data)
{
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	return $filter;
}
date_default_timezone_set('Asia/Jakarta');

$idsiswa = anti_injection(trim($_POST['idsiswa']));
$idsurveyor = anti_injection(trim($_POST['idsurveyor']));
$namasiswa = strtoupper(anti_injection(trim($_POST['namasiswa'])));
$kelamin = anti_injection(trim($_POST['kelamin']));
$tmplahir = strtoupper(anti_injection(trim($_POST['tmplahir'])));
$tgllahir = trim($_POST['tgllahir']);
$tgllahir = date('Y-m-d', strtotime($tgllahir));
$umur = anti_injection(trim($_POST['umur']));

$alamat = anti_injection(trim($_POST['alamat']));
$rt = anti_injection(trim($_POST['rt']));
$rw = anti_injection(trim($_POST['rw']));
$idkecamatan = anti_injection(trim($_POST['idkecamatan']));
$iddesa = anti_injection(trim($_POST['iddesa']));

$pesanError = array();
if (trim($idsiswa) == "") {
	$pesanError[] = "Data Siswa Tidak Terdeteksi";
}
if (trim($namasiswa) == "") {
	$pesanError[] = "Data Siswa Tidak Terdeteksi";
}
if (trim($idkecamatan) == "") {
	$pesanError[] = "Data kecamatan tidak boleh kosong";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$sql2  = "UPDATE tbl_ats SET kd_kecamatan='$idkecamatan',kd_desa='$iddesa',alamat='$alamat',rt='$rt', 
	rw='$rw',nama_siswa='$namasiswa',jenis_kelamin='$kelamin',tgl_lahir='$tgllahir',tmp_lahir='$tmplahir',umur='$umur' 
	WHERE id_siswa='" . $idsiswa . "'";
	$res = mysqli_query($dbconn, $sql2);

	if ($res) {
		$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	} else {
		$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}
}
$data = array('msg1' => $errMsg, 'msg2' => $status);
echo json_encode($data);

mysqli_free_result($res);
mysqli_close($dbconn);
