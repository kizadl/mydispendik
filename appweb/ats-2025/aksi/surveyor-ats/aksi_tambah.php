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

$idsurveyor = anti_injection(trim($_POST['idsurveyor']));

$pesanError = array();
if (trim($idsurveyor) == "") {
	$pesanError[] = "Data surveyor tidak boleh kosong";
}
if (count($pesanError) >= 1) {
	foreach ($pesanError as $indeks => $pesan_tampil) {
		$errMsg .= "$pesan_tampil\n";
		$status = 'err_val';
	}
} else {

	$arridats = $_POST['arridats'];
	$jmldata = count($arridats);
	for ($i = 0; $i <= $jmldata - 1; $i++) {
		$sql2  = "UPDATE tbl_ats_2025 SET id_surveyor='$idsurveyor' WHERE id_siswa='" . $arridats[$i] . "'";
		$res = mysqli_query($dbconn, $sql2);
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
