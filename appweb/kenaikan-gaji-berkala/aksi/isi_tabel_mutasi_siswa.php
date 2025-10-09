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

$sqlx = ("SELECT p.id_transaksi,p.no_order,p.no_surat,p.tgl_surat,p.no_wa,p.nama_siswa,p.kelas,p.nis,
		p.nik,p.asal_sekolah,p.npsn_asal_sekolah,p.mutasi_ke,p.npsn_mutasi,p.alasan_mutasi,
		p.ket_level,p.stts_opt_sekolah,p.stts_opt_dapodik,p.stts_opt_bidang,p.stts_kasi,p.stts_kabid,p.ket_status_surat,
		p.id_layanan,p.id_sekolah,p.id_bidang
		FROM tte_trans_mutasi_siswa p 
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
	$row_array['idtransaksi']=$t['id_transaksi'];
	$row_array['idlayanan']=$t['id_layanan'];
	$row_array['noorder']=$t['no_order'];
	$row_array['nosurat']=$t['no_surat'];
	$row_array['tglsurat']=tgl_indo($t['tgl_surat']);
	$row_array['nowa']=$t['no_wa'];
	$row_array['namasiswa']=ucwords(strtolower($t['nama_siswa']));
	$row_array['kelas']=$t['kelas'];
	$row_array['nis']=$t['nis'];
	$row_array['nik']=$t['nik'];
	$row_array['asalsekolah']=$t['asal_sekolah'];
	$row_array['npsnasalsekolah']=$t['npsn_asal_sekolah'];
	$row_array['mutasike']=$t['mutasi_ke'];
	$row_array['npsnmutasi']=$t['npsn_mutasi'];
	$row_array['alasanmutasi']=$t['alasan_mutasi'];
	
	$row_array['ketlevel']=ucwords(strtolower($t['ket_level']));
	$row_array['sttsoptsekolah']=$t['stts_opt_sekolah'];
	$row_array['sttsoptdapodik']=$t['stts_opt_dapodik'];
	$row_array['sttsoptbidang']=$t['stts_opt_bidang'];
	$row_array['sttskasi']=$t['stts_kasi'];
	$row_array['sttskabid']=$t['stts_kabid'];
	$row_array['ketstatussurat']=ucwords(strtolower($t['ket_status_surat']));
	
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['idbidang']=$t['id_bidang'];
	$row_array['sttssyarat']=$sttssyarat;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
