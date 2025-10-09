<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_operator,p.nm_operator,p.username,p.akses,p.blokir,p.id_bidang,q.nm_bidang
		FROM m_operator p LEFT JOIN m_bidang q ON p.id_bidang=q.id_bidang WHERE p.aktif='Y' AND p.akses='operator bidang'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	

	if ($t['blokir']=='Y'){$nmblokir="BLOKIR";} else if ($t['blokir']=='N'){$nmblokir="AKTIF";}
	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['nmblokir']=$nmblokir;
	$row_array['idoperator']=$t['id_operator'];$row_array['nmoperator']=$t['nm_operator'];
	$row_array['nminstansi']=$t['nm_bidang'];
	$row_array['username']=$t['username'];
	$row_array['akses']=strtoupper($t['akses']);
	$row_array['blokir']=$t['blokir'];	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
