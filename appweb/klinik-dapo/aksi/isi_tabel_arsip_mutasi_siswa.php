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

$idinstansi =trim($_POST['idinstansi']);
$tglawal =trim($_POST['tglawal']);$tglawal = date("Y-m-d",strtotime($tglawal));
$tglakhir =trim($_POST['tglakhir']);$tglakhir = date("Y-m-d",strtotime($tglakhir));

$sqlx = ("SELECT p.id_surat,p.no_surat,p.tgl_surat,p.nik,p.nama,p.file_surat,
		p.ket_level,p.stts_level_1,p.stts_level_2,p.stts_level_3,p.stts_level_4,p.stts_level_5,p.stts_level_6,p.stts_level_7,p.ket_status,
		p.id_layanan,p.id_instansi,p.rekom_baru,
		r.layanan,s.nm_instansi
		FROM trans_surat p 
		LEFT JOIN m_layanan r ON p.id_layanan=r.id_layanan
		LEFT JOIN m_instansi s ON p.id_instansi=s.id_instansi
		WHERE p.arsip='Y' AND p.tgl_surat >= '".$tglawal."' AND p.tgl_surat <= '".$tglakhir."' AND p.ket_status='terima' OR p.arsip='Y' AND p.tgl_surat >= '".$tglawal."' AND p.tgl_surat <= '".$tglakhir."' AND p.ket_status='tolak' ORDER BY p.id_surat DESC");	

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	
	$mdcetak=md5($t['id_surat']);

	if ($t['ket_status']=="terima"){
		$disarsip='';$diskirim='display:none';
	} else if ($t['ket_status']=="belum"){
		$disarsip='display:none';$diskirim='';
	}

	$sqldetail = ("SELECT COUNT(id_detail) AS JumSyarat FROM detail_persyaratan
		WHERE id_surat='".$t['id_surat']."' AND ket_persyaratan='TIDAK ADA'");
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
	$row_array['no']=$no;$row_array['disarsip']=$disarsip;$row_array['diskirim']=$diskirim;
	$row_array['idsurat']=$t['id_surat'];
	$row_array['nosurat']=$t['no_surat'];
	$row_array['tglsurat']=tgl_indo($t['tgl_surat']);
	$row_array['nik']=$t['nik'];
	$row_array['nmpemohon']=$t['nama'];
	$row_array['filesurat']=$t['file_surat'];
	
	$row_array['ketstatus']=ucwords(strtolower($t['ket_status']));
	$row_array['ketlevel']=$t['ket_level'];
	$row_array['sttslevel1']=$t['stts_level_1'];
	$row_array['sttslevel2']=$t['stts_level_2'];
	$row_array['sttslevel3']=$t['stts_level_3'];
	$row_array['sttslevel4']=$t['stts_level_4'];
	$row_array['sttslevel5']=$t['stts_level_5'];
	$row_array['sttslevel6']=$t['stts_level_6'];
	$row_array['sttslevel7']=$t['stts_level_7'];

	$row_array['idlayanan']=$t['id_layanan'];
	$row_array['idinstansi']=$t['id_instansi'];
	$row_array['ketrekom']=$t['rekom_baru'];

	$row_array['layanan']=$t['layanan'];
	$row_array['nminstansi']=strtoupper($t['nm_instansi']);
	$row_array['sttssyarat']=$sttssyarat;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$dbdetail->close();
$dbconn->close();
?>  
