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

$sqlx = ("SELECT p.id_status,p.id_layanan,p.id_transaksi,p.isi_status,p.waktu_status,
		p.nm_pengirim AS nmpengirim,s.layanan
		FROM tte_detail_status p
		LEFT JOIN tte_m_layanan s ON p.id_layanan=s.id_layanan
		WHERE p.dibaca_operator_dapodik='N' ORDER BY p.waktu_status DESC");
		
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;$sttskirim = "belum";
while($t=mysqli_fetch_array($result)){
	$no++;	

	$row_array = array();
	$row_array['no']=$no;
	$row_array['idstatus']=$t['id_status'];
	$row_array['idlayanan']=$t['id_layanan'];
	$row_array['idtransaksi']=$t['id_transaksi'];
	$row_array['isistatus']=$t['isi_status'];
	$row_array['tglstatus']=tgl_indo($t['waktu_status']);
	$row_array['jamstatus']=date("H:i",strtotime($t['waktu_status']));
	
	$row_array['nmpengirim']=ucwords(strtolower($t['nmpengirim']));

	$row_array['nmlayanan']=$t['layanan'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
