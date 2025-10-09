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
$klasifikasi = anti_injection(trim($_POST['klasifikasi']));
$faktorEkonomi = anti_injection(trim($_POST['faktorEkonomi']));
$faktorKesehatan = anti_injection(trim($_POST['faktorKesehatan']));
$faktorSosial = anti_injection(trim($_POST['faktorSosial']));
$faktorGeografis = anti_injection(trim($_POST['faktorGeografis']));
$faktorPendidikan = anti_injection(trim($_POST['faktorPendidikan']));
$faktorKeluarga = anti_injection(trim($_POST['faktorKeluarga']));
$statusGizi = anti_injection(trim($_POST['statusGizi']));
$riwayatPindahSekolah = anti_injection(trim($_POST['riwayatPindahSekolah']));
$pencapaianAkademis = anti_injection(trim($_POST['pencapaianAkademis']));
$keterlibatanEkskul = anti_injection(trim($_POST['keterlibatanEkskul']));
$hasilRekomendasi = anti_injection(trim($_POST['hasilRekomendasi']));

$detailSurvei = array(
	'klasifikasi' => $klasifikasi,
	'faktorEkonomi' => $faktorEkonomi,
	'faktorKesehatan' => $faktorKesehatan,
	'faktorSosial' => $faktorSosial,
	'faktorGeografis' => $faktorGeografis,
	'faktorPendidikan' => $faktorPendidikan,
	'faktorKeluarga' => $faktorKeluarga,
	'statusGizi' => $statusGizi,
	'riwayatPindahSekolah' => $riwayatPindahSekolah,
	'pencapaianAkademis' => $pencapaianAkademis,
	'keterlibatanEkskul' => $keterlibatanEkskul,
	'hasilRekomendasi' => $hasilRekomendasi
);

$detailSurveiJson = json_encode($detailSurvei);

$data = json_decode($dadada);

$lokasi_tutor = $_FILES['upTutorial']['tmp_name'];

$pesanError = array();
if (trim($idsiswa) == "") {
	$pesanError[] = "Data Siswa Tidak Terdeteksi";
}
if (trim($idsurveyor) == "") {
	$pesanError[] = "Data Surveyor Tidak Terdeteksi";
}

if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$qri = "DELETE FROM ats_detail_survei_2025 WHERE id_siswa='" . $idsiswa . "'";
	$res = mysqli_query($dbconn, $qri);

	if($klasifikasi != 'DO' && $klasifikasi != 'BPB' && $klasifikasi != 'LTM') {
		$klasifikasi = 'LA';
	}

	$sqlUpdate = "UPDATE tbl_ats_2025 SET id_surveyor='$idsurveyor', status_ats='$klasifikasi' WHERE id_siswa='" . $idsiswa . "'";
	$resUpdate = mysqli_query($dbconn, $sqlUpdate);

	$sqlInsert = "INSERT INTO ats_detail_survei_2025 (id_siswa, id_surveyor, detail, tanggal_survei) 
        VALUES ('$idsiswa', '$idsurveyor', '$detailSurveiJson', '$tglserver')
        ON DUPLICATE KEY UPDATE id_surveyor = '$idsurveyor',detail = '$detailSurveiJson', tanggal_survei = '$tglserver'";

	$resInsert = mysqli_query($dbconn, $sqlInsert);

	$sqlsur  = "UPDATE tbl_ats_2025 SET survei='Y' WHERE id_siswa='" . $idsiswa . "'";
	$res = mysqli_query($dbconn, $sqlsur);

		if(!is_dir("../../../data-foto-rekonfirmator"))
		mkdir("../../../data-foto-rekonfirmator",0777,true); 
		$path2 = "../../../data-foto-rekonfirmator/".$idsiswa.".jpg";	

		if (!($lokasi_tutor)==''){
			move_uploaded_file($lokasi_tutor, $path2);
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
