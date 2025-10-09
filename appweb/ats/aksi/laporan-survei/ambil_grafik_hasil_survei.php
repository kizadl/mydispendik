<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idkecamatan = trim($_POST['idkecamatan']);
$iddesa = trim($_POST['iddesa']);

$data = array();
if ($idkecamatan == "all"){
	$sqlcount = ("SELECT COUNT(IF(lulus_melanjutkan='Y',0,null)) AS jumLulusMelanjutkan,
		COUNT(IF(pindah_sekolah='Y',0,null)) AS jumPindahSekolah,
		COUNT(IF(melanjutkan_ln='Y',0,null)) AS jumMelanjutkanLN,
		COUNT(IF(melanjutkan_pesantren='Y',0,null)) AS jumPesantren,
		COUNT(IF(ltm='Y',0,null)) AS jumLTM,
		COUNT(IF(do='Y',0,null)) AS jumDO,
		COUNT(IF(mengundurkan_diri='Y',0,null)) AS jumUndurDiri,
		COUNT(IF(putus_sekolah='Y',0,null)) AS jumPutus,
		COUNT(IF(hilang='Y',0,null)) AS jumHilang,
		COUNT(IF(meninggal_dunia='Y',0,null)) AS jumWafat,
		COUNT(IF(aktif_kembali='Y',0,null)) AS jumAktif FROM ats_detail_survei");
	
	$sqlats = ("SELECT COUNT(id_siswa) AS jumSiswaATS FROM tbl_ats");
	$sqlATSsudah = ("SELECT COUNT(id_siswa) AS jumATSSudah FROM ats_detail_survei");
	$sqlsurveyor = ("SELECT COUNT(id_surveyor) AS jumSurveyor FROM ats_surveyor");
	$sqlsurveyorsudah = ("SELECT COUNT(DISTINCT id_surveyor) AS jumSurveyorSudah 
		FROM ats_detail_survei");

} else if ($idkecamatan != "all" AND $iddesa =="all"){
	$sqlcount = ("SELECT COUNT(IF(p.lulus_melanjutkan='Y',0,null)) AS jumLulusMelanjutkan,
		COUNT(IF(p.pindah_sekolah='Y',0,null)) AS jumPindahSekolah,
		COUNT(IF(p.melanjutkan_ln='Y',0,null)) AS jumMelanjutkanLN,
		COUNT(IF(p.melanjutkan_pesantren='Y',0,null)) AS jumPesantren,
		COUNT(IF(p.ltm='Y',0,null)) AS jumLTM,
		COUNT(IF(p.do='Y',0,null)) AS jumDO,
		COUNT(IF(p.mengundurkan_diri='Y',0,null)) AS jumUndurDiri,
		COUNT(IF(p.putus_sekolah='Y',0,null)) AS jumPutus,
		COUNT(IF(p.hilang='Y',0,null)) AS jumHilang,
		COUNT(IF(p.meninggal_dunia='Y',0,null)) AS jumWafat,
		COUNT(IF(p.aktif_kembali='Y',0,null)) AS jumAktif 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan = '".$idkecamatan."'");

	$sqlats = ("SELECT COUNT(id_siswa) AS jumSiswaATS FROM tbl_ats WHERE kd_kecamatan='".$idkecamatan."'");
	$sqlATSsudah = ("SELECT COUNT(p.id_siswa) AS jumATSSudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan='".$idkecamatan."'");
	$sqlsurveyor = ("SELECT COUNT(id_surveyor) AS jumSurveyor FROM ats_surveyor WHERE id_kecamatan='".$idkecamatan."'");
	$sqlsurveyorsudah = ("SELECT COUNT(DISTINCT p.id_surveyor) AS jumSurveyorSudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa 
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan='".$idkecamatan."'");

} else if ($idkecamatan != "all" AND $iddesa !="all"){
	$sqlcount = ("SELECT COUNT(IF(p.lulus_melanjutkan='Y',0,null)) AS jumLulusMelanjutkan,
		COUNT(IF(p.pindah_sekolah='Y',0,null)) AS jumPindahSekolah,
		COUNT(IF(p.melanjutkan_ln='Y',0,null)) AS jumMelanjutkanLN,
		COUNT(IF(p.melanjutkan_pesantren='Y',0,null)) AS jumPesantren,
		COUNT(IF(p.ltm='Y',0,null)) AS jumLTM,
		COUNT(IF(p.do='Y',0,null)) AS jumDO,
		COUNT(IF(p.mengundurkan_diri='Y',0,null)) AS jumUndurDiri,
		COUNT(IF(p.putus_sekolah='Y',0,null)) AS jumPutus,
		COUNT(IF(p.hilang='Y',0,null)) AS jumHilang,
		COUNT(IF(p.meninggal_dunia='Y',0,null)) AS jumWafat,
		COUNT(IF(p.aktif_kembali='Y',0,null)) AS jumAktif 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa = '".$iddesa."'");

	$sqlats = ("SELECT COUNT(id_siswa) AS jumSiswaATS FROM tbl_ats WHERE kd_desa='".$iddesa."'");
	$sqlATSsudah = ("SELECT COUNT(p.id_siswa) AS jumATSSudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa='".$iddesa."'");
	$sqlsurveyor = ("SELECT COUNT(id_surveyor) AS jumSurveyor FROM ats_surveyor WHERE id_desa='".$iddesa."'");
	$sqlsurveyorsudah = ("SELECT COUNT(DISTINCT p.id_surveyor) AS jumSurveyorSudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats q ON p.id_siswa=q.id_siswa 
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa='".$iddesa."'");
}

$resultcount = mysqli_query($dbconn, $sqlcount);
$s = mysqli_fetch_assoc($resultcount);

$resultsqlats = mysqli_query($dbconn, $sqlats);
$t = mysqli_fetch_assoc($resultsqlats);
$jumSiswaATS = number_format($t['jumSiswaATS'], 0, ',', '.');

$resultsqlATSsudah = mysqli_query($dbconn, $sqlATSsudah);
$u = mysqli_fetch_assoc($resultsqlATSsudah);
$jumATSSudah = number_format($u['jumATSSudah'], 0, ',', '.');
$jumATSBelum = $t['jumSiswaATS'] - $u['jumATSSudah'];
$jumATSSudahPersen = ($u['jumATSSudah'] / $t['jumSiswaATS'])*100;
$jumATSBelumPersen = ($jumATSBelum / $t['jumSiswaATS'])*100;

$resultsqlsurveyor = mysqli_query($dbconn, $sqlsurveyor);
$v = mysqli_fetch_assoc($resultsqlsurveyor);
$jumSurveyor = number_format($v['jumSurveyor'], 0, ',', '.');

$resultsqlsurveyorsudah = mysqli_query($dbconn, $sqlsurveyorsudah);
$w = mysqli_fetch_assoc($resultsqlsurveyorsudah);
$jumSurveyorSudah = number_format($w['jumSurveyorSudah'], 0, ',', '.');
$jumSurveyorBelum = $v['jumSurveyor'] - $w['jumSurveyorSudah'];
$jumSurveyorSudahPersen = ($w['jumSurveyorSudah'] / $v['jumSurveyor'])*100;
$jumSurveyorBelumPersen = ($jumSurveyorBelum / $v['jumSurveyor'])*100;

$row_array = array();
$row_array['jumLulusMelanjutkan'] = $s['jumLulusMelanjutkan'];
$row_array['jumPindahSekolah'] = $s['jumPindahSekolah'];
$row_array['jumMelanjutkanLN'] = $s['jumMelanjutkanLN'];
$row_array['jumPesantren'] = $s['jumPesantren'];
$row_array['jumLTM'] = $s['jumLTM'];
$row_array['jumDO'] = $s['jumDO'];
$row_array['jumUndurDiri'] = $s['jumUndurDiri'];
$row_array['jumPutus'] = $s['jumPutus'];
$row_array['jumHilang'] = $s['jumHilang'];
$row_array['jumWafat'] = $s['jumWafat'];
$row_array['jumAktif'] = $s['jumAktif'];

$row_array['jumSiswaATS'] = $jumSiswaATS;
$row_array['jumATSSudah'] = $jumATSSudah;
$row_array['jumATSBelum'] = number_format($jumATSBelum, 0, ',', '.');
$row_array['jumATSSudahPersen'] = number_format($jumATSSudahPersen, 2, ',', '.');
$row_array['jumATSBelumPersen'] = number_format($jumATSBelumPersen, 2, ',', '.');
$row_array['jumSurveyor'] = $jumSurveyor;
$row_array['jumSurveyorSudah'] = $jumSurveyorSudah;
$row_array['jumSurveyorBelum'] = number_format($jumSurveyorBelum, 0, ',', '.');;
$row_array['jumSurveyorSudahPersen'] = number_format($jumSurveyorSudahPersen, 2, ',', '.');
$row_array['jumSurveyorBelumPersen'] = number_format($jumSurveyorBelumPersen, 2, ',', '.');

array_push($data, $row_array);

echo json_encode($data);
$dbconn->close();
