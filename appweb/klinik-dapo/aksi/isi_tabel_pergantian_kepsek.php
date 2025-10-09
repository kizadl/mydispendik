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

$sqlx = ("SELECT p.id_transaksi,p.no_order,p.nama,p.nik,p.nip,p.nuptk,p.no_wa,
		p.nm_sekolah_asal,p.npsn_asal,
		p.nm_sekolah_tugas,p.npsn_tugas,p.stts_penugasan,
		p.no_surat_tugas,p.tgl_surat_tugas,p.tmt_surat_tugas,
		p.ijazah_s1,p.nm_pt,p.prog_studi,p.no_ijazah,p.thn_lulus,
		p.ket_level,p.stts_opt_sekolah,p.stts_opt_dapodik,p.ket_status_akhir,p.waktu_opt_sekolah,
		p.id_layanan,p.id_sekolah
		FROM tte_trans_pergantian_kepsek p 
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
	$row_array['namakepsek'] = $t['nama'];
	$row_array['nip']=strtoupper($t['nip']);
	$row_array['nowa']=$t['no_wa'];

	$row_array['nmsekolahasal']=$t['nm_sekolah_asal'];
	$row_array['npsnasal']=$t['npsn_asal'];

	$row_array['nmsekolahpenugasan']=$t['nm_sekolah_tugas'];
	$row_array['npsnpenugasan']=$t['npsn_tugas'];
	$row_array['sttspenugasan']=ucwords(strtolower($t['stts_penugasan']));

	$row_array['nosurattugas']=$t['no_surat_tugas'];
	$row_array['tglsurattugas']=tgl_indo($t['tgl_surat_tugas']);
	$row_array['tmtsurattugas']=tgl_indo($t['tmt_surat_tugas']);

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
