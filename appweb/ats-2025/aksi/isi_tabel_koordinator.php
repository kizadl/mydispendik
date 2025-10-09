<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT p.id_koordinator,p.nm_koordinator,p.username,p.blokir,p.id_universitas,p.id_fakultas,
		q.nm_universitas,r.nm_fakultas
		FROM ats_koordinator_2025 p LEFT JOIN ats_universitas_2025 q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas_2025 r ON p.id_fakultas=r.id_fakultas
		WHERE p.aktif='Y'");
$result = mysqli_query($dbconn, $sqlx);
$data = array();
$no = 0;
while ($t = mysqli_fetch_array($result)) {
	$no++;

	if ($t['blokir'] == 'Y') {
		$nmblokir = "BLOKIR";
	} else if ($t['blokir'] == 'N') {
		$nmblokir = "AKTIF";
	}

	$row_array = array();
	$row_array['no'] = $no;
	$row_array['nmblokir'] = $nmblokir;
	$row_array['idkoordinator'] = $t['id_koordinator'];
	$row_array['nmkoordinator'] = ucwords(strtolower($t['nm_koordinator']));
	$row_array['nmuniversitas'] = ucwords(strtolower($t['nm_universitas']));
	$row_array['nmfakultas'] = ucwords(strtolower($t['nm_fakultas']));
	$row_array['username'] = $t['username'];
	$row_array['blokir'] = $t['blokir'];
	array_push($data, $row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
