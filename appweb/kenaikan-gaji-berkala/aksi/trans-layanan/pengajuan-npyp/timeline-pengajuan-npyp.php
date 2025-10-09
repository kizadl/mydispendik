<?php
error_reporting(0);
require_once '../../../../services/config.php';
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

$sqlx = ("SELECT * FROM tte_trans_pengajuan_npyp p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$tglkirimoptsekolah = tgl_indo($sm['waktu_opt_sekolah']);

$noorder = $sm['no_order'];
$nmyayasan = ucwords(strtolower($sm['nm_yayasan']));
$nmpimpinan = $sm['nm_pimpinan'];
$propinsi = ucwords(strtolower($sm['propinsi']));
$kabupaten = ucwords(strtolower($sm['kota']));
$kecamatan = ucwords(strtolower($sm['kecamatan']));
$desa = ucwords(strtolower($sm['desa']));

$dusun = ucwords(strtolower($sm['dusun']));
$alamat = $sm['alamat'];
$rt = $sm['rt'];
$rw = $sm['rw'];
$kodepos = $sm['kode_pos'];
$telepon = $sm['no_telepon'];
$fax = $sm['no_fax'];
$email = $sm['email'];
$website = $sm['website'];

$nopendirian = strtoupper($sm['no_pendirian']);
$tglpendirian = tgl_indo($sm['tgl_pendirian']);
$nopengesahanpn = $sm['no_pengesahan_pn'];

$noskmenkumham = strtoupper($sm['no_sk_menkumham']);
$tglskmenkumham = tgl_indo($sm['tgl_sk_menkumham']);

$lokasi = $sm['lokasi'];
$nowa = $sm['no_wa'];

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
mysqli_free_result($restps);mysqli_free_result($resulttolak);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Timeline Status Pengajuan</h5>
    <p class="fs--1 mb-0 text-white">Timeline Status Pengajuan NPYP</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light py-3 px-4">

  <div class="row mb-0 mt-2 g-3">
    <div class="col-md-12 bg-light">
      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-city"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-1"><?php echo $nmyayasan ?></h6>
 
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td width="140px" class="align-top">Pimpinan Yayasan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $nmpimpinan ?></td>
                </tr>
                <tr>
                  <td>No. Telepon</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $telepon ?></td>
                </tr>
                <tr>
                  <td>Faximile</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $fax ?></td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $email ?></td>
                </tr>
                <tr>
                  <td>Website</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $website ?></td>
                </tr>
                <tr>
                  <td>No. WA Aktif</td>
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
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-map-marker-alt"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td width="140px" class="align-top">Alamat</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $alamat ?></td>
                </tr>
                <tr>
                  <td>RT / RW</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $rt ?> / <?php echo $rw ?></td>
                </tr>
                <tr>
                  <td>Dusun</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $dusun ?></td>
                </tr>
                <tr>
                  <td>Desa / Kelurahan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $desa ?></td>
                </tr>
                <tr>
                  <td>Kecamatan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $kecamatan ?></td>
                </tr>
                <tr>
                  <td>Kota / Kabupaten</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $kabupaten ?></td>
                </tr>
                <tr>
                  <td>Provinsi</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $propinsi ?></td>
                </tr>
                <tr>
                  <td>Kode Pos</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $kodepos ?></td>
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
              <h6 class="text-800 mb-1">Data Pendirian Dan Pengesahan</h6>
              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px" class="align-top">No. Pendirian Yayasan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $nopendirian ?></strong></td>
                </tr>
                <tr>
                  <td class="align-top">Tanggal Pendirian</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $tglpendirian ?></td>
                </tr>
              </table>
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td width="140px" class="align-top">No. Pengesahan PN</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $nopengesahanpn ?></strong></td>
                </tr>
                <tr>
                  <td class="align-top">Pengesahan Badan Hukum Menkumham</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><strong><?php echo $noskmenkumham ?></strong></td>
                </tr>
                <tr>
                  <td class="align-top">Tanggal Pengesahan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $tglskmenkumham ?></td>
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