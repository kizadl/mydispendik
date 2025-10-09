<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_operator,p.nm_operator,p.username,p.akses,p.blokir,p.id_bidang
		FROM m_operator p
		WHERE p.aktif='Y' AND p.akses='operator bidang' OR p.aktif='Y' AND p.akses='operator dapodik'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	if ($t['blokir']=='Y'){$nmblokir="BLOKIR";} else if ($t['blokir']=='N'){$nmblokir="AKTIF";}
	
	$sqldet = ("SELECT nm_bidang FROM tte_m_bidang WHERE id_bidang='".$t['id_bidang']."'");			
	$resultdet = mysqli_query($dbconn,$sqldet);$c = mysqli_fetch_assoc($resultdet);
	$jumbid = mysqli_num_rows($resultdet);
	if ($jumbid >= 1){
		$namabidang = $c['nm_bidang'];
	} else {
		$namabidang = "<span class='badge bg-success'>ADMINISTRATOR</span>";
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['nmblokir']=$nmblokir;
	$row_array['idoperator']=$t['id_operator'];$row_array['nmoperator']=$t['nm_operator'];
	$row_array['nminstansi']=$namabidang;
	$row_array['username']=$t['username'];
	$row_array['akses']=ucwords(strtolower($t['akses']));
	$row_array['blokir']=$t['blokir'];	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultdet->close();
$dbconn->close();
?>  
