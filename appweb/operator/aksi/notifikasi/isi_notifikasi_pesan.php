<?php
error_reporting(0);
include '../../../services/config.php';
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

$idsekolah = trim($_POST['idsekolah']);
$ketlevel = trim($_POST['ketlevel']);

$sqlx = ("SELECT p.id_pesan,p.id_layanan,p.id_transaksi,p.isi_pesan,p.waktu_pesan,
		p.nm_pengirim AS nmpengirim,p.id_sekolah,s.layanan
		FROM tte_detail_pesan p
		LEFT JOIN tte_m_layanan s ON p.id_layanan=s.id_layanan
		WHERE p.dibaca_operator_sekolah='N' AND p.pengirim='operator sekolah' AND p.id_sekolah='".$idsekolah."' OR p.dibaca_operator_sekolah='N' AND p.penerima='operator sekolah' AND p.id_sekolah='".$idsekolah."' ORDER BY p.waktu_pesan DESC");
		
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;$sttskirim = "belum";
while($t=mysqli_fetch_array($result)){
	$no++;	

	if ($t['id_layanan'] == "1"){
		/// cari status kirim operator dapodik - mutasi siswa
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_mutasi_siswa WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "2"){
		/// cari status kirim operator dapodik - pdb mi
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_verifikasi_pdb_mi WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "3"){
		/// cari status kirim operator dapodik - mutasi pendidik
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_mutasi_pendidik WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "4"){
		/// cari status kirim operator dapodik - pergantian kepsek
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_pergantian_kepsek WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "5"){
		/// cari status kirim operator dapodik - perubahan ptk
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_perubahan_ptk WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "6"){
		/// cari status kirim operator dapodik - pengajuan npsn
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_pengajuan_npsn WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "7"){
		/// cari status kirim operator dapodik - pengajuan akun operator
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_pengajuan_akun_operator WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	} else if ($t['id_layanan'] == "8"){
		/// cari status kirim operator dapodik - pengajuan npyp
		$sqlkrm = ("SELECT stts_opt_dapodik FROM tte_trans_pengajuan_npyp WHERE id_transaksi ='".$t['id_transaksi']."'");
		$resultkrm = mysqli_query($dbconn,$sqlkrm);$c = mysqli_fetch_assoc($resultkrm);
		$sttskirim = $c['stts_opt_dapodik'];
	}

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idpesan']=$t['id_pesan'];
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['idlayanan']=$t['id_layanan'];
	$row_array['idtransaksi']=$t['id_transaksi'];
	$row_array['isipesan']=$t['isi_pesan'];
	$row_array['waktupesan']=tgl_indo($t['waktu_pesan']);
	$row_array['jampesan']=date("H:i",strtotime($t['waktu_pesan']));
	
	$row_array['nmpengirim']=ucwords(strtolower($t['nmpengirim']));

	$row_array['nmlayanan']=$t['layanan'];
	$row_array['sttskirim']=$sttskirim;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
