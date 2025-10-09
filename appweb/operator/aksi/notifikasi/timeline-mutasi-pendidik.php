<?php
error_reporting(0);
require_once '../../../services/config.php';
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

$idstatus = trim($_POST['idstatus']);
$idtransaksi = trim($_POST['idtransaksi']);

$sqlx = ("SELECT p.nama_ptk,p.nik,p.nip,p.nuptk,
	p.tempat_lahir,p.tgl_lahir,p.kelamin,p.nm_ibu_kandung,p.no_wa,
	p.no_sk_pengangkatan,p.tmt_pengangkatan,
	p.nm_sekolah_penugasan,p.npsn_penugasan,p.stts_penugasan,p.id_jenis_ptk,
	p.no_surat_tugas,p.tgl_surat_tugas,p.tmt_surat_tugas,p.nm_sekolah_surat_tugas,p.npsn_surat_tugas,
	p.ijazah_s1,p.nm_pt,p.prog_studi,p.no_ijazah,p.thn_lulus,p.id_layanan,
  p.stts_opt_sekolah,p.waktu_opt_sekolah,p.stts_opt_dapodik,p.waktu_opt_dapodik,p.nm_operator_dapodik,
  p.ket_level,
  q.status_kepegawaian,r.jenis_ptk,s.lembaga_pangangkat 
  FROM tte_trans_mutasi_pendidik p
  LEFT JOIN tte_m_status_kepegawaian q ON p.id_status_kepegawaian = q.id_status
  LEFT JOIN tte_m_jenis_ptk r ON p.id_jenis_ptk = r.id_jenis
  LEFT JOIN tte_m_lembaga_pengangkat s ON p.id_lembaga_pengangkat = s.id_lembaga
  WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$nmpendidik = $sm['nama_ptk'];
$statuskepegawaian = $sm['status_kepegawaian'];
$nik = $sm['nik'];
$nip = strtoupper($sm['nip']);
$nuptk = strtoupper($sm['nuptk']);
$tmplahir = ucwords(strtolower($sm['tempat_lahir']));
$tgllahir = tgl_indo($sm['tgl_lahir']);

$kelamin = $sm['kelamin'];
if($kelamin == "L"){$jeniskelamin = "Laki-laki";} else if($kelamin == "P"){$jeniskelamin = "Perempuan";}

$nmibukandung = strtoupper($sm['nm_ibu_kandung']);
$noWA = $sm['no_wa'];

$noskpengangkatan = strtoupper($sm['no_sk_pengangkatan']);
$tmtpengangkatan = tgl_indo($sm['tmt_pengangkatan']);
$lembagapangangkat = ucwords(strtolower($sm['lembaga_pangangkat']));

$nmsekolahtugas = strtoupper($sm['nm_sekolah_penugasan']);
$npsntugas = strtoupper($sm['npsn_penugasan']);
$sttspenugasan = ucwords(strtolower($sm['stts_penugasan']));
$jenisptk = $sm['jenis_ptk'];

$nosurattugas = strtoupper($sm['no_surat_tugas']);
$tglsurattugas = tgl_indo($sm['tgl_surat_tugas']);
$tmtsurattugas = tgl_indo($sm['tmt_surat_tugas']);
$nmsekolahsurattugas = strtoupper($sm['nm_sekolah_surat_tugas']);
$npsnsurattugas = strtoupper($sm['npsn_surat_tugas']);

$ijazahs1 = $sm['ijazah_s1'];
if ($ijazahs1 == "Y"){
    $hidpendidikan = ""; 
    $namapt = ucwords(strtolower($sm['nm_pt']));
    $progstudy = ucwords(strtolower($sm['prog_studi']));
    $noijazah = strtoupper($sm['no_ijazah']);
    $thnlulus = $sm['thn_lulus'];
} else if ($ijazahs1 == "N"){
    $hidpendidikan = "display:none"; 
    $namapt = "";
    $progstudy = "";
    $noijazah = "";
    $thnlulus = "";
}

$nmoperatordapodik=ucwords(strtolower($sm['nm_operator_dapodik'] ?? ''));

/////// DETAIL TOLAK ///////////
$sqltolak = ("SELECT catatan_tolak,ket_level,waktu_tolak,status_akhir
		FROM tte_detail_tolak WHERE id_transaksi='" . $idtransaksi . "' AND id_layanan='" . $sm['id_layanan'] . "'");
$resulttolak = mysqli_query($dbconn, $sqltolak);
$catatantolak2 = "";
$tgltolak2 = "";
$jamtolak2 = "";

$hidtolak2 = "display:none !important";
$notl = 0;
while ($t = mysqli_fetch_array($resulttolak)) {
  $notl++;
  $ketleveltolak = $t['ket_level'];
  if ($ketleveltolak == "operator dapodik") {
    $catatantolak2 = $catatantolak2.$notl.". ". $t['catatan_tolak']."<br>";
    $hidtolak2 = "";
    $tgltolak2 = tgl_indo($t['waktu_tolak']);
    $jamtolak2 = date("H:i", strtotime($t['waktu_tolak']));
  }
}
////////////////////////////////////////
$sttslevel1 = ucwords(strtolower($sm['stts_opt_sekolah']));
if ($sttslevel1 == "Terkirim") {
  $dislevel1 = "";
} else if ($sttslevel1 == "Belum") {
  $dislevel1 = "display:none !important";
}
$tgllevel1 = tgl_indo($sm['waktu_opt_sekolah']);
$jamlevel1 = date("H:i", strtotime($sm['waktu_opt_sekolah']));

$sttslevel2 = ucwords(strtolower($sm['stts_opt_dapodik']));
if ($sttslevel2 == "Terima") {
  $dislevel2 = "";
} else if ($sttslevel2 == "Belum") {
  $dislevel2 = "display:none !important";
}
$tgllevel2 = tgl_indo($sm['waktu_opt_dapodik']);
$jamlevel2 = date("H:i", strtotime($sm['waktu_opt_dapodik'] ?? ''));

if ($sm['ket_level'] == "operator sekolah") {
  $tandalevel1 = "timeline-success timeline-current";
  $tandalevel2 = "timeline-primary";
  $hidoptsekolah = "";$hidoptdapodik = "hidden";
} else if ($sm['ket_level'] == "operator dapodik") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-success timeline-current";
  $hidoptsekolah = "";$hidoptdapodik = "";
}

$sql2  = "UPDATE tte_detail_status SET dibaca_operator_dapodik='Y' WHERE id_status='".$idstatus."'";
$res=mysqli_query($dbconn,$sql2);	

mysqli_free_result($restps);mysqli_free_result($resulttolak);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Timeline Status Persetujuan Mutasi Pendidik</h5>
    <p class="fs--1 mb-0 text-white">Timeline Status Permohonan Mutasi Pendidik</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light py-3 px-4">

  <div class="row mb-0 mt-2 g-3">
    <div class="col-md-12 bg-light">
      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-tie"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-2"><?php echo $nmpendidik ?></h6>
 
              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px">NIK</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $nik ?></td>
                </tr>
                <tr>
                  <td>Kelahiran</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $tmplahir ?>, <?php echo $tgllahir ?></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $jeniskelamin ?></td>
                </tr>
                <tr>
                  <td>Nama Ibu Kandung</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $nmibukandung ?></td>
                </tr>
                <tr>
                  <td>No. HP (WA)</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $noWA ?></strong></td>
                </tr>
              </table>

              <table class="fs--1 text-800 mb-0" style ="<?php echo $hidpendidikan ?>">
                <tr>
                  <td width="140px">Perguruan Tinggi</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $namapt ?></td>
                </tr>
                <tr>
                  <td>Program Studi</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $progstudy ?></td>
                </tr>
                <tr>
                  <td>Nomor Ijazah</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $noijazah ?></td>
                </tr>
                <tr>
                  <td>Tahun Lulus</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $thnlulus ?></td>
                </tr>
              </table>

            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-id-badge"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
           
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td width="140px" class="align-top">NIP</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $nip ?></td>
                </tr>
                <tr>
                  <td>NUPTK</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $nuptk ?></td>
                </tr>
                <tr>
                  <td>Status Kepegawaian</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $statuskepegawaian ?></td>
                </tr>
                <tr>
                  <td>Jenis PTK</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $jenisptk ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-mail-bulk"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">

              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px" class="align-top">No.SK Pengangkatan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $noskpengangkatan ?></strong></td>
                </tr>
                <tr>
                  <td>TMT Pengangkatan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $tmtpengangkatan ?></td>
                </tr>
                <tr>
                  <td>Nama Lembaga</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $lembagapangangkat ?></td>
                </tr>
              </table>

              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px" class="align-top">Sekolah Penugasan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $nmsekolahtugas ?></strong></td>
                </tr>
                <tr>
                  <td>NPSN</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $npsntugas ?></td>
                </tr>
                <tr>
                  <td>Status Penugasan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $sttspenugasan ?></td>
                </tr>
              </table>

              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px" class="align-top">No. Surat Tugas</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $nosurattugas ?></strong></td>
                </tr>
                <tr>
                  <td>Tanggal Surat Tugas</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $tglsurattugas ?></td>
                </tr>
                <tr>
                  <td>TMT Surat Tugas</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $tmtsurattugas ?></td>
                </tr>
                <tr>
                  <td>Sekolah</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $nmsekolahsurattugas ?></td>
                </tr>
                <tr>
                  <td>NPSN</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $npsnsurattugas ?></td>
                </tr>
              </table>

            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline <?php echo $tandalevel1 ?> pb-card" <?php echo $hidoptsekolah ?>>
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-edit"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1">Operator Sekolah</h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel1 ?>"><?php echo $tgllevel1 ?> &nbsp; - &nbsp; Jam <?php echo $jamlevel1 ?></p>
              <p class="fs--1 text-800 mb-0">Status <?php echo $sttslevel1 ?></p>
            </div>

          </div>
        </div>
      </div>

      <div class="row g-3 timeline <?php echo $tandalevel2 ?> pb-card" <?php echo $hidoptdapodik ?>>
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-chalkboard-teacher"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0">
            <div class="col">
              <h6 class="text-800 mb-1">Operator Dapodik</h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel2 ?>"><?php echo $nmoperatordapodik ?><br/><?php echo $tgllevel2 ?> Jam <?php echo $jamlevel2 ?></p>
              <p class="fs--1 text-800 mb-0">Status <?php echo $sttslevel2 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak2 ?>"><strong>Catatan :</strong><br><?php echo $catatantolak2 ?></p>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

</div>
<div class="modal-footer float-right">
  <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Close</button>
</div>