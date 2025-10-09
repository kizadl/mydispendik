<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_seksi,p.id_bidang,p.nm_seksi,p.nm_pejabat,p.username,p.status_tte,q.nm_bidang
		 FROM tte_m_seksi p LEFT JOIN tte_m_bidang q ON p.id_bidang=q.id_bidang
		 WHERE p.aktif='Y' ORDER BY p.id_bidang ASC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 

	if ($t['nm_pejabat'] == NULL) {$nmpejabat = "-";} else {$nmpejabat = $t['nm_pejabat'];} 
	if ($t['username'] == NULL) {$username = "-";} else {$username = $t['username'];} 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idseksi']=$t['id_seksi'];
	$row_array['idbidang']=$t['id_bidang'];
	$row_array['nmseksi']=ucwords(strtolower($t['nm_seksi']));
	$row_array['nmbidang']=$t['nm_bidang'];
	$row_array['nmpejabat']=$nmpejabat;
	$row_array['username']=$username;
	$row_array['statustte']=$t['status_tte'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
