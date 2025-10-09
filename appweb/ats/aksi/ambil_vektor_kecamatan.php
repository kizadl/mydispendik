<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT kd_kecamatan,nama_kecamatan,geojson,latitude,longitude FROM m_kecamatan");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){

	$sqlcount = ("SELECT COUNT(IF(p.lulus_melanjutkan='Y',p.id_siswa,NULL)) AS jumLulus,
	COUNT(IF(p.pindah_sekolah='Y',p.id_siswa,NULL)) AS jumPindah,
	COUNT(IF(p.melanjutkan_ln='Y',p.id_siswa,NULL)) AS jumLN,
	COUNT(IF(p.melanjutkan_pesantren='Y',p.id_siswa,NULL)) AS jumMondok,
	COUNT(IF(p.ltm='Y',p.id_siswa,NULL)) AS jumLTM,
	COUNT(IF(p.do='Y',p.id_siswa,NULL)) AS jumDO,
	COUNT(IF(p.mengundurkan_diri='Y',p.id_siswa,NULL)) AS jumMengundurkanDiri,
	COUNT(IF(p.putus_sekolah='Y',p.id_siswa,NULL)) AS jumPutus,
	COUNT(IF(p.hilang='Y',p.id_siswa,NULL)) AS jumHilang,
	COUNT(IF(p.meninggal_dunia='Y',p.id_siswa,NULL)) AS jumWafat,
	COUNT(IF(p.aktif_kembali='Y',p.id_siswa,NULL)) AS jumAktif
	FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
	WHERE q.kd_kecamatan= '".$t['kd_kecamatan']."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$q= mysqli_fetch_assoc($resultcount);

	$row_array = array();

	$row_array['latitude']=$t['latitude'];
	$row_array['longitude']=$t['longitude'];
	
	$row_array['geojson'] = json_decode($t['geojson']);
	
	$row_array['kdkecamatan']=$t['kd_kecamatan'];
	$row_array['namakecamatan']=$t['nama_kecamatan'];

	$row_array['jumLulus']=$q['jumLulus'];
	$row_array['jumPindah']=$q['jumPindah'];
	$row_array['jumLN']=$q['jumLN'];
	$row_array['jumMondok']=$q['jumMondok'];
	$row_array['jumLTM']=$q['jumLTM'];
	$row_array['jumDO']=$q['jumDO'];
	$row_array['jumMengundurkanDiri']=$q['jumMengundurkanDiri'];
	$row_array['jumPutus']=$q['jumPutus'];
	$row_array['jumHilang']=$q['jumHilang'];
	$row_array['jumWafat']=$q['jumWafat'];
	$row_array['jumAktif']=$q['jumAktif'];
	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultcount->close();
$dbconn->close();
 ?>