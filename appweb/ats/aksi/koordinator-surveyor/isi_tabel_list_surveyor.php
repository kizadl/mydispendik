<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$iduniversitas = trim($_POST['iduniversitas']);

$sqlx = ("SELECT p.id_surveyor,p.nm_surveyor,p.telepon,q.nm_fakultas
FROM ats_surveyor p LEFT JOIN ats_fakultas q ON p.id_fakultas=q.id_fakultas
WHERE p.id_universitas='" . $iduniversitas . "'");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsurveyor']=$t['id_surveyor'];
	$row_array['nmsurveyor']=ucwords(strtolower($t['nm_surveyor']));
	$row_array['nmfakultas']=ucwords(strtolower($t['nm_fakultas']));
	$row_array['telepon']=$t['telepon'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
