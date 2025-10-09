<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT id_universitas,nm_universitas FROM ats_universitas WHERE aktif='Y' ORDER BY nm_universitas DESC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['iduniversitas']=$t['id_universitas'];
	$row_array['nmuniversitas']=$t['nm_universitas'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
