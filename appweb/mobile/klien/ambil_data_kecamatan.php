<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan DESC");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['kdkecamatan']=$t['kd_kecamatan'];
	$row_array['namakecamatan']=ucwords(strtolower($t['nama_kecamatan']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>