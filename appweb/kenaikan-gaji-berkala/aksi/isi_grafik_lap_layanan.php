<?php
//error_reporting(0);
include '../../services/config.php';
include '../../services/tgl_indo.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$idinstansi = trim($_POST['idinstansi']);
$tglawal =trim($_POST['tglawal']);
$tglakhir = trim($_POST['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$tglawalindo = tgl_indo($tglawal);
$tglakhirindo = tgl_indo($tglakhir);

$sqlx = ("SELECT id_layanan,layanan FROM m_layanan ORDER BY id_layanan ASC");	
$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($w=mysqli_fetch_array($resultx)){		
	$nmlayanan = ucwords(strtolower($w['layanan']));

	$qriloket = ("SELECT COUNT(id_surat) AS jmllayanan FROM trans_surat WHERE id_layanan = '".$w['id_layanan']."' AND tgl_surat >= '".$tglawal."' AND tgl_surat <= '".$tglakhir."'");
	$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	
	$row_array = array();
	$row_array['tglawalindo']= $tglawalindo;
	$row_array['tglakhirindo']= $tglakhirindo;
	$row_array['nmlayanan']= $nmlayanan;
	$row_array['jmllayanan']= $t['jmllayanan'];
	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbloket->close();
$dbconn->close();
?>  
