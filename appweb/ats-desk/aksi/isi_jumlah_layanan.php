<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlmutsiswa = ("SELECT COUNT(p.id_siswa) AS jumsiswa FROM tbl_ats p WHERE p.survei='Y'");			
$restmutsiswa = mysqli_query($dbconn,$sqlmutsiswa);$a= mysqli_fetch_assoc($restmutsiswa);

$data = array();
$row_array['jummutasisiswa']=number_format($a['jumsiswa'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$restmutsiswa->close();
$dbconn->close();
?>  
