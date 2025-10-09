<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT p.id_layanan,p.layanan FROM tte_m_persyaratan_gaji_berkala p 
		ORDER BY p.id_layanan ASC");
$result = mysqli_query($dbconn, $sqlx);
$data = array();
$no = 0;
while ($t = mysqli_fetch_array($result)) {
	$no++;

	$sqldet = ("SELECT persyaratan,mode_upload
		FROM tte_m_persyaratan_gaji_berkala WHERE id_layanan = '" . $t['id_layanan'] . "' ORDER BY id_persyaratan ASC");
	$resultdet = mysqli_query($dbconn, $sqldet);
	$nod = 0;
	$listpersyaratan = "";
	while ($s = mysqli_fetch_array($resultdet)) {
		$nod++;
		$listpersyaratan = $listpersyaratan . $nod . ". " . ucwords(strtolower($s['persyaratan'])) . " (" . ucwords(strtolower($s['mode_upload'])) . ")<br>";
	}

	$row_array = array();
	$row_array['no'] = $no;
	$row_array['kdlayanan'] = $t['id_layanan'];
	$row_array['nmlayanan'] = $t['layanan'];
	$row_array['nmpersyaratan'] = $listpersyaratan;
	array_push($data, $row_array);
}
echo json_encode($data);
$result->close();
$resultdet->close();
$dbconn->close();
