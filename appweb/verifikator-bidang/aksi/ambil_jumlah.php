<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idbidang=trim($_POST['idbidang']);

$data = array();
$sqlinfo = ("SELECT COUNT(IF(aktif='Y',id_pengaduan,NULL)) AS jumPengaduan FROM pengaduan WHERE stts_pengaduan='distribusi' AND id_bidang='".$idbidang."'");			
$resultinfo = mysqli_query($dbconn,$sqlinfo);$p= mysqli_fetch_assoc($resultinfo);
$jumPengaduan = number_format($p['jumPengaduan'],0,".",",");

$row_array = array();
$row_array['jumPengaduan']=$jumPengaduan;

array_push($data,$row_array);
echo json_encode($data);

$resultinfo->close();
mysqli_close($dbconn);
?>