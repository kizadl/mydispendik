<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT p.id_layanan,p.layanan,p.awal_no_surat,p.no_urut,p.akhir_no_surat
		FROM tte_m_layanan_gaji_berkala p 
		ORDER BY p.id_layanan ASC");
$result = mysqli_query($dbconn, $sqlx);
$data = array();
$no = 0;
while ($t = mysqli_fetch_array($result)) {
	$no++;

	$nosurat = $t['awal_no_surat'] . $t['no_urut'] . $t['akhir_no_surat'];


	$row_array = array();
	$row_array['no'] = $no;
	$row_array['kdlayanan'] = $t['id_layanan'];
	$row_array['nmlayanan'] = $t['layanan'];
	$row_array['nosurat'] = $nosurat;
	array_push($data, $row_array);
}
echo json_encode($data);
$result->close();
$resultdet->close();
$dbconn->close();
