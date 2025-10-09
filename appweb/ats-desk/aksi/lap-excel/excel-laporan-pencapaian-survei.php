<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data-pencapaian-target-survei.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: MYDISPENDIK");

error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
	switch ($bln) {
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
$tanggal = tgl_indo(date("Y-m-d"));

$idkecamatan = trim($_GET['idkecamatan']);
$iddesa = trim($_GET['iddesa']);
$namakecamatan = trim($_GET['namakecamatan']);
$namadesa = trim($_GET['namadesa']);
if ($idkecamatan == "all"){
	$ketkopexport = $namakecamatan;
} else if ($idkecamatan != "all" AND $iddesa == "all"){
	$ketkopexport = $namakecamatan;
} else if ($idkecamatan != "all" AND $iddesa != "all"){
	$ketkopexport = $namakecamatan." - ".$namadesa;
}
?>
<center>DATA PENCAPAIAN TARGET SURVEI ATS</center>
<center><?php echo $ketkopexport; ?></center>
<center>Cetak Tanggal <?php echo $tanggal; ?></center>

<table>
	<thead>
		<tr>
			<th style="background:#666;color:#fff;height:25px;width:50px">
				<center>NO</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:220px">
				<center>DATA SISWA</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:320px">
				<center>ALAMAT</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:320px">
				<center>KETERANGAN ATS</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:300px">
				<center>DATA HASIL SURVEI</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($idkecamatan == "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats p LEFT JOIN ats_surveyor q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' ORDER BY p.nama_siswa DESC");
		} else if ($idkecamatan != "all" and $iddesa == "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats p LEFT JOIN ats_surveyor q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.kd_kecamatan='" . $idkecamatan . "' ORDER BY p.nama_siswa DESC");
		} else if ($idkecamatan != "all" and $iddesa != "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats p LEFT JOIN ats_surveyor q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.kd_kecamatan='" . $idkecamatan . "' AND p.kd_desa='" . $iddesa . "' ORDER BY p.nama_siswa DESC");
		}
		$result = mysqli_query($dbconn, $sqlx);
		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;
			if ($t['nama_kecamatan'] == NULL) {
				$nmkecamatan = "-";
			} else {
				$nmkecamatan = ucwords(strtolower($t['nama_kecamatan']));
			}
			if ($t['nama_desa'] == NULL) {
				$nmdesa = "-";
			} else {
				$nmdesa = ucwords(strtolower($t['nama_desa']));
			}

			$namasiswa = ucwords(strtolower($t['nama_siswa']));
			if ($t['jenis_kelamin'] == "L") {
				$kelamin = "Laki-laki";
			} else if ($t['jenis_kelamin'] == "P") {
				$kelamin = "Perempuan";
			}
			$tmplahir = ucwords(strtolower($t['tmp_lahir']));
			$tgllahir = tgl_indo(date("Y-m-d", strtotime($t['tgl_lahir'])));
			$umur = $t['umur'];

			$alamat = ucwords(strtolower($t['alamat']));
			$rt = $t['rt'];
			$rw = $t['rw'];

			$namasekolah = $t['nama_sekolah'];
			$bentukpendidikan = $t['bentuk_pendidikan'];
			$tingkatpendidikan = $t['tingkat_pendidikan'];
			$tahun = $t['tahun'];
			$statusats = str_replace(' ', '', $t['status_ats']);

			$nmsurveyor = ucwords(strtolower($t['nm_surveyor']));
			$nim = $t['telepon'];

			$qridet = ("SELECT * FROM ats_detail_survei WHERE id_siswa='" . $t['id_siswa'] . "'");
			$dbdetail = mysqli_query($dbconn, $qridet);
			$d = mysqli_fetch_assoc($dbdetail);
			if ($d['lulus_melanjutkan'] == "Y") {
				$hasilsurvei = "Lulus Melanjutkan";
			} else if ($d['pindah_sekolah'] == "Y") {
				$hasilsurvei = "Mutasi / Pindah Sekolah";
			} else if ($d['melanjutkan_ln'] == "Y") {
				$hasilsurvei = "Melanjutkan Ke Luar Negeri";
			} else if ($d['melanjutkan_pesantren'] == "Y") {
				$hasilsurvei = "Melanjutkan Ke Pondok Pesantren";
			} else if ($d['ltm'] == "Y") {
				$hasilsurvei = "Lulus Tidak Melanjutkan";
			} else if ($d['do'] == "Y") {
				$hasilsurvei = "Dikeluarkan";
			} else if ($d['mengundurkan_diri'] == "Y") {
				$hasilsurvei = "Mengundurkan Diri";
			} else if ($d['putus_sekolah'] == "Y") {
				$hasilsurvei = "Putus Sekolah";
			} else if ($d['hilang'] == "Y") {
				$hasilsurvei = "Hilang";
			} else if ($d['meninggal_dunia'] == "Y") {
				$hasilsurvei = "Meninggal Dunia";
			} else if ($d['aktif_kembali'] == "Y") {
				$hasilsurvei = "Aktif Kembali";
			}
			$catatansurvei = $d['catatan'];
			$tglsurvei = tgl_indo($d['tgl_survei']);


			echo "	
	<tr style='height:25px;'>
        <td align='center' style='vertical-align:top;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
        <td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$namasiswa<br>$kelamin ($umur tahun)<br>$tmplahir, $tgllahir
		</td>
        <td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$alamat RT $rt RW $rw<br>$nmdesa - $nmkecamatan
		</td>
		<td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$statusats $bentukpendidikan Tahun $tahun Tingkat $tingkatpendidikan<br>$namasekolah
		</td>
		<td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$nmsurveyor ($nim)<br>$tglsurvei<br>$hasilsurvei<br>$catatansurvei
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>