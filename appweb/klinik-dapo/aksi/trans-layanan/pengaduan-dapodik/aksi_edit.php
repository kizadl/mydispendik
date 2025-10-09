<?php
require_once '../../../../services/config.php';
error_reporting(0);
$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once '../../../../services/csrf_helper.php';
header('Content-Type: application/json');
validate_csrf_token_or_exit($_POST['csrfToken'] ?? '');

$idoperator  = trim($_POST['idoperator'] ?? '');
$idtransaksi  = trim($_POST['idtransaksi'] ?? '');
$statuspengaduan   = trim($_POST['statuspengaduan'] ?? '');
$tindakan   = trim($_POST['tindakan'] ?? '');

$errors = [];
if (!$idtransaksi ||!$idoperator || !$statuspengaduan || !$tindakan) $errors[] = "Data tidak lengkap";

if ($errors) {
	echo json_encode(['msg1' => implode('; ', $errors), 'msg2' => 'err_val']);
	exit;
}

$stmt = $dbconn->prepare("INSERT INTO detail_pengaduan_dapodik (id_transaksi,catatan,ket_level,waktu,status_akhir,id_verifikator) 
VALUES (?,?,'operator dapodik',NOW(),?,?)");
$stmt->bind_param("issi", $idtransaksi, $tindakan, $statuspengaduan, $idoperator);
$stmt->execute();

$stmtupdate = $dbconn->prepare("UPDATE trans_pengaduan_dapodik SET ket_level='operator dapodik',ket_status_akhir=?,waktu_update=NOW(),id_opt_dapodik=? WHERE id_transaksi=?");
$stmtupdate->bind_param("sii", $statuspengaduan, $idoperator, $idtransaksi);
$stmtupdate->execute();

$new_token = rotate_csrf_token();
echo json_encode(['msg1' => 'SUKSES!', 'msg2' => 'ok', 'new_token' => $new_token]);
$stmtupdate->close();
$dbconn->close();
