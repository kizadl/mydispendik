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
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agu";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

$sqlx = ("SELECT p.id_transaksi,p.no_order,p.nama_siswa,p.nik,p.nisn,
		p.kelamin,p.tempat_lahir,p.tgl_lahir,p.agama,p.kewarganegaraan,p.no_wa,
		p.alamat,p.desa,p.kecamatan,p.kabupaten,p.rombel,p.npsn,p.nm_sekolah,
		p.ket_level,p.stts_opt_sekolah,p.stts_opt_dapodik,p.ket_status_akhir,p.waktu_opt_sekolah,
		p.id_layanan,p.id_sekolah
		FROM tte_trans_verifikasi_pdb_mi p 
		WHERE p.arsip_admin='N' AND p.stts_opt_sekolah='terkirim' AND p.ket_level <> 'operator sekolah' ORDER BY p.id_transaksi DESC");
		
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	
	$mdcetak=md5($t['id_transaksi']);
	
	$sqldetail = ("SELECT COUNT(id_detail) AS JumSyarat FROM tte_detail_trans_persyaratan
		WHERE id_transaksi='".$t['id_transaksi']."' AND id_layanan='".$t['id_layanan']."' AND mode_upload='wajib' AND ket_persyaratan='TIDAK ADA'");
	$dbdetail = mysqli_query($dbconn, $sqldetail);
	$d = mysqli_fetch_assoc($dbdetail);
	$JumSyarat = $d['JumSyarat'];
	if ($JumSyarat >= 1){
		$sttssyarat = "belum";
	} else if ($JumSyarat <= 0){
		$sttssyarat = "sudah";
	}

	$row_array = array();
	$row_array['mdcetak']=$mdcetak;
	$row_array['no']=$no;
	$row_array['tglkirimoperator']=tgl_indo($t['waktu_opt_sekolah']);
	$row_array['idtransaksi']=$t['id_transaksi'];
	$row_array['idlayanan']=$t['id_layanan'];
	$row_array['noorder']=strtoupper($t['no_order']);
	$row_array['namasiswa']=ucwords(strtolower($t['nama_siswa']));
	$row_array['nisn']=$t['nisn'];
	$row_array['nik']=$t['nik'];
	$row_array['kelamin']=$t['kelamin'];
	$row_array['tmplahir']=$t['tempat_lahir'];
	$row_array['tgllahir']=tgl_indo($t['tgl_lahir']);
	$row_array['agama']=$t['agama'];
	$row_array['nowa']=strtoupper($t['no_wa']);
	$row_array['alamat']=$t['alamat'];
	$row_array['desa']=$t['desa'];
	$row_array['kecamatan']=$t['kecamatan'];
	$row_array['kabupaten']=$t['kabupaten'];
	
	$row_array['rombel']=$t['rombel'];
	$row_array['npsn']=$t['npsn'];
	$row_array['nmsekolah']=$t['nm_sekolah'];
	
	$row_array['ketlevel']=ucwords(strtolower($t['ket_level']));
	$row_array['sttsoptsekolah']=$t['stts_opt_sekolah'];
	$row_array['sttsoptdapodik']=$t['stts_opt_dapodik'];
	$row_array['ketstatusakhir']=ucwords(strtolower($t['ket_status_akhir']));
	
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['sttssyarat']=$sttssyarat;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
