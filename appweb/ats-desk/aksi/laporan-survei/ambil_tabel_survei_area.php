<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idkecamatan = trim($_POST['idkecamatan']);

$data = array();
if ($idkecamatan == "all") {
	$sqlx = ("SELECT kd_kecamatan AS idwilayah,nama_kecamatan AS namawilayah FROM m_kecamatan ORDER BY nama_kecamatan DESC");
} else if ($idkecamatan != "all") {
	$sqlx = ("SELECT kd_desa AS idwilayah,nama_desa AS namawilayah FROM m_desa WHERE kd_kecamatan='" . $idkecamatan . "' ORDER BY nama_desa DESC");
}
$resultx = mysqli_query($dbconn, $sqlx);

$data = array();
while ($t = mysqli_fetch_array($resultx)) {
	$idwilayah = $t['idwilayah'];
	$namawilayah = ucwords(strtolower($t['namawilayah']));

	if ($idkecamatan == "all") {
		$sqldetsurveyor = ("SELECT COUNT(id_surveyor) AS totalDetSurveyor FROM ats_surveyor WHERE id_kecamatan='" . $idwilayah . "'");
		$sqldetats = ("SELECT COUNT(id_siswa) AS totalDetATS FROM tbl_ats WHERE kd_kecamatan='" . $idwilayah . "'");

		$sqldetsurveyorsudah = ("SELECT COUNT(DISTINCT p.id_surveyor) AS detailSurveyorSudah,COUNT(DISTINCT p.id_siswa) AS detailATSsudah
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan='" . $idwilayah . "'");

	} else if ($idkecamatan != "all") {
		$sqldetsurveyor = ("SELECT COUNT(id_surveyor) AS totalDetSurveyor FROM ats_surveyor WHERE id_desa='" . $idwilayah . "'");
		$sqldetats = ("SELECT COUNT(id_siswa) AS totalDetATS FROM tbl_ats WHERE kd_desa='" . $idwilayah . "'");
		
		$sqldetsurveyorsudah = ("SELECT COUNT(DISTINCT p.id_surveyor) AS detailSurveyorSudah,COUNT(DISTINCT p.id_siswa) AS detailATSsudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa='" . $idwilayah . "'");
	}
	$resultsqldetsurveyor = mysqli_query($dbconn, $sqldetsurveyor);$e = mysqli_fetch_assoc($resultsqldetsurveyor);
	$resultsqldetats = mysqli_query($dbconn, $sqldetats);$f = mysqli_fetch_assoc($resultsqldetats);
	$resultsqldetsurveyorsudah = mysqli_query($dbconn, $sqldetsurveyorsudah);$g = mysqli_fetch_assoc($resultsqldetsurveyorsudah);

	$totalDetSurveyor = $e['totalDetSurveyor'];
	$detailSurveyorSudah = $g['detailSurveyorSudah'];
	$detailSurveyorBelum = $e['totalDetSurveyor'] - $g['detailSurveyorSudah'];
	if ($g['detailSurveyorSudah'] >= 1){
		$persenDetSurveyorsudah = ($g['detailSurveyorSudah'] / $totalDetSurveyor)*100;
	} else if ($g['detailSurveyorSudah'] <= 0){
		$persenDetSurveyorsudah = 0;
	}

	if ($detailSurveyorBelum >= 1){
		$persenDetSurveyorbelum = ($detailSurveyorBelum / $totalDetSurveyor)*100;
	} else if ($detailSurveyorBelum <= 0){
		$persenDetSurveyorbelum = 0;
	}
	
	$totalDetATS = $f['totalDetATS'];
	$detailATSsudah = $g['detailATSsudah'];
	$detailATSBelum = $f['totalDetATS'] - $g['detailATSsudah'];
	if ($g['detailATSsudah'] >= 1){
		$persenDetATSsudah = ($g['detailATSsudah'] / $totalDetATS)*100;
	} else if ($g['detailATSsudah'] <= 0){
		$persenDetATSsudah = 0;
	}

	if ($detailATSBelum >= 1){
		$persenDetATSbelum = ($detailATSBelum / $totalDetATS)*100;
	} else if ($detailATSBelum <= 0){
		$persenDetATSbelum = 0;
	}
	
	$row_array = array();
	$row_array['idwilayah'] = $idwilayah;
	$row_array['namawilayah'] = $namawilayah;

	$row_array['totalDetSurveyor'] = number_format($totalDetSurveyor, 0, ',', '.');
	$row_array['detailSurveyorSudah'] = number_format($detailSurveyorSudah, 0, ',', '.');
	$row_array['detailSurveyorBelum'] = number_format($detailSurveyorBelum, 0, ',', '.');
	$row_array['persenDetSurveyorsudah'] = number_format($persenDetSurveyorsudah, 2, ',', '.');
	$row_array['persenDetSurveyorbelum'] = number_format($persenDetSurveyorbelum, 2, ',', '.');

	$row_array['totalDetATS'] = number_format($totalDetATS, 0, ',', '.');
	$row_array['detailATSsudah'] = number_format($detailATSsudah, 0, ',', '.');
	$row_array['detailATSBelum'] = number_format($detailATSBelum, 0, ',', '.');
	$row_array['persenDetATSsudah'] = number_format($persenDetATSsudah, 2, ',', '.');
	$row_array['persenDetATSbelum'] = number_format($persenDetATSbelum, 2, ',', '.');

	array_push($data, $row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
