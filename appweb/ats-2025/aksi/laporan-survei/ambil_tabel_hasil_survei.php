<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idkecamatan = trim($_POST['idkecamatan']);
$iddesa = trim($_POST['iddesa']);

$data = array();
if ($idkecamatan == "all") {
	$sqlcount = ("SELECT 
		COUNT(IF(p.pindah_sekolah='Y',p.id_siswa,null)) AS jumPindahSekolah,
		COUNT(IF(p.melanjutkan_ln='Y',p.id_siswa,null)) AS jumMelanjutkanLN,
		COUNT(IF(p.melanjutkan_pesantren='Y',p.id_siswa,null)) AS jumPesantren,
		COUNT(IF(p.ltm='Y',p.id_siswa,null)) AS jumLTM,
		COUNT(IF(p.do='Y',p.id_siswa,null)) AS jumDO,
		COUNT(IF(p.mengundurkan_diri='Y',p.id_siswa,null)) AS jumUndurDiri,
		COUNT(IF(p.putus_sekolah='Y',p.id_siswa,null)) AS jumPutus,
		COUNT(IF(p.hilang='Y',p.id_siswa,null)) AS jumHilang,
		COUNT(IF(p.meninggal_dunia='Y',p.id_siswa,null)) AS jumWafat,
		COUNT(IF(p.aktif_kembali='Y',p.id_siswa,null)) AS jumAktif,

		COUNT(IF(p.pindah_sekolah='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPindahSekolahL,
		COUNT(IF(p.melanjutkan_ln='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumMelanjutkanLNL,
		COUNT(IF(p.melanjutkan_pesantren='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPesantrenL,
		COUNT(IF(p.ltm='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumLTML,
		COUNT(IF(p.do='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumDOL,
		COUNT(IF(p.mengundurkan_diri='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumUndurDiriL,
		COUNT(IF(p.putus_sekolah='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPutusL,
		COUNT(IF(p.hilang='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumHilangL,
		COUNT(IF(p.meninggal_dunia='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumWafatL,
		COUNT(IF(p.aktif_kembali='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumAktifL,

		COUNT(IF(p.pindah_sekolah='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPindahSekolahP,
		COUNT(IF(p.melanjutkan_ln='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumMelanjutkanLNP,
		COUNT(IF(p.melanjutkan_pesantren='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPesantrenP,
		COUNT(IF(p.ltm='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumLTMP,
		COUNT(IF(p.do='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumDOP,
		COUNT(IF(p.mengundurkan_diri='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumUndurDiriP,
		COUNT(IF(p.putus_sekolah='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPutusP,
		COUNT(IF(p.hilang='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumHilangP,
		COUNT(IF(p.meninggal_dunia='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumWafatP,
		COUNT(IF(p.aktif_kembali='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumAktifP 
		FROM ats_detail_survei p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y'");

	$sqlATSsudah = ("SELECT COUNT(id_siswa) AS jumATSSudah FROM ats_detail_survei");
} else if ($idkecamatan != "all" and $iddesa == "all") {
	$sqlcount = ("SELECT 
		COUNT(IF(p.pindah_sekolah='Y',p.id_siswa,null)) AS jumPindahSekolah,
		COUNT(IF(p.melanjutkan_ln='Y',p.id_siswa,null)) AS jumMelanjutkanLN,
		COUNT(IF(p.melanjutkan_pesantren='Y',p.id_siswa,null)) AS jumPesantren,
		COUNT(IF(p.ltm='Y',p.id_siswa,null)) AS jumLTM,
		COUNT(IF(p.do='Y',p.id_siswa,null)) AS jumDO,
		COUNT(IF(p.mengundurkan_diri='Y',p.id_siswa,null)) AS jumUndurDiri,
		COUNT(IF(p.putus_sekolah='Y',p.id_siswa,null)) AS jumPutus,
		COUNT(IF(p.hilang='Y',p.id_siswa,null)) AS jumHilang,
		COUNT(IF(p.meninggal_dunia='Y',p.id_siswa,null)) AS jumWafat,
		COUNT(IF(p.aktif_kembali='Y',p.id_siswa,null)) AS jumAktif,

		COUNT(IF(p.pindah_sekolah='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPindahSekolahL,
		COUNT(IF(p.melanjutkan_ln='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumMelanjutkanLNL,
		COUNT(IF(p.melanjutkan_pesantren='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPesantrenL,
		COUNT(IF(p.ltm='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumLTML,
		COUNT(IF(p.do='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumDOL,
		COUNT(IF(p.mengundurkan_diri='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumUndurDiriL,
		COUNT(IF(p.putus_sekolah='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPutusL,
		COUNT(IF(p.hilang='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumHilangL,
		COUNT(IF(p.meninggal_dunia='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumWafatL,
		COUNT(IF(p.aktif_kembali='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumAktifL,

		COUNT(IF(p.pindah_sekolah='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPindahSekolahP,
		COUNT(IF(p.melanjutkan_ln='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumMelanjutkanLNP,
		COUNT(IF(p.melanjutkan_pesantren='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPesantrenP,
		COUNT(IF(p.ltm='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumLTMP,
		COUNT(IF(p.do='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumDOP,
		COUNT(IF(p.mengundurkan_diri='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumUndurDiriP,
		COUNT(IF(p.putus_sekolah='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPutusP,
		COUNT(IF(p.hilang='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumHilangP,
		COUNT(IF(p.meninggal_dunia='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumWafatP,
		COUNT(IF(p.aktif_kembali='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumAktifP 
		FROM ats_detail_survei p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan = '" . $idkecamatan . "'");

	$sqlATSsudah = ("SELECT COUNT(p.id_siswa) AS jumATSSudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_kecamatan='" . $idkecamatan . "'");
} else if ($idkecamatan != "all" and $iddesa != "all") {
	$sqlcount = ("SELECT 
		COUNT(IF(p.pindah_sekolah='Y',p.id_siswa,null)) AS jumPindahSekolah,
		COUNT(IF(p.melanjutkan_ln='Y',p.id_siswa,null)) AS jumMelanjutkanLN,
		COUNT(IF(p.melanjutkan_pesantren='Y',p.id_siswa,null)) AS jumPesantren,
		COUNT(IF(p.ltm='Y',p.id_siswa,null)) AS jumLTM,
		COUNT(IF(p.do='Y',p.id_siswa,null)) AS jumDO,
		COUNT(IF(p.mengundurkan_diri='Y',p.id_siswa,null)) AS jumUndurDiri,
		COUNT(IF(p.putus_sekolah='Y',p.id_siswa,null)) AS jumPutus,
		COUNT(IF(p.hilang='Y',p.id_siswa,null)) AS jumHilang,
		COUNT(IF(p.meninggal_dunia='Y',p.id_siswa,null)) AS jumWafat,
		COUNT(IF(p.aktif_kembali='Y',p.id_siswa,null)) AS jumAktif,

		COUNT(IF(p.pindah_sekolah='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPindahSekolahL,
		COUNT(IF(p.melanjutkan_ln='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumMelanjutkanLNL,
		COUNT(IF(p.melanjutkan_pesantren='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPesantrenL,
		COUNT(IF(p.ltm='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumLTML,
		COUNT(IF(p.do='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumDOL,
		COUNT(IF(p.mengundurkan_diri='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumUndurDiriL,
		COUNT(IF(p.putus_sekolah='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumPutusL,
		COUNT(IF(p.hilang='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumHilangL,
		COUNT(IF(p.meninggal_dunia='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumWafatL,
		COUNT(IF(p.aktif_kembali='Y' AND q.jenis_kelamin='L',p.id_siswa,null)) AS jumAktifL,

		COUNT(IF(p.pindah_sekolah='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPindahSekolahP,
		COUNT(IF(p.melanjutkan_ln='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumMelanjutkanLNP,
		COUNT(IF(p.melanjutkan_pesantren='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPesantrenP,
		COUNT(IF(p.ltm='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumLTMP,
		COUNT(IF(p.do='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumDOP,
		COUNT(IF(p.mengundurkan_diri='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumUndurDiriP,
		COUNT(IF(p.putus_sekolah='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumPutusP,
		COUNT(IF(p.hilang='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumHilangP,
		COUNT(IF(p.meninggal_dunia='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumWafatP,
		COUNT(IF(p.aktif_kembali='Y' AND q.jenis_kelamin='P',p.id_siswa,null)) AS jumAktifP 
		FROM ats_detail_survei p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa = '" . $iddesa . "'");

	$sqlATSsudah = ("SELECT COUNT(p.id_siswa) AS jumATSSudah 
		FROM ats_detail_survei p LEFT JOIN tbl_ats_2025 q ON p.id_siswa=q.id_siswa
		WHERE p.id_siswa=q.id_siswa AND q.survei='Y' AND q.kd_desa='" . $iddesa . "'");
}

$resultcount = mysqli_query($dbconn, $sqlcount);
$s = mysqli_fetch_assoc($resultcount);

$resultsqlATSsudah = mysqli_query($dbconn, $sqlATSsudah);
$u = mysqli_fetch_assoc($resultsqlATSsudah);

if ($u['jumATSSudah'] >= 1) {
	$persenPindahSekolah = number_format(($s['jumPindahSekolah'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenMelanjutkanLN = number_format(($s['jumMelanjutkanLN'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenPesantren = number_format(($s['jumPesantren'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenLTM = number_format(($s['jumLTM'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenDO = number_format(($s['jumDO'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenUndurDiri = number_format(($s['jumUndurDiri'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenPutus = number_format(($s['jumPutus'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenHilang = number_format(($s['jumHilang'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenWafat = number_format(($s['jumWafat'] / $u['jumATSSudah']) * 100, 2, ',', '.');
	$persenAktif = number_format(($s['jumAktif'] / $u['jumATSSudah']) * 100, 2, ',', '.');
} else if ($u['jumATSSudah'] <= 0) {
	$persenPindahSekolah = 0;
	$persenMelanjutkanLN = 0;
	$persenPesantren = 0;
	$persenLTM = 0;
	$persenDO = 0;
	$persenUndurDiri = 0;
	$persenPutus = 0;
	$persenHilang = 0;
	$persenWafat = 0;
	$persenAktif = 0;
}

$row_array = array();
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

$row_array['jumPindahSekolahL'] = $s['jumPindahSekolahL'];
$row_array['jumMelanjutkanLNL'] = $s['jumMelanjutkanLNL'];
$row_array['jumPesantrenL'] = $s['jumPesantrenL'];
$row_array['jumLTML'] = $s['jumLTML'];
$row_array['jumDOL'] = $s['jumDOL'];
$row_array['jumUndurDiriL'] = $s['jumUndurDiriL'];
$row_array['jumPutusL'] = $s['jumPutusL'];
$row_array['jumHilangL'] = $s['jumHilangL'];
$row_array['jumWafatL'] = $s['jumWafatL'];
$row_array['jumAktifL'] = $s['jumAktifL'];

$row_array['jumPindahSekolahP'] = $s['jumPindahSekolahP'];
$row_array['jumMelanjutkanLNP'] = $s['jumMelanjutkanLNP'];
$row_array['jumPesantrenP'] = $s['jumPesantrenP'];
$row_array['jumLTMP'] = $s['jumLTMP'];
$row_array['jumDOP'] = $s['jumDOP'];
$row_array['jumUndurDiriP'] = $s['jumUndurDiriP'];
$row_array['jumPutusP'] = $s['jumPutusP'];
$row_array['jumHilangP'] = $s['jumHilangP'];
$row_array['jumWafatP'] = $s['jumWafatP'];
$row_array['jumAktifP'] = $s['jumAktifP'];

$row_array['persenPindahSekolah'] = $persenPindahSekolah;
$row_array['persenMelanjutkanLN'] = $persenMelanjutkanLN;
$row_array['persenPesantren'] = $persenPesantren;
$row_array['persenLTM'] = $persenLTM;
$row_array['persenDO'] = $persenDO;
$row_array['persenUndurDiri'] = $persenUndurDiri;
$row_array['persenPutus'] = $persenPutus;
$row_array['persenHilang'] = $persenHilang;
$row_array['persenWafat'] = $persenWafat;
$row_array['persenAktif'] = $persenAktif;

array_push($data, $row_array);

echo json_encode($data);
$dbconn->close();