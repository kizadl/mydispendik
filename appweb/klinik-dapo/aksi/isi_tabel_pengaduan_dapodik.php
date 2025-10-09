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

$bentukpendidikan = trim($_POST['bentukpendidikan']);

$sqlx = ("SELECT p.id_transaksi,p.no_order,p.nik,p.nama,p.alamat,
		p.no_wa,p.bentuk_pendidikan,p.uraian_masalah,
		p.pengirim,p.ket_level,p.ket_status_akhir,p.waktu_create,
		p.id_sekolah,p.npsn,p.nama_sekolah
		FROM trans_pengaduan_dapodik p 
		WHERE p.aktif='Y' AND p.bentuk_pendidikan='".$bentukpendidikan."' ORDER BY p.id_transaksi DESC"); 
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	
	$mdcetak=md5($t['id_transaksi']);

	$row_array = array();
	$row_array['mdcetak']=$mdcetak;
	$row_array['no']=$no;
	$row_array['tglkirimoperator']=tgl_indo($t['waktu_create']);
	$row_array['idtransaksi']=$t['id_transaksi'];
	$row_array['noorder']=strtoupper($t['no_order']);
	
	$row_array['nik']=$t['nik'];
	$row_array['nama']=$t['nama'];
	$row_array['alamat']=$t['alamat'];
	$row_array['nowa']=$t['no_wa'];
	$row_array['bentukpendidikan']=strtoupper($t['bentuk_pendidikan']);
	$row_array['npsn']=$t['npsn'] ?? '-';
	$row_array['pengirim']=strtoupper($t['pengirim']);

	$row_array['uraianmasalah']=$t['uraian_masalah'];

	$row_array['ketlevel']=ucwords(strtolower($t['ket_level']));
	$row_array['ketstatusakhir']=ucwords(strtolower($t['ket_status_akhir']));
	
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['namasekolah']=strtoupper($t['nama_sekolah'] ?? '-');
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
