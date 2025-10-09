<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$iduniversitas = trim($_POST['iduniversitas']);

$sqlx = ("SELECT id_fakultas,nm_fakultas FROM ats_fakultas_2025 WHERE id_universitas='" . $iduniversitas . "' ORDER BY nm_fakultas ASC");
$result = mysqli_query($dbconn, $sqlx);
$data = array();
while ($t = mysqli_fetch_array($result)) {
	$row_array = array();
	$row_array['idfakultas'] = $t['id_fakultas'];
	$row_array['nmfakultas'] = ucwords(strtolower($t['nm_fakultas']));
	array_push($data, $row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
