<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlmutsiswa = ("SELECT COUNT(id_transaksi) AS jummutasisiswa FROM tte_trans_mutasi_siswa WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restmutsiswa = mysqli_query($dbconn,$sqlmutsiswa);$a= mysqli_fetch_assoc($restmutsiswa);

$sqlpdbmi = ("SELECT COUNT(id_transaksi) AS jumpdbmi FROM tte_trans_verifikasi_pdb_mi WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restpdbmi = mysqli_query($dbconn,$sqlpdbmi);$b= mysqli_fetch_assoc($restpdbmi);

$sqlmutpend = ("SELECT COUNT(id_transaksi) AS jummutasipendidik FROM tte_trans_mutasi_pendidik WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restmutpend = mysqli_query($dbconn,$sqlmutpend);$c= mysqli_fetch_assoc($restmutpend);

$sqlkepsek = ("SELECT COUNT(id_transaksi) AS jumgantikepsek FROM tte_trans_pergantian_kepsek WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restkepsek = mysqli_query($dbconn,$sqlkepsek);$d= mysqli_fetch_assoc($restkepsek);

$sqlptk = ("SELECT COUNT(id_transaksi) AS jumubahptk FROM tte_trans_perubahan_ptk WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restptk = mysqli_query($dbconn,$sqlptk);$e= mysqli_fetch_assoc($restptk);

$sqlnpsn = ("SELECT COUNT(id_transaksi) AS jumnpsn FROM tte_trans_pengajuan_npsn WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restnpsn = mysqli_query($dbconn,$sqlnpsn);$f= mysqli_fetch_assoc($restnpsn);

$sqlakunopt = ("SELECT COUNT(id_transaksi) AS jumakunopt FROM tte_trans_pengajuan_akun_operator WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restakunopt = mysqli_query($dbconn,$sqlakunopt);$g= mysqli_fetch_assoc($restakunopt);

$sqlnpyp = ("SELECT COUNT(id_transaksi) AS jumnpyp FROM tte_trans_pengajuan_npyp WHERE arsip_admin='N' AND stts_opt_sekolah='terkirim'");			
$restnpyp = mysqli_query($dbconn,$sqlnpyp);$h= mysqli_fetch_assoc($restnpyp);

$data = array();
$row_array['jummutasisiswa']=number_format($a['jummutasisiswa'],0,',','.');
$row_array['jumpdbmi']=number_format($b['jumpdbmi'],0,',','.');
$row_array['jummutasipendidik']=number_format($c['jummutasipendidik'],0,',','.');
$row_array['jumgantikepsek']=number_format($d['jumgantikepsek'],0,',','.');
$row_array['jumubahptk']=number_format($e['jumubahptk'],0,',','.');
$row_array['jumnpsn']=number_format($f['jumnpsn'],0,',','.');
$row_array['jumakunopt']=number_format($g['jumakunopt'],0,',','.');
$row_array['jumnpyp']=number_format($h['jumnpyp'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$dbconn->close();
?>  
