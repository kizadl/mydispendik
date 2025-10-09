<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$iduniversitas = trim($_POST['iduniversitas']);

$sqlx = ("SELECT p.id_koordinator,p.nm_koordinator,p.id_universitas,p.id_fakultas,q.nm_universitas,r.nm_fakultas
		FROM ats_koordinator p LEFT JOIN ats_universitas q ON p.id_universitas=q.id_universitas
		LEFT JOIN ats_fakultas r ON p.id_fakultas=r.id_fakultas
		WHERE p.id_universitas='".$iduniversitas."'
		ORDER BY q.nm_universitas,r.nm_fakultas ASC");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	$sqldet = ("SELECT nm_surveyor,telepon
		FROM ats_surveyor WHERE id_koordinator = '".$t['id_koordinator']."' ORDER BY nm_surveyor ASC");			
	$resultdet = mysqli_query($dbconn,$sqldet);
	$nod=0;$listsurveyor ="";
	while($s=mysqli_fetch_array($resultdet)){
		$nod++;
		$listsurveyor = $listsurveyor.$nod.". ".ucwords(strtolower($s['nm_surveyor']))." (".$s['telepon'].")&nbsp;&nbsp;&nbsp;";
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idkoordinator']=$t['id_koordinator'];
	$row_array['iduniversitas']=$t['id_universitas'];$row_array['idfakultas']=$t['id_fakultas'];
	$row_array['nmkoordinator']=ucwords(strtolower($t['nm_koordinator']));
	$row_array['nmuniversitas']=ucwords(strtolower($t['nm_universitas']));
	$row_array['nmfakultas']=ucwords(strtolower($t['nm_fakultas']));
	$row_array['listsurveyor']=$listsurveyor;	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultdet->close();
$dbconn->close();
?>  
