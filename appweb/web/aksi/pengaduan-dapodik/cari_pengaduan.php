<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$noorder= trim($_POST['noorder']);

$sqlx = ("SELECT id_transaksi FROM trans_pengaduan_dapodik WHERE no_order = '".$noorder."'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['idtransaksi']=$t['id_transaksi'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
