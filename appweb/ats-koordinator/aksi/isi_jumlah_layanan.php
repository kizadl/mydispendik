<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idkoordinator = trim($_POST['idkoordinator']);

$sqlmutsiswa = ("SELECT COUNT(p.id_siswa) AS jumsiswa 
    FROM tbl_ats p LEFT JOIN ats_surveyor q ON p.id_surveyor=q.id_surveyor
    WHERE q.id_koordinator='".$idkoordinator."'");			
$restmutsiswa = mysqli_query($dbconn,$sqlmutsiswa);$a= mysqli_fetch_assoc($restmutsiswa);

$data = array();
$row_array['jummutasisiswa']=number_format($a['jumsiswa'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$restmutsiswa->close();
$dbconn->close();
?>  
