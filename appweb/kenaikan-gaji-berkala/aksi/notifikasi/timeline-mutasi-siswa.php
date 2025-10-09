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
$mdidtransaksi = md5($idtransaksi);

$sqlx = ("SELECT * FROM tte_trans_mutasi_siswa p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$nosurat = $sm['no_surat'];
$nowa = $sm['no_wa'];
$tglsurat = tgl_indo($sm['tgl_surat']);
$namasiswa = ucwords(strtolower($sm['nama_siswa']));
$tempatlahir = ucwords(strtolower($sm['tempat_lahir']));
$tgllahir = tgl_indo($sm['tgl_lahir']);
$agama = ucwords(strtolower($sm['agama']));
$namaortu = ucwords(strtolower($sm['nama_ortu']));
$pekerjaanortu = ucwords(strtolower($sm['pekerjaan_ortu']));
$kelas = strtoupper($sm['kelas']);
$nik = $sm['nik'];
$nis = $sm['nis'];

$asalsekolah = strtoupper($sm['asal_sekolah']);
$npsnasal = strtoupper($sm['npsn_asal_sekolah']);
$mutasike = strtoupper($sm['mutasi_ke']);
$npsnmutasi = strtoupper($sm['npsn_mutasi']);
$alasanmutasi = ucwords(strtolower($sm['alasan_mutasi']));

$nosuketmutasi = strtoupper($sm['no_suket_mutasi'] ?? '');
$tglsuketmutasi = tgl_indo($sm['tgl_suket_mutasi'] ?? '');
$nosuketpindah = strtoupper($sm['no_suket_pindah'] ?? '');
$tglsuketpindah = tgl_indo($sm['tgl_suket_pindah'] ?? '');

if ($sm['file_rekomendasi'] == "Y") {
  $rekomendasi = strtoupper($sm['rekomendasi']);
  $norekomendasi = strtoupper($sm['no_rekomendasi']);
  $tglrekomendasi = tgl_indo($sm['tgl_rekomendasi']);
} else {
  $rekomendasi = "";
  $norekomendasi = "";
  $tglrekomendasi = "";
}

$nmoperatordapodik=ucwords(strtolower($sm['nm_operator_dapodik'] ?? ''));
$nmoperatorbidang=ucwords(strtolower($sm['nm_operator_bidang'] ?? ''));

$nmbidang=ucwords(strtolower($sm['nm_bidang'] ?? ''));
$nmkabid=$sm['nm_kabid'];
$jabatankabid=ucwords(strtolower($sm['jabatan_kabid'] ?? ''));
$nipkabid=$sm['nip_kabid'];

$nmseksi=ucwords(strtolower($sm['nm_seksi'] ?? ''));
$nmkasi=$sm['nm_kasi'];
$jabatankasi=ucwords(strtolower($sm['jabatan_kasi'] ?? ''));
$nipkasi=$sm['nip_kasi'];

/////// DETAIL TOLAK ///////////
$sqltolak = ("SELECT catatan_tolak,ket_level,waktu_tolak,status_akhir
		FROM tte_detail_tolak WHERE id_transaksi='" . $idtransaksi . "' AND id_layanan='" . $sm['id_layanan'] . "'");
$resulttolak = mysqli_query($dbconn, $sqltolak);
$catatantolak2 = "";
$catatantolak3 = "";
$catatantolak4 = "";
$catatantolak5 = "";
$catatantolak7 = "";
$tgltolak2 = "";
$tgltolak3 = "";
$tgltolak4 = "";
$tgltolak5 = "";
$tgltolak7 = "";
$jamtolak2 = "";
$jamtolak3 = "";
$jamtolak4 = "";
$jamtolak5 = "";
$jamtolak7 = "";

$hidtolak2 = "display:none !important";
$hidtolak3 = "display:none !important";
$hidtolak4 = "display:none !important";
$hidtolak5 = "display:none !important";
$hidtolak7 = "display:none !important";
while ($t = mysqli_fetch_array($resulttolak)) {
  $ketleveltolak = $t['ket_level'];
  if ($ketleveltolak == "kepala seksi") {
    $catatantolak4 = $t['catatan_tolak'];
    $hidtolak4 = "";
    $tgltolak4 = tgl_indo($t['waktu_tolak']);
    $jamtolak4 = date("H:i", strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "kepala bidang") {
    $catatantolak5 = $t['catatan_tolak'];
    $hidtolak5 = "";
    $tgltolak5 = tgl_indo($t['waktu_tolak']);
    $jamtolak5 = date("H:i", strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "kepala bidang") {
    $catatantolak7 = $t['catatan_tolak'];
    $hidtolak7 = "";
    $tgltolak7 = tgl_indo($t['waktu_tolak']);
    $jamtolak7 = date("H:i", strtotime($t['waktu_tolak']));
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
if ($sttslevel2 == "Terkirim") {
  $dislevel2 = "";
} else if ($sttslevel2 == "Belum") {
  $dislevel2 = "display:none !important";
}
$tgllevel2 = tgl_indo($sm['waktu_opt_dapodik']);
$jamlevel2 = date("H:i", strtotime($sm['waktu_opt_dapodik'] ?? ''));

$sttslevel3 = ucwords(strtolower($sm['stts_opt_bidang']));
if ($sttslevel3 == "Terkirim") {
  $dislevel3 = "";
} else if ($sttslevel3 == "Belum") {
  $dislevel3 = "display:none !important";
}
$tgllevel3 = tgl_indo($sm['waktu_opt_bidang']);
$jamlevel3 = date("H:i", strtotime($sm['waktu_opt_bidang'] ?? ''));

$sttslevel4 = ucwords(strtolower($sm['stts_kasi']));
if ($sttslevel4 == "Terima") {
  $dislevel4 = "";
} else if ($sttslevel4 == "Belum") {
  $dislevel4 = "display:none !important";
}
$tgllevel4 = tgl_indo($sm['waktu_kasi']);
$jamlevel4 = date("H:i", strtotime($sm['waktu_kasi'] ?? ''));

$sttslevel5 = ucwords(strtolower($sm['stts_kabid']));
if ($sttslevel5 == "Terima") {
  $dislevel5 = "";
} else if ($sttslevel5 == "Belum") {
  $dislevel5 = "display:none !important";
}
$tgllevel5 = tgl_indo($sm['waktu_kabid']);
$jamlevel5 = date("H:i", strtotime($sm['waktu_kabid'] ?? ''));

$sttslevel7 = ucwords(strtolower($sm['ket_status_surat']));
if ($sttslevel7 == "Terima") {
  $dislevel7 = "";
} else if ($sttslevel7 == "Belum") {
  $dislevel7 = "display:none !important";
}
$tgllevel7 = tgl_indo($sm['waktu_kabid']);
$jamlevel7 = date("H:i", strtotime($sm['waktu_kabid'] ?? ''));

if ($sm['ket_level'] == "operator sekolah") {
  $tandalevel1 = "timeline-success timeline-current";
  $tandalevel2 = "timeline-primary";
  $tandalevel3 = "timeline-primary";
  $tandalevel4 = "timeline-primary";
  $tandalevel5 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
  $hidoptsekolah = "";$hidoptdapodik = "hidden";$hidoptbidang = "hidden";$hidkasi = "hidden";
  $hidkabid = "hidden";$hidtte = "hidden";
} else if ($sm['ket_level'] == "operator dapodik") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-success timeline-current";
  $tandalevel3 = "timeline-primary";
  $tandalevel4 = "timeline-primary";
  $tandalevel5 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
  $hidoptsekolah = "";$hidoptdapodik = "";$hidoptbidang = "hidden";$hidkasi = "hidden";
  $hidkabid = "hidden";$hidtte = "hidden";
} else if ($sm['ket_level'] == "operator bidang") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-success timeline-current";
  $tandalevel4 = "timeline-primary";
  $tandalevel5 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
  $hidoptsekolah = "";$hidoptdapodik = "";$hidoptbidang = "";$hidkasi = "hidden";
  $hidkabid = "hidden";$hidtte = "hidden";
} else if ($sm['ket_level'] == "kepala seksi") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-success timeline-current";
  $tandalevel5 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
  $hidoptsekolah = "";$hidoptdapodik = "";$hidoptbidang = "";$hidkasi = "";
  $hidkabid = "hidden";$hidtte = "hidden";
} else if ($sm['ket_level'] == "kepala bidang") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-primary timeline-current";
  $tandalevel5 = "timeline-success timeline-current";
  $tandalevelakhir = "timeline-primary";
  $hidoptsekolah = "";$hidoptdapodik = "";$hidoptbidang = "";$hidkasi = "";
  $hidkabid = "";$hidtte = "";
} else if ($sm['ket_status_surat'] == "terima") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-primary timeline-current";
  $tandalevel5 = "timeline-primary timeline-current";
  $tandalevelakhir = "timeline-success timeline-current";
  $hidoptsekolah = "";$hidoptdapodik = "";$hidoptbidang = "";$hidkasi = "";
  $hidkabid = "";$hidtte = "";
}

$sql2  = "UPDATE tte_detail_status SET dibaca_operator_dapodik='Y' WHERE id_status='".$idstatus."'";
$res=mysqli_query($dbconn,$sql2);	

mysqli_free_result($restps);mysqli_free_result($resulttolak);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Timeline Status Surat</h5>
    <p class="fs--1 mb-0 text-white">Timeline Status Permohonan Surat Mutasi Siswa</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light py-3 px-4">

  <div class="row mb-3 mt-2 g-3">
    <div class="col-md-12 bg-light">
      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-graduate"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1"><?php echo $namasiswa ?></h6>
              <p class="fs--1 text-800 mb-0">NIK. <?php echo $nik ?> / NIS. <?php echo $nis ?></p>

              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td class="align-top">Kelas</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $kelas ?></strong></td>
                </tr>
                <tr>
                  <td>Kelahiran</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $tempatlahir ?>, <?php echo $tgllahir ?></td>
                </tr>
                <tr>
                  <td>Agama</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $agama ?></td>
                </tr>
                <tr>
                  <td>Orang Tua</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $namaortu ?></td>
                </tr>
                <tr>
                  <td>Pekerjaan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $pekerjaanortu ?></td>
                </tr>
                <tr>
                  <td>No. HP (WA)</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $nowa ?></strong></td>
                </tr>

              </table>

            </div>
          </div>
        </div>
      </div>
      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1">Surat Rekomendasi Mutasi Siswa</h6>
              <p class="fs--1 text-800 mb-0">No. Surat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;<?php echo $nosurat ?><br />
                Tanggal &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;<?php echo $tglsurat ?></p>
              <p class="fs--1 text-800 mb-0">Sekolah Asal &nbsp;: &nbsp;&nbsp;<strong><?php echo $asalsekolah ?></strong></p>
              <p class="fs--1 text-800 mb-0">Mutasi Ke &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;<strong><?php echo $mutasike ?></strong></p>
              <p class="fs--1 text-800 mb-0"><strong>Alasan Mutasi</strong><br /><?php echo $alasanmutasi ?></p>
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
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1">Operator Dapodik</h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel2 ?>"><?php echo $nmoperatordapodik ?><br/><?php echo $tgllevel2 ?> Jam <?php echo $jamlevel2 ?></p>
              <p class="fs--1 text-800 mb-0">Status <?php echo $sttslevel2 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak2 ?>"><?php echo $catatantolak2 ?></p>
            </div>

          </div>
        </div>
      </div>


      <div class="row g-3 timeline <?php echo $tandalevel3 ?> pb-card"  <?php echo $hidoptbidang ?>>
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1">Operator Bidang <?php echo $nmbidang ?></h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel3 ?>"><?php echo $nmoperatorbidang ?><br/><?php echo $tgllevel3 ?> Jam <?php echo $jamlevel3 ?></p>
              <p class="fs--1 text-800 mb-0">Status <?php echo $sttslevel3 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak3 ?>"><?php echo $catatantolak3 ?></p>
            </div>

          </div>
        </div>
      </div>


      <div class="row g-3 timeline <?php echo $tandalevel4 ?> pb-card" <?php echo $hidkasi ?>>
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-check"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1"><?php echo $jabatankasi ?></h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel4 ?>"><?php echo $nmkasi ?><br/><?php echo $tgllevel4 ?> Jam <?php echo $jamlevel4 ?></p>
              <p class="fs--1 text-800 mb-0">Status <?php echo $sttslevel4 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak4 ?>"><?php echo $catatantolak4 ?></p>
            </div>

          </div>
        </div>
      </div>

      <div class="row g-3 timeline <?php echo $tandalevel5 ?> pb-card"  <?php echo $hidkabid ?>>
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-tie"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1"><?php echo $jabatankabid ?></h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel5 ?>"><?php echo $nmkabid ?><br/><?php echo $tgllevel5 ?> Jam <?php echo $jamlevel5 ?></p>
              <p class="fs--1 text-800 mb-0">Status <?php echo $sttslevel5 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak5 ?>"><?php echo $catatantolak5 ?></p>
            </div>

          </div>
        </div>
      </div>

      <div class="row g-3 timeline <?php echo $tandalevelakhir ?>" <?php echo $hidtte ?>>
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-signature"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0">
            <div class="col">
              <h6 class="text-800 mb-1">Tte Surat Rekomendasi Mutasi Siswa</h6>
              <p class="fs--1 text-800 mb-0" style="<?php echo $dislevel7 ?>"><?php echo $nmkabid ?><br/><?php echo $tgllevel7 ?> Jam <?php echo $jamlevel7 ?></p>
              <p class="fs--1 text-800 mb-0">Tanda Tangan Elektronik<br /><?php echo $sttslevel7 ?></p>
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