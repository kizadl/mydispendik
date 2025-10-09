<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kebutuhan-guru-smp.xls");
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
	$ketupload = "KURIKULUM SMP 2013 & KURIKULUM SMP MERDEKA";
} else if ($filterkebutuhan == "KMB") {
	$ketupload = "KURIKULUM SMP MERDEKA";
}

?>
<center>KEBUTUHAN GURU SEKOLAH MENENGAH PERTAMA (SMP)</center>
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
			<th colspan=13 style="background:#222;color:#fff;height:25px;">
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
				<center>PPKN</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>B. Indonesia</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>B. Inggris</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>Matematika</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>IPS</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>IPA</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>Prakarya</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>Seni Budaya</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>PJOK</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>Agama</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>Mulok</center>
			</th>
			<th style="background:#666;color:#fff;height:25px;width:90px">
				<center>BK</center>
			</th>
			<th style="background:#555;color:#fff;height:25px;width:90px">
				<center>Jumlah</center>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$ketsekolah = "SMP";

		$qrijam = ("SELECT id_mapel,jumlah_jam
		FROM m_jam_mapel WHERE bentuk_pendidikan='".$ketsekolah."' AND aktif='Y'");
		$dbjumlahjam = mysqli_query($dbconn, $qrijam);
		while($s=mysqli_fetch_array($dbjumlahjam)){
			if ($s['id_mapel'] == "200010000"){$jmljamPPKN = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "300110000"){$jmljamBIN = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "300210000"){$jmljamBING = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "401000000"){$jmljamMAT = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "401200000"){$jmljamIPS = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "401100000"){$jmljamIPA = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "600070000"){$jmljamPRAKARYA = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "600011000"){$jmljamSENI = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "500010000"){$jmljamPJOK = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "100011070" OR $s['id_mapel'] == "100012050"){$jmljamPAI = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "850010100" OR $s['id_mapel'] == "300311900"){$jmljamMULOK = $s['jumlah_jam'];}
			if ($s['id_mapel'] == "500050000"){$jmljamBK = $s['jumlah_jam'];}
		}

		if ($filterkebutuhan == "semua"){

			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.rombel_7,p.rombel_8,p.rombel_9,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");
		
		} else if ($filterkebutuhan == "KMB"){
		
			$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
			p.rombel_7,p.rombel_8,p.rombel_9,
			p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan,
			(p.ptk_guru_l+p.ptk_guru_p) AS JumGuru
			FROM spm_sekolah p 
			LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
			WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SMP Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
			
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

			$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SMP Merdeka',r.kurikulum,NULL)) AS jumKMB,
			COUNT(IF(r.kurikulum='Kurikulum SMP 2013',r.kurikulum,NULL)) AS jumK13 
			FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
			$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
			$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

			$jmlrombel = $t['rombel_7'] + $t['rombel_8'] + $t['rombel_9'] ;
	
			//// ideal kebutuhan guru ////
			$jumguruPPKNideal =($jmlrombel * $jmljamPPKN)/24;
			$jumguruBINideal =($jmlrombel * $jmljamBIN)/24;
			$jumguruBINGideal = ($jmlrombel * $jmljamBING)/24;
			$jumguruMATideal = ($jmlrombel * $jmljamMAT)/24;
			$jumguruIPSideal = ($jmlrombel * $jmljamIPS)/24;
			$jumguruIPAideal = ($jmlrombel * $jmljamIPA)/24;
			
			$jumguruPrakaryaideal = ($jmlrombel * $jmljamPRAKARYA)/24;
			$jumguruSeniideal = ($jmlrombel * $jmljamSENI)/24;
			$jumguruPJOKideal = ($jmlrombel * $jmljamPJOK)/24;
			$jumguruPAIideal = ($jmlrombel * $jmljamPAI)/24;
			$jumguruMulokideal = ($jmlrombel * $jmljamMULOK)/24;
			$jumguruBKideal = ($jmlrombel * $jmljamBK)/24;
		
			$jumguruTOTALideal = number_format($jumguruPPKNideal,1) + number_format($jumguruBINideal,1) + number_format($jumguruBINGideal,1) + number_format($jumguruMATideal,1)
				 + number_format($jumguruIPSideal,1) + number_format($jumguruIPAideal,1) + number_format($jumguruPrakaryaideal,1) + number_format($jumguruSeniideal,1)
				 + number_format($jumguruPJOKideal,1) + number_format($jumguruPAIideal,1) + number_format($jumguruMulokideal,1) + number_format($jumguruBKideal,1);
			
			$kurangguru = $t['JumGuru'] - $jumguruTOTALideal ;
			$kurangguru = round($kurangguru);
			
			if ($kurangguru <= 0){$warnahuruf = "red";} else if ($kurangguru >= 1) {$warnahuruf = "blue";}

			$jmlguru = round($t['JumGuru']);
			$jumguruTOTALideal = round($jumguruTOTALideal);

			$jumguruPPKNideal = number_format($jumguruPPKNideal,1);
			$jumguruBINideal = number_format($jumguruBINideal,1);
			$jumguruBINGideal = number_format($jumguruBINGideal,1);
			$jumguruMATideal = number_format($jumguruMATideal,1);
			$jumguruIPSideal = number_format($jumguruIPSideal,1);
			$jumguruIPAideal = number_format($jumguruIPAideal,1);
			
			$jumguruPrakaryaideal = number_format($jumguruPrakaryaideal,1);
			$jumguruSeniideal = number_format($jumguruSeniideal,1);
			$jumguruPJOKideal = number_format($jumguruPJOKideal,1);
			$jumguruPAIideal = number_format($jumguruPAIideal,1);
			$jumguruMulokideal = number_format($jumguruMulokideal,1);
			$jumguruBKideal = number_format($jumguruBKideal,1);

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
			$jumguruPPKNideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBINideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBINGideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruMATideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruIPSideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruIPAideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPrakaryaideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruSeniideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPJOKideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruPAIideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruMulokideal
		</td>
		<td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$jumguruBKideal
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