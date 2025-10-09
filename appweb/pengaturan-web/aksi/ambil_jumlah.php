<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$data = array();
$sqlinfo = ("SELECT COUNT(IF(aktif='Y',id_pengumuman,NULL)) AS jumPengumuman FROM pengumuman");			
$resultinfo = mysqli_query($dbconn,$sqlinfo);$p= mysqli_fetch_assoc($resultinfo);
$jumPengumuman = number_format($p['jumPengumuman'],0,".",",");

$sqlpod = ("SELECT COUNT(IF(aktif='Y',id_podcast,NULL)) AS jumPodcast FROM podcast");			
$resultpod = mysqli_query($dbconn,$sqlpod);$q= mysqli_fetch_assoc($resultpod);
$jumPodcast = number_format($q['jumPodcast'],0,".",",");

$sqlinovasi = ("SELECT COUNT(IF(aktif='Y',id_inovasi,NULL)) AS jumInovasi FROM inovasi_sekolah");			
$resultInovasi = mysqli_query($dbconn,$sqlinovasi);$s= mysqli_fetch_assoc($resultInovasi);
$jumInovasi = number_format($s['jumInovasi'],0,".",",");

$sqlpesan = ("SELECT COUNT(IF(dibaca='N',id_pesan,NULL)) AS jumPesan FROM pesan");			
$resultpesan = mysqli_query($dbconn,$sqlpesan);$r= mysqli_fetch_assoc($resultpesan);
$jumPesan = number_format($r['jumPesan'],0,".",",");

$row_array = array();
$row_array['jumPengumuman']=$jumPengumuman;
$row_array['jumPodcast']=$jumPodcast;
$row_array['jumInovasi']=$jumInovasi;
$row_array['jumPesan']=$jumPesan;

array_push($data,$row_array);
echo json_encode($data);

$resultinfo->close();$resultpod->close();$resultInovasi->close();$resultpesan->close();
mysqli_close($dbconn);
?>