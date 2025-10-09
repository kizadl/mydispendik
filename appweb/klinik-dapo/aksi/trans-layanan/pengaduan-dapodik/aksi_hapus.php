<?php
require_once '../../../../services/config.php';
error_reporting(0);
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once '../../../../services/csrf_helper.php';
header('Content-Type: application/json');
validate_csrf_token_or_exit($_POST['csrfToken'] ?? '');

$idtransaksi  = trim($_POST['idtransaksi'] ?? '');

$errors = [];
if (!$idtransaksi) $errors[] = "Data tidak lengkap";

if ($errors) {
	echo json_encode(['msg1' => implode('; ', $errors), 'msg2' => 'err_val']);
	exit;
}

$stmtupdate = $dbconn->prepare("UPDATE trans_pengaduan_dapodik SET aktif='N',waktu_update=NOW() WHERE id_transaksi=?");
$stmtupdate->bind_param("i",$idtransaksi);
$stmtupdate->execute();

$new_token = rotate_csrf_token();
echo json_encode(['msg1' => 'SUKSES!', 'msg2' => 'ok', 'new_token' => $new_token]);
$stmtupdate->close();
$dbconn->close();
