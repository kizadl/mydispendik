<?php
error_reporting(0);
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

$sqlx = ("SELECT id_layanan,layanan FROM tte_m_layanan ORDER BY id_layanan ASC");	
$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
while($w=mysqli_fetch_array($resultx)){		
	$nmlayanan = ucwords(strtolower($w['layanan']));
	$idlayanan = $w['id_layanan'];
	if ($idlayanan == 1){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_mutasi_siswa WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 1){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_mutasi_siswa WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 2){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_verifikasi_pdb_mi WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 3){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_mutasi_pendidik WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 4){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_pergantian_kepsek WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 5){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_perubahan_ptk WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 6){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_pengajuan_npsn WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 7){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_pengajuan_akun_operator WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	} else if ($idlayanan == 8){
		$qriloket = ("SELECT COUNT(id_transaksi) AS jmllayanan FROM tte_trans_pengajuan_npyp WHERE id_layanan = '".$w['id_layanan']."' AND waktu_create >= '".$tglawal."' AND waktu_create <= '".$tglakhir."'");
		$dbloket = mysqli_query($dbconn,$qriloket);$t= mysqli_fetch_assoc($dbloket);
	}


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
