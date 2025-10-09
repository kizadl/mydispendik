<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
} 

$idkoordinator = trim($_POST['idkoordinator']);

$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.id_surveyor,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats
		FROM tbl_ats p LEFT JOIN ats_surveyor q ON p.id_surveyor=q.id_surveyor
		WHERE q.id_koordinator='".$idkoordinator."' ORDER BY p.nama_siswa DESC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;$jumsurveinya = 0;
while($t=mysqli_fetch_array($result)){
	$no++;	 

	$qricbg3 = ("SELECT id_siswa FROM ats_detail_survei WHERE id_siswa='" . $t['id_siswa'] . "'");
	$dbcabang3 = mysqli_query($dbconn, $qricbg3);
	$jumsurvei = mysqli_num_rows($dbcabang3);
	if ($jumsurvei == 0 OR $jumsurvei == NULL){
		$jumsurveinya = "0";
	} else {
		$jumsurveinya =$jumsurvei;
	}

	$statusats = str_replace(' ', '',$t['status_ats']);
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsiswa']=$t['id_siswa'];
	$row_array['idsurveyor']=$t['id_surveyor'];
	$row_array['namasiswa']=ucwords(strtolower($t['nama_siswa']));
	$row_array['kelamin']=$t['jenis_kelamin'];
	$row_array['tmplahir']=ucwords(strtolower($t['tmp_lahir']));
	$row_array['tgllahir']=tgl_indo(date("Y-m-d",strtotime($t['tgl_lahir'])));
	$row_array['umur']=$t['umur'];

	$row_array['alamat']=ucwords(strtolower($t['alamat']));
	$row_array['rt']=$t['rt'];
	$row_array['rw']=$t['rw'];
	$row_array['desa']=ucwords(strtolower($t['desa']));
	$row_array['kecamatan']=ucwords(strtolower($t['kecamatan']));
	$row_array['kdkecamatan']=$t['kd_kecamatan'];
	
	$row_array['namasekolah']=$t['nama_sekolah'];
	$row_array['bentukpendidikan']=$t['bentuk_pendidikan'];
	$row_array['tingkatpendidikan']=$t['tingkat_pendidikan'];
	$row_array['tahun']=$t['tahun'];
	$row_array['semester']=$t['semester'];
	$row_array['statusats']=$statusats;
	$row_array['jumsurvei']=$jumsurveinya;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
