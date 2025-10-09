<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT id_catatan,catatan FROM ats_catatan_survei ORDER BY id_catatan ASC");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['idcatatan']=$t['id_catatan'];
	$row_array['catatan']=ucwords(strtolower($t['catatan']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>