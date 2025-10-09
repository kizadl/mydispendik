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

$idtransaksi = trim($_POST['idtransaksi']);
$mdidtransaksi = md5($idtransaksi);

$sqlx = ("SELECT * FROM trans_pengaduan_dapodik p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$tglkirimoptsekolah = tgl_indo($sm['waktu_create']);

$nik = $sm['nik'];
$nama = strtoupper($sm['nama']);
$alamat = $sm['alamat'];
$noorder = strtoupper($sm['no_order']);
$nowa = $sm['no_wa'];

$bentukpendidikan = strtoupper($sm['bentuk_pendidikan']);
$npsn = $sm['npsn'];
$namasekolah = strtoupper($sm['nama_sekolah']);
$uraianmasalah = nl2br($sm['uraian_masalah']);

if ($sm['ket_status_akhir'] == "belum") {
  $statusakhir = "Belum Ditindak Lanjuti";
  $hidstatus = "display:none !important";
} else if ($sm['ket_status_akhir'] == "terima") {
  $statusakhir = "Sudah Ditindak Lanjuti";
  $hidstatus = "";
} else if ($sm['ket_status_akhir'] == "tolak") {
  $statusakhir = "Ditolak";
  $hidstatus = "";
}

if ($sm['bentuk_pendidikan'] == "PAUD") {
  $namabentuk = "TK / PAUD";
} else if ($sm['bentuk_pendidikan'] == "SD") {
  $namabentuk = "Sekolah Dasar";
} else if ($sm['bentuk_pendidikan'] == "SMP") {
  $namabentuk = "Sekolah Menengah Pertama";
} else if ($sm['bentuk_pendidikan'] == "PNF") {
  $namabentuk = "Pendidikan Non Formal";
}

/////// DETAIL TOLAK ///////////
$sqltolak = ("SELECT catatan,ket_level,waktu,status_akhir
		FROM detail_pengaduan_dapodik WHERE id_transaksi='" . $idtransaksi . "'");
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
    $catatantolak2 = $catatantolak2 . tgl_indo($t['waktu']) . "<br>" . nl2br($t['catatan']) . "<br>";
    $hidtolak2 = "";
    $tgltolak2 = tgl_indo($t['waktu']);
    $jamtolak2 = date("H:i", strtotime($t['waktu']));
  }
}

if ($sm['ket_level'] == "operator sekolah") {
  $tandalevel1 = "timeline-success timeline-current";
  $tandalevel2 = "timeline-primary";
  $hidoptsekolah = "";
  $hidoptdapodik = "hidden";
} else if ($sm['ket_level'] == "operator dapodik") {
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-success timeline-current";
  $hidoptsekolah = "";
  $hidoptdapodik = "";
}
mysqli_free_result($restps);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Timeline Status Pengaduan</h5>
    <p class="fs--1 mb-0 text-white">Timeline Status Pengaduan Dapodik</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light py-3 px-4">

  <div class="row mb-0 mt-2 g-3">
    <div class="col-md-12 bg-light">
      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1"><?php echo $nama ?></h6>

              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td width="140px"><strong>NIK</strong></td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $nik ?></strong></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $alamat ?></td>
                </tr>
                <tr>
                  <td>No. HP WhatsApp</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $nowa ?></td>
                </tr>
              </table>

            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-headphones"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1">Pengaduan</h6>

              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px" class="align-top">No.Order</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $noorder ?></strong></td>
                </tr>
                <tr>
                  <td>Tanggal Pengaduan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $tglkirimoptsekolah ?></td>
                </tr>
                <tr>
                  <td>Bentuk Pendidikan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $namabentuk ?></strong></td>
                </tr>
                <tr>
                  <td>NPSN</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $npsn ?></strong></td>
                </tr>
                <tr>
                  <td>Sekolah</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $namasekolah ?></strong></td>
                </tr>
                <tr>
                  <td width="140px" class="align-top">Uraian Masalah</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $uraianmasalah ?></td>
                </tr>
              </table>

            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-chalkboard-teacher"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0">
            <div class="col">
              <h6 class="text-800 mb-1">Tindak Lanjut Admin Dapodik</h6>
              <table class="fs--1 text-800 mb-0">
                <tr style="<?php echo $hidstatus ?>">
                  <td class="align-top">Catatan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $catatantolak2 ?></td>
                </tr>
                <tr>
                  <td><strong>Status</strong></td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><strong><?php echo $statusakhir ?></strong></td>
                </tr>
              </table>
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