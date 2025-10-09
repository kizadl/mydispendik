<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT kd_kecamatan,nama_kecamatan,geojson,latitude,longitude FROM m_kecamatan");
$result = mysqli_query($dbconn, $sqlx);
$data = array();
while ($t = mysqli_fetch_array($result)) {

	$sqlcount = ("SELECT 
	COUNT(IF(JSON_EXTRACT(p.detail, '$.klasifikasi')='ltm',p.id_siswa,NULL)) AS jumLTM,
	COUNT(IF(JSON_EXTRACT(p.detail, '$.klasifikasi')='do',p.id_siswa,NULL)) AS jumDO,
	COUNT(IF(JSON_EXTRACT(p.detail, '$.klasifikasi')='bpb',p.id_siswa,NULL)) AS jumBPB,
	COUNT(IF(JSON_EXTRACT(p.detail, '$.klasifikasi') NOT IN ('ltm','do','bpb') AND JSON_EXTRACT(p.detail, '$.klasifikasi') IS NOT NULL,p.id_siswa,NULL)) AS jumLainnya
	FROM ats_detail_survei_2025 p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
	WHERE q.kd_kecamatan= '" . $t['kd_kecamatan'] . "'");
	$resultcount = mysqli_query($dbconn, $sqlcount);
	$q = mysqli_fetch_assoc($resultcount);

	$row_array = array();

	$row_array['latitude'] = $t['latitude'];
	$row_array['longitude'] = $t['longitude'];

	$row_array['geojson'] = json_decode($t['geojson']);

	$row_array['kdkecamatan'] = $t['kd_kecamatan'];
	$row_array['namakecamatan'] = $t['nama_kecamatan'];

	$row_array['jumDO'] = $q['jumDO'];
	$row_array['jumLTM'] = $q['jumLTM'];
	$row_array['jumBPB'] = $q['jumBPB'];
	$row_array['jumLainnya'] = $q['jumLainnya'];

	array_push($data, $row_array);
}
echo json_encode($data);
$result->close();
$resultcount->close();
$dbconn->close();
