<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function getBulan($bln)
{
	switch ($bln) {
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}

$filterdata = trim($_POST['filterdata']);
$idkecamatan = trim($_POST['idkecamatan']);
$iddesa = trim($_POST['iddesa']);
$iduniversitas = trim($_POST['iduniversitas']);
$idfakultas = trim($_POST['idfakultas']);
$umur = trim($_POST['umur']);
$bentukpendidikan = trim($_POST['bentukpendidikan']);
$kategori = trim($_POST['kategori']);

// Pagination parameters
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10;
$offset = ($page - 1) * $limit;

try {
	if ($filterdata == "all") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p 
			WHERE p.survei='Y' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
} else if ($filterdata == "kecamatan" and $idkecamatan != "all" and $iddesa == "all") {
	$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p 
			WHERE p.survei='Y' AND p.kd_kecamatan='" . $idkecamatan . "' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
} else if ($filterdata == "desa" and $idkecamatan != "all" and $iddesa != "all") {
	$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p 
			WHERE p.survei='Y' AND p.kd_kecamatan='" . $idkecamatan . "' AND p.kd_desa='" . $iddesa . "' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
} else if ($filterdata == "universitas" and $iduniversitas != "all" and $idfakultas == "all") {
	$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			WHERE p.survei='Y' AND q.id_universitas='" . $iduniversitas . "' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
} else if ($filterdata == "fakultas" and $iduniversitas != "all" and $idfakultas != "all") {
	$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			WHERE p.survei='Y' AND q.id_fakultas='" . $idfakultas . "' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
} else if ($filterdata == "umur") {
	if ($umur == "7-12") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p
			WHERE p.survei='Y' AND p.umur >= 7 AND p.umur <= 12 ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
	} else if ($umur == "13-15") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p
			WHERE p.survei='Y' AND p.umur >= 13 AND p.umur <= 15 ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
	} else if ($umur == "16-18") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p
			WHERE p.survei='Y' AND p.umur >= 16 AND p.umur <= 18 ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
	}
} else if ($filterdata == "bentuk pendidikan" and $bentukpendidikan != "") {
	$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p
			WHERE p.survei='Y' AND p.bentuk_pendidikan='" . $bentukpendidikan . "' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
} else if ($filterdata == "kategori") {
	if ($kategori == "DO") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p LEFT JOIN ats_detail_survei_2025 q ON p.id_siswa=q.id_siswa
			WHERE p.survei='Y' AND LOWER(JSON_EXTRACT(q.detail, '$.klasifikasi')) = 'do' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
	} else if ($kategori == "LTM") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p LEFT JOIN ats_detail_survei_2025 q ON p.id_siswa=q.id_siswa
			WHERE p.survei='Y' AND LOWER(JSON_EXTRACT(q.detail, '$.klasifikasi')) = 'ltm' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
	} else if ($kategori == "BPB") {
		$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk
			FROM tbl_ats_2025 p LEFT JOIN ats_detail_survei_2025 q ON p.id_siswa=q.id_siswa
			WHERE p.survei='Y' AND LOWER(JSON_EXTRACT(q.detail, '$.klasifikasi')) = 'bpb' ORDER BY p.nama_siswa ASC LIMIT $offset, $limit");
	}
}

// Get total count first
$sqlCount = str_replace("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
			p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.survei,p.desk", 
            "SELECT COUNT(*) as total", $sqlx);
$sqlCount = preg_replace("/LIMIT \d+, \d+/", "", $sqlCount);
$resultCount = mysqli_query($dbconn, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalRecords = $rowCount['total'];

// Get paginated data
$result = mysqli_query($dbconn, $sqlx);
$data = array();
$no = ($page - 1) * $limit;
$jumsurveinya = 0;
while ($t = mysqli_fetch_array($result)) {
	$no++;
	
	$qricbg3 = ("SELECT id_siswa FROM ats_detail_survei_2025 WHERE id_siswa='" . $t['id_siswa'] . "'");
	$dbcabang3 = mysqli_query($dbconn, $qricbg3);
	$jumsurvei = mysqli_num_rows($dbcabang3);
	if ($jumsurvei == 0 or $jumsurvei == NULL) {
		$jumsurveinya = "0";
	} else {
		$jumsurveinya = $jumsurvei;
	}
	
	$statusats = str_replace(' ', '', $t['status_ats']);
	$row_array = array();
	$row_array['no'] = $no;
	$row_array['idsiswa'] = $t['id_siswa'];
	$row_array['idsurveyor'] = $t['id_surveyor'];
	$row_array['namasiswa'] = preg_replace("/[^a-zA-Z\d]/", " ", $t['nama_siswa']); //ucwords(strtolower($t['nama_siswa']));
	$row_array['kelamin'] = $t['jenis_kelamin'];
	$row_array['tmplahir'] = preg_replace("/[^a-zA-Z\d]/", " ", $t['tmp_lahir']); //ucwords(strtolower($t['tmp_lahir']));
	$row_array['tgllahir'] = tgl_indo(date("Y-m-d", strtotime($t['tgl_lahir'])));
	$row_array['umur'] = $t['umur'];
	
	$row_array['alamat'] = preg_replace("/[^a-zA-Z\d]/", " ", $t['alamat']); //ucwords(strtolower($t['alamat']));
	$row_array['rt'] = $t['rt'];
	$row_array['rw'] = $t['rw'];
	$row_array['desa'] = ucwords(strtolower($t['desa']));
	$row_array['kecamatan'] = ucwords(strtolower($t['kecamatan']));
	$row_array['kdkecamatan'] = $t['kd_kecamatan'];
	
	$row_array['namasekolah'] = preg_replace("/[^a-zA-Z\d]/", " ", $t['nama_sekolah']); //$t['nama_sekolah'];
	$row_array['bentukpendidikan'] = $t['bentuk_pendidikan'];
	$row_array['tingkatpendidikan'] = $t['tingkat_pendidikan'];
	$row_array['tahun'] = $t['tahun'];
	$row_array['semester'] = $t['semester'];
	$row_array['statusats'] = $statusats;
	$row_array['jumsurvei'] = $jumsurveinya;

	$row_array['survei'] = $t['survei'];
	$row_array['desk'] = $t['desk'];
	
	array_push($data, $row_array);
}
$response = array(
    'data' => $data,
    'pagination' => array(
        'page' => $page,
        'limit' => $limit,
        'total' => $totalRecords,
        'total_pages' => ceil($totalRecords / $limit)
    )
);

echo json_encode($response);
$result->close();
$dbconn->close();

} catch (Exception $e) {
	throw new Exception("Error Processing Request", $e);
}