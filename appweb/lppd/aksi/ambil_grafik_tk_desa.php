<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$iddesa= trim($_POST['iddesa']);
$sqlx = ("SELECT DISTINCT (bentuk_pendidikan) AS nmbentuksekolah FROM spm_sekolah WHERE id_desa='".$iddesa."'");
		
$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($resultx)){		

	$sqlcount = ("SELECT SUM(ptk_l + ptk_p) AS jumPtk,SUM(ptk_guru_l + ptk_guru_p) AS jumGuru FROM spm_sekolah WHERE bentuk_pendidikan = '".$t['nmbentuksekolah']."' AND id_desa='".$iddesa."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['nmbentuksekolah']=$t['nmbentuksekolah'];
	$row_array['jumPtk']= $s['jumPtk'] - $s['jumGuru'];
	$row_array['jumGuru']= $s['jumGuru'];
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  
