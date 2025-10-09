<?php
error_reporting(0);
include '../../../../services/config.php';
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

function anti_injection($data){
    global $dbconn;
    $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
    return $filter;
}

$idsekolah = anti_injection(trim($_POST['idsekolah']));
$idlayanan = anti_injection(trim($_POST['idlayanan']));
$idtransaksi = anti_injection(trim($_POST['idtransaksi']));

$sqlx = ("SELECT p.isi_pesan,p.pengirim,p.nm_pengirim,p.penerima,p.waktu_pesan
		FROM tte_detail_pesan p 
		WHERE p.id_sekolah='".$idsekolah."' AND p.id_transaksi='".$idtransaksi."' AND id_layanan='".$idlayanan."' ORDER BY p.id_pesan ASC");
		
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	

	$row_array = array();
	$row_array['isipesan']=$t['isi_pesan'];
	$row_array['tglpesan']=tgl_indo($t['waktu_pesan']);
	$row_array['jampesan']= date("H:i", strtotime($t['waktu_pesan']));
	$row_array['pengirim']=$t['pengirim'];
	$row_array['penerima']=$t['penerima'];
	$row_array['nmpengirim']=ucwords(strtolower($t['nm_pengirim']));

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  
