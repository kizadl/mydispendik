<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kebutuhan-guru-sd.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: IKM");

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

$filterkebutuhan = trim($_GET['filterkebutuhan']);

if ($filterkebutuhan == "semua") {
	$ketupload = "KURIKULUM SD 2013 & KURIKULUM SD MERDEKA";
} else if ($filterkebutuhan == "KMB") {
	$ketupload = "KURIKULUM SD MERDEKA";
}

?>
<center>KEBUTUHAN GURU SEKOLAH DASAR (SD)</center>
<center><?php echo $ketupload; ?></center>
<center>Tanggal Cetak <?php echo $tanggal; ?></center>

<table>
	<thead>
		<tr>
			<th rowspan=2 style="background:#444;color:#fff;height:25px;width:45px">
				<center>NO</center>
			</th>
			<th rowspan=2 style="background:#222;color:#fff;height:25px;width:75px">
				<center>NPSN</center>
			</th>
			<th rowspan=2 style="background:#444;color:#fff;height:25px;width:250px">
				<center>Nama Sekolah</center>
			</th>
			<th rowspan=2 style="background:#222;color:#fff;height:25px;width:75px">
				<center>Status</center>
			</th>
			<th colspan=4 style="background:#444;color:#fff;height:25px;">
				<center>Jumlah</center>
			</th>
			<th colspan=6 style="background:#222;color:#fff;height:25px;">
				<center>Jumlah Ideal Kebutuhan Guru</center>
			</th>
			<th rowspan=2 style="background:#444;color:#fff;height:25px;width:100px">
				<center>Kurang/Lebih</center>
			</th>
		</tr>
		<tr>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>K-13</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>K-MB</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:60px">
				<center>Rombel</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:60px">
				<center>Guru</center>
			</th>

			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>Guru Kelas</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>PJOK</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>PAI</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>B. Inggris</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>Lainnya</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>Jumlah</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$ketsekolah = "SD";

		$qrijam = ("SELECT id_mapel,jumlah_jam
		FROM m_jam_mapel WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
		$dbjumlahjam = mysqli_query($dbconn, $qrijam);
		while($s=mysqli_fetch_array($dbjumlahjam)){
			if ($s['id_mapel'] == "500010000"){$jmljamPJOK = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "100011000" OR $s['id_mapel'] == "100011070"){$jmljamPAI = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "300210000"){$jmljamBING = $s['jumlah_jam'];}
			if ($s['id_mapel'] != "400200000" OR $s['id_mapel'] != "500010000" OR $s['id_mapel'] != "100011000" OR $s['id_mapel'] != "100011070" OR $s['id_mapel'] != "300210000"){$jmljamLAIN = 4;}
		}

		if ($filterkebutuhan == "semua"){

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");
		
		} else if ($filterkebutuhan == "KMB"){
		
			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
			WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SD Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
			
		} 

		$result = mysqli_query($dbconn, $sqlx);

		$no = 0;
		while ($t = mysqli_fetch_array($result)) {
			$no++;

			$npsn = $t['npsn'];
			$sttssekolah = $t['status_sekolah'];

			if (substr($t['nama_sekolah'], 0, 53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN") {
				$nmsekolah = substr($t['nama_sekolah'], 54);
			} else {
				$nmsekolah = $t['nama_sekolah'];
			}

			$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SD Merdeka',r.kurikulum,NULL)) AS jumKMB,
			COUNT(IF(r.kurikulum='Kurikulum SD 2013',r.kurikulum,NULL)) AS jumK13 
			FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
			$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
			$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

			$jmlrombel = $t['rombel_1'] + $t['rombel_2'] + $t['rombel_3'] + $t['rombel_4'] + $t['rombel_5'] + $t['rombel_6'];
	
			//// ideal kebutuhan guru ////
			$jumgurukelasideal = $jumKMB + $jumK13;
			$jumguruPJOKideal = ($jmlrombel * $jmljamPJOK)/24;
			$jumguruPAIideal = ($jmlrombel * $jmljamPAI)/24;
			$jumguruLAINideal = ($jmlrombel * $jmljamLAIN)/24;
			$jumguruBINGideal = ($jumKMB * $jmljamBING)/24;
			if ($jumKMB >= 1){
				if ($jumguruBINGideal <= 1){$jumguruBINGideal = 1;} else {$jumguruBINGideal = round($jumguruBINGideal);}
			} else if ($jumKMB <= 0){$jumguruBINGideal = 0;}
			$jumguruTOTALideal = round($jumgurukelasideal) + round($jumguruPJOKideal) + round($jumguruPAIideal) + $jumguruBINGideal + round($jumguruLAINideal);
			
			$kurangguru = $t['JumGuru'] - $jumguruTOTALideal ;
			if ($kurangguru <= 0){$warnahuruf = "red";} else if ($kurangguru >= 1) {$warnahuruf = "blue";}

			$jmlguru = $t['JumGuru'];
			$jumguruTOTALideal = round($jumguruTOTALideal);
			
			$npsn = $t['npsn'];
			$sttssekolah = $t['status_sekolah'];
			$nmsekolah = $nmsekolah;

			$jumguruPJOKideal = round($jumguruPJOKideal);
			$jumguruPAIideal = round($jumguruPAIideal);
			$jumguruLAINideal = round($jumguruLAINideal);
			$jumguruBINGideal = round($jumguruBINGideal);

			echo "	
	<tr style='height:25px;'>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$no
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$npsn
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmsekolah
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 30px 15px;'>
			$sttssekolah
		</td>
        <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumK13
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumKMB
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlrombel
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jmlguru
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumgurukelasideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPJOKideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPAIideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBINGideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruLAINideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			<strong>$jumguruTOTALideal</strong>
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;color:$warnahuruf ;'>
			<strong>$kurangguru</strong>
		</td>
	</tr>";
		}

		mysqli_free_result($result);
		mysqli_close($dbconn);
		?>
	</tbody>
</table>