<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_fakultas,p.id_universitas,p.nm_fakultas,q.nm_universitas
		 FROM ats_fakultas p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		 WHERE p.aktif='Y' ORDER BY q.nm_universitas ASC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idfakultas']=$t['id_fakultas'];
	$row_array['iduniversitas']=$t['id_universitas'];
	$row_array['nmfakultas']=ucwords(strtolower($t['nm_fakultas']));
	$row_array['nmuniversitas']=ucwords(strtolower($t['nm_universitas']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
