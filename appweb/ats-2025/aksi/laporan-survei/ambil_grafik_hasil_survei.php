<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idkecamatan = trim($_POST['idkecamatan']);
$iddesa = trim($_POST['iddesa']);

$data = array();
if ($idkecamatan == "all") {
	$sqlcount = ("
        SELECT 
            SUM(CASE WHEN val LIKE '%do%' THEN 1 ELSE 0 END) AS jumDO,
            SUM(CASE WHEN val LIKE '%ltm%' THEN 1 ELSE 0 END) AS jumLTM,
            SUM(CASE WHEN val LIKE '%bpb%' THEN 1 ELSE 0 END) AS jumBPB,
            SUM(CASE WHEN val NOT LIKE '%do%'
                      AND val NOT LIKE '%ltm%'
                      AND val NOT LIKE '%bpb%'
                THEN 1 ELSE 0 END) AS jumLainnya,
            COUNT(*) AS totalData
        FROM (
            SELECT LOWER(JSON_UNQUOTE(JSON_EXTRACT(detail, '$.klasifikasi'))) AS val
            FROM ats_detail_survei_2025
            WHERE detail IS NOT NULL
        ) AS sub
    ");

	$sqlats = ("SELECT COUNT(id_siswa) AS jumSiswaATS FROM tbl_ats_2025");
	$sqlATSsudah = ("SELECT COUNT(id_siswa) AS jumATSSudah FROM ats_detail_survei_2025");
	$sqlsurveyor = ("SELECT COUNT(id_surveyor) AS jumSurveyor FROM ats_surveyor_2025");
	$sqlsurveyorsudah = ("SELECT COUNT(DISTINCT id_surveyor) AS jumSurveyorSudah 
        FROM ats_detail_survei_2025");
} else if ($idkecamatan != "all" && $iddesa == "all") {
	$filter = "AND q.kd_kecamatan = '" . $idkecamatan . "'";

	$sqlcount = ("
        SELECT 
            SUM(CASE WHEN val LIKE '%do%' THEN 1 ELSE 0 END) AS jumDO,
            SUM(CASE WHEN val LIKE '%ltm%' THEN 1 ELSE 0 END) AS jumLTM,
            SUM(CASE WHEN val LIKE '%bpb%' THEN 1 ELSE 0 END) AS jumBPB,
            SUM(CASE WHEN val NOT LIKE '%do%'
                      AND val NOT LIKE '%ltm%'
                      AND val NOT LIKE '%bpb%'
                THEN 1 ELSE 0 END) AS jumLainnya,
            COUNT(*) AS totalData
        FROM (
            SELECT LOWER(JSON_UNQUOTE(JSON_EXTRACT(p.detail, '$.klasifikasi'))) AS val
            FROM ats_detail_survei_2025 p
            LEFT JOIN tbl_ats_2025 q ON p.id_siswa = q.id_siswa
            WHERE p.id_siswa = q.id_siswa AND q.survei = 'Y' $filter
        ) AS sub
    ");

	$sqlats = ("SELECT COUNT(id_siswa) AS jumSiswaATS FROM tbl_ats_2025 WHERE kd_kecamatan='" . $idkecamatan . "'");
	$sqlATSsudah = ("SELECT COUNT(p.id_siswa) AS jumATSSudah 
        FROM ats_detail_survei_2025 p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
        WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan='" . $idkecamatan . "'");
	$sqlsurveyor = ("SELECT COUNT(id_surveyor) AS jumSurveyor FROM ats_surveyor_2025 WHERE id_kecamatan='" . $idkecamatan . "'");
	$sqlsurveyorsudah = ("SELECT COUNT(DISTINCT p.id_surveyor) AS jumSurveyorSudah 
        FROM ats_detail_survei_2025 p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa 
        WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan='" . $idkecamatan . "'");
} else if ($idkecamatan != "all" && $iddesa != "all") {
	$filter = "AND q.kd_desa = '" . $iddesa . "'";

	$sqlcount = ("
        SELECT 
            SUM(CASE WHEN val LIKE '%do%' THEN 1 ELSE 0 END) AS jumDO,
            SUM(CASE WHEN val LIKE '%ltm%' THEN 1 ELSE 0 END) AS jumLTM,
            SUM(CASE WHEN val LIKE '%bpb%' THEN 1 ELSE 0 END) AS jumBPB,
            SUM(CASE WHEN val NOT LIKE '%do%'
                      AND val NOT LIKE '%ltm%'
                      AND val NOT LIKE '%bpb%'
                THEN 1 ELSE 0 END) AS jumLainnya,
            COUNT(*) AS totalData
        FROM (
            SELECT LOWER(JSON_UNQUOTE(JSON_EXTRACT(p.detail, '$.klasifikasi'))) AS val
            FROM ats_detail_survei_2025 p
            LEFT JOIN tbl_ats_2025 q ON p.id_siswa = q.id_siswa
            WHERE p.id_siswa = q.id_siswa AND q.survei = 'Y' $filter
        ) AS sub
    ");

	$sqlats = ("SELECT COUNT(id_siswa) AS jumSiswaATS FROM tbl_ats_2025 WHERE kd_desa='" . $iddesa . "'");
	$sqlATSsudah = ("SELECT COUNT(p.id_siswa) AS jumATSSudah 
        FROM ats_detail_survei_2025 p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
        WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa='" . $iddesa . "'");
	$sqlsurveyor = ("SELECT COUNT(id_surveyor) AS jumSurveyor FROM ats_surveyor_2025 WHERE id_desa='" . $iddesa . "'");
	$sqlsurveyorsudah = ("SELECT COUNT(DISTINCT p.id_surveyor) AS jumSurveyorSudah 
        FROM ats_detail_survei_2025 p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa 
        WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa='" . $iddesa . "'");
}

$resultcount = mysqli_query($dbconn, $sqlcount);
$s = mysqli_fetch_assoc($resultcount);

$resultsqlats = mysqli_query($dbconn, $sqlats);
$t = mysqli_fetch_assoc($resultsqlats);
$jumSiswaATS = number_format($t['jumSiswaATS'], 0, ',', '.');

$resultsqlATSsudah = mysqli_query($dbconn, $sqlATSsudah);
$u = mysqli_fetch_assoc($resultsqlATSsudah);
$jumATSSudah = number_format($u['jumATSSudah'], 0, ',', '.');
$jumATSBelum = $t['jumSiswaATS'] - $u['jumATSSudah'];
$jumATSSudahPersen = ($u['jumATSSudah'] / $t['jumSiswaATS']) * 100;
$jumATSBelumPersen = ($jumATSBelum / $t['jumSiswaATS']) * 100;

$resultsqlsurveyor = mysqli_query($dbconn, $sqlsurveyor);
$v = mysqli_fetch_assoc($resultsqlsurveyor);
$jumSurveyor = number_format($v['jumSurveyor'], 0, ',', '.');

$resultsqlsurveyorsudah = mysqli_query($dbconn, $sqlsurveyorsudah);
$w = mysqli_fetch_assoc($resultsqlsurveyorsudah);
$jumSurveyorSudah = number_format($w['jumSurveyorSudah'], 0, ',', '.');
$jumSurveyorBelum = $v['jumSurveyor'] - $w['jumSurveyorSudah'];
$jumSurveyorSudahPersen = ($w['jumSurveyorSudah'] / $v['jumSurveyor']) * 100;
$jumSurveyorBelumPersen = ($jumSurveyorBelum / $v['jumSurveyor']) * 100;

$row_array = array();
$row_array['jumDO'] = $s['jumDO'];
$row_array['jumLTM'] = $s['jumLTM'];
$row_array['jumBPB'] = $s['jumBPB'];
$row_array['jumLainnya'] = $s['jumLainnya'];

$row_array['jumSiswaATS'] = $jumSiswaATS;
$row_array['jumATSSudah'] = $jumATSSudah;
$row_array['jumATSBelum'] = number_format($jumATSBelum, 0, ',', '.');
$row_array['jumATSSudahPersen'] = number_format($jumATSSudahPersen, 2, ',', '.');
$row_array['jumATSBelumPersen'] = number_format($jumATSBelumPersen, 2, ',', '.');
$row_array['jumSurveyor'] = $jumSurveyor;
$row_array['jumSurveyorSudah'] = $jumSurveyorSudah;
$row_array['jumSurveyorBelum'] = number_format($jumSurveyorBelum, 0, ',', '.');;
$row_array['jumSurveyorSudahPersen'] = number_format($jumSurveyorSudahPersen, 2, ',', '.');
$row_array['jumSurveyorBelumPersen'] = number_format($jumSurveyorBelumPersen, 2, ',', '.');

array_push($data, $row_array);

echo json_encode($data);
$dbconn->close();