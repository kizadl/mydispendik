 <?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
$idsurveyor = trim($_POST['idsurveyor']);
 
 $sqlx = ("SELECT p.id_siswa,p.kd_kecamatan,p.kd_desa,p.kecamatan,p.desa,p.alamat,
			p.rt,p.rw,p.nama_sekolah,p.bentuk_pendidikan,p.tahun,p.tingkat_pendidikan,
			p.nama_siswa,p.jenis_kelamin,p.tgl_lahir,p.tmp_lahir,p.umur,p.survei,p.status_ats,
			q.lulus_melanjutkan,q.pindah_sekolah,q.melanjutkan_ln,q.melanjutkan_pesantren,q.ltm,
			q.do,q.mengundurkan_diri,q.putus_sekolah,q.hilang,q.meninggal_dunia,q.aktif_kembali,
			id_catatan,catatan
		 	FROM tbl_ats p LEFT JOIN ats_detail_survei q ON p.id_siswa=q.id_siswa
			WHERE p.id_surveyor='".$idsurveyor."'");			
 $myArray = array(); 
 $result = mysqli_query($dbconn,$sqlx);
 $jumbelum =0;$jumsudah =0;$jumtotal =0;
 while($t = $result->fetch_array(MYSQLI_ASSOC)) {	
	$jumtotal++;
	if($t['survei'] == "N"){$jumbelum++;}
	else if($t['survei'] == "Y"){$jumsudah++;}

	if($t['jenis_kelamin'] == "L"){$pilihL="selected";} else {$pilihL="";}
	if($t['jenis_kelamin'] == "P"){$pilihP="selected";} else {$pilihP="";}

	$row_array = array();
	$row_array['idsiswa']=$t['id_siswa'];
	$row_array['idkecamatan']=str_replace(' ', '', $t['kd_kecamatan']); 
	$row_array['iddesa']=$t['kd_desa'];
	$row_array['kecamatan']=$t['kecamatan'];$row_array['desa']=$t['desa'];
	$row_array['alamat']=preg_replace("/[^a-zA-Z]/", " ",$t['alamat']);
	$row_array['rt']=$t['rt'];$row_array['rw']=$t['rw'];
	
	$row_array['namasekolah']=preg_replace("/[^a-zA-Z]/", " ",$t['nama_sekolah']);
	$row_array['bentukpendidikan']=preg_replace("/[^a-zA-Z]/", " ",$t['bentuk_pendidikan']);
	$row_array['tahun']=$t['tahun'];
	$row_array['tingkatpendidikan']=preg_replace("/[^a-zA-Z]/", " ",$t['tingkat_pendidikan']);

	$row_array['namasiswa']=$t['nama_siswa'];$row_array['jeniskelamin']=$t['jenis_kelamin'];
	$row_array['tgllahir']=date("Y-m-d",strtotime($t['tgl_lahir']));
	$row_array['tmplahir']=$t['tmp_lahir'];$row_array['umur']=$t['umur'];
	$row_array['survei']=$t['survei'];$row_array['statusats']=$t['status_ats'];

	$row_array['jumsudah']=$jumsudah;
	$row_array['jumbelum']=$jumbelum;
	$row_array['jumtotal']=$jumtotal;

	$row_array['pilihL']=$pilihL;
	$row_array['pilihP']=$pilihP;
	
	$row_array['lulusmelanjutkan']=$t['lulus_melanjutkan'];$row_array['pindahsekolah']=$t['pindah_sekolah'];
	$row_array['melanjutkanln']=$t['melanjutkan_ln'];$row_array['melanjutkanpesantren']=$t['melanjutkan_pesantren'];
	$row_array['ltm']=$t['ltm'];$row_array['do']=$t['do'];
	
	$row_array['mengundurkandiri']=$t['mengundurkan_diri'];$row_array['putussekolah']=$t['putus_sekolah'];$row_array['hilang']=$t['hilang'];
	$row_array['meninggaldunia']=$t['meninggal_dunia'];

	$row_array['aktifkembali']=$t['aktif_kembali'];$row_array['idcatatan']=$t['id_catatan'];$row_array['catatan']=$t['catatan'];
	
	array_push($myArray,$row_array);
 }
echo json_encode($myArray);
$result->close();
$dbconn->close();
?>  
