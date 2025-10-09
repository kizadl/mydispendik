<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id,p.nm_user,p.username,p.blokir FROM ats_user p WHERE p.akses='desk'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	if ($t['blokir']=='Y'){$nmblokir="BLOKIR";} else if ($t['blokir']=='N'){$nmblokir="AKTIF";}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['nmblokir']=$nmblokir;
	$row_array['iduser']=$t['id'];
	$row_array['nmuser']=ucwords(strtolower($t['nm_user']));
	$row_array['username']=$t['username'];
	$row_array['blokir']=$t['blokir'];	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
