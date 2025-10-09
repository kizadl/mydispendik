<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data-hasil-survei.xls");
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

$filterdata = trim($_GET['filterdata']);
$ketkopexport = trim($_GET['ketkopexport']);
$idkecamatan = trim($_GET['idkecamatan']);
$iddesa = trim($_GET['iddesa']);
$iduniversitas = trim($_GET['iduniversitas']);
$idfakultas = trim($_GET['idfakultas']);
$umur = trim($_GET['umur']);
$bentukpendidikan = trim($_GET['bentukpendidikan']);
$kategori = trim($_GET['kategori']);

?>
<center>DATA HASIL SURVEI ATS</center>
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
			<th style="background:#666;color:#fff;height:25px;width:300px">
				<center>DATA HASIL WAWANCARA</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($filterdata == "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' ORDER BY p.nama_siswa DESC");
		} else if ($filterdata == "kecamatan" and $idkecamatan != "all" and $iddesa == "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.kd_kecamatan='" . $idkecamatan . "' ORDER BY p.nama_siswa DESC");
		} else if ($filterdata == "desa" and $idkecamatan != "all" and $iddesa != "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.kd_kecamatan='" . $idkecamatan . "' AND p.kd_desa='" . $iddesa . "' ORDER BY p.nama_siswa DESC");
		} else if ($filterdata == "universitas" and $iduniversitas != "all" and $idfakultas == "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND q.id_universitas='" . $iduniversitas . "' ORDER BY p.nama_siswa DESC");
		} else if ($filterdata == "fakultas" and $iduniversitas != "all" and $idfakultas != "all") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND q.id_fakultas='" . $idfakultas . "' ORDER BY p.nama_siswa DESC");
		} else if ($filterdata == "umur") {
			if ($umur == "7-12") {
				$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.umur >= 7 AND p.umur <= 12 ORDER BY p.nama_siswa DESC");
			} else if ($umur == "13-15") {
				$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.umur >= 13 AND p.umur <= 15 ORDER BY p.nama_siswa DESC");
			} else if ($umur == "16-18") {
				$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.umur >= 16 AND p.umur <= 18 ORDER BY p.nama_siswa DESC");
			}
		} else if ($filterdata == "bentuk pendidikan" and $bentukpendidikan != "") {
			$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			WHERE p.survei='Y' AND p.bentuk_pendidikan='" . $bentukpendidikan . "' ORDER BY p.nama_siswa DESC");
		} else if ($filterdata == "kategori") {
			if ($kategori == "LTM") {
				$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			LEFT JOIN ats_detail_survei_2025 t ON p.id_siswa=t.id_siswa
			WHERE p.survei='Y' AND LOWER(JSON_EXTRACT(t.detail, '$.klasifikasi')) = 'ltm' ORDER BY p.nama_siswa ASC");
			} else if ($kategori == "DO") {
				$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			LEFT JOIN ats_detail_survei_2025 t ON p.id_siswa=t.id_siswa
			WHERE p.survei='Y' AND LOWER(JSON_EXTRACT(t.detail, '$.klasifikasi')) = 'do' ORDER BY p.nama_siswa ASC");
			} else if ($kategori == "BPB") {
				$sqlx = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,p.alamat,p.rt,p.rw,
			p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.status_ats,p.survei,p.desk,
			q.nm_surveyor,q.telepon,r.nama_kecamatan,s.nama_desa
			FROM tbl_ats_2025 p LEFT JOIN ats_surveyor_2025 q ON p.id_surveyor=q.id_surveyor
			LEFT JOIN m_kecamatan r ON p.kd_kecamatan=r.kd_kecamatan
			LEFT JOIN m_desa s ON p.kd_desa=s.kd_desa
			LEFT JOIN ats_detail_survei_2025 t ON p.id_siswa=t.id_siswa
			WHERE p.survei='Y' AND LOWER(JSON_EXTRACT(t.detail, '$.klasifikasi')) = 'bpb' ORDER BY p.nama_siswa ASC");
			}
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

			$qridet = ("SELECT * FROM ats_detail_survei_2025 WHERE id_siswa='" . $t['id_siswa'] . "'");
			$dbdetail = mysqli_query($dbconn, $qridet);
			$d = mysqli_fetch_assoc($dbdetail);

			$klasifikasi = '';
			if (!empty($d['detail'])) {
				$detail_json = json_decode($d['detail'], true);
				if (isset($detail_json['klasifikasi'])) {
					$klasifikasi = strtolower($detail_json['klasifikasi']);
				}
			}

			if ($klasifikasi == 'ltm') {
				$hasilsurvei = "Lulus Tidak Melanjutkan";
			} else if ($klasifikasi == 'do') {
				$hasilsurvei = "Putus Sekolah";
			} else if ($klasifikasi == 'bpb') {
				$hasilsurvei = "Belum Pernah Bersekolah";
			} else {
				$hasilsurvei = "Lainnya";
			}
			$tglsurvei = tgl_indo($d['tgl_survei']);

			$desk = $t['desk'];
			if ($desk == "Y") {
				$qrids = ("SELECT p.berhenti_sekolah,p.berhenti_covid,p.alasan,p.id_kegiatan_siswa,p.id_keterampilan_siswa,p.lanjut_sekolah,p.id_sekolah,p.no_telepon,p.tgl_desk,
        q.npsn,q.nama,r.nm_user,s.kegiatan_siswa,t.keterampilan
		 FROM ats_detail_desk p LEFT JOIN tbl_api_dispendik q ON p.id_sekolah=q.id_sekolah
     LEFT JOIN ats_user_2025 r ON p.id_operator_desk=r.id
     LEFT JOIN ats_kegiatan_siswa s ON p.id_kegiatan_siswa=s.id_kegiatan
     LEFT JOIN ats_keterampilan_siswa t ON p.id_keterampilan_siswa=t.id_keterampilan
    WHERE p.id_siswa='" . $t['id_siswa'] . "'");
				$dbqueryds = mysqli_query($dbconn, $qrids);
				$s = mysqli_fetch_assoc($dbqueryds);

				$tgldesk = tgl_indo(date("Y-m-d", strtotime($s['tgl_desk'])));
				$berhentisekolah = $s['berhenti_sekolah'];
				$berhenticovid = $s['berhenti_covid'];
				$alasan = $s['alasan'];
				$idkegiatansiswa = $s['id_kegiatan_siswa'];
				$kegiatansiswa = $s['kegiatan_siswa'];
				$idketerampilansiswa = $s['id_keterampilan_siswa'];
				$keterampilan = $s['keterampilan'];
				$lanjutsekolah = $s['lanjut_sekolah'];
				$notelepon = $s['no_telepon'];
				$namauserdesk = $s['nm_user'];

				if ($lanjutsekolah == "Y") {
					$namasekolahdetail = $s['nama'];
					$npsn = $s['npsn'];
				} else if ($lanjutsekolah == "N") {
					$namasekolahdetail = "";
					$npsn = "";
				}

				$isihasildesk =
					"<table>
                <tr>
                  <td class='align-top' width='140px' class='align-top'>Tanggal Wawancara</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$tgldesk</td>
                </tr>
                <tr>
                  <td class='align-top'>Pewawancara</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$namauserdesk</td>
                </tr>
                <tr>
                  <td class='align-top'>Berhenti Sekolah</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$berhentisekolah</td>
                </tr>
                <tr>
                  <td class='align-top'>Berhenti Saat Covid</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$berhenticovid</td>
                </tr>
                <tr>
                  <td class='align-top'>Alasan</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$alasan</td>
                </tr>
                <tr>
                  <td class='align-top'>Kegiatan Siswa</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$kegiatansiswa</td>
                </tr>
                <tr>
                  <td class='align-top'>Keterampilan Siswa</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$keterampilan</td>
                </tr>
                <tr>
                  <td class='align-top'>Sekolah Kembali</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class='align-top'>$namasekolahdetail - $npsn</td>
                </tr>
                <tr>
                  <td class='align-top'>No. Telepon</td>
                  <td class='align-top'>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td align='left' class='align-top'>$notelepon</td>
                </tr>
              </table>";
			} else if ($desk == "N") {
				$isihasildesk  = "";
			}

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
			$nmsurveyor ($nim)<br>$tglsurvei<br>$hasilsurvei
		</td>
		<td align='left' style='vertical-align:top;border: 1px dotted #999;padding: 3px 5px;'>
			$isihasildesk
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>