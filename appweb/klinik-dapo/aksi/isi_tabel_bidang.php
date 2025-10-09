<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT id_bidang,nm_bidang,nm_pejabat,username,status_tte FROM tte_m_bidang WHERE aktif='Y' ORDER BY id_bidang ASC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 

	if ($t['nm_pejabat'] == NULL) {$nmpejabat = "-";} else {$nmpejabat = $t['nm_pejabat'];} 
	if ($t['username'] == NULL) {$username = "-";} else {$username = $t['username'];} 

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idbidang']=$t['id_bidang'];
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
