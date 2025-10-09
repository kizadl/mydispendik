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
$idsiswa = trim($_POST['idsiswa']);
$idsurveyor = trim($_POST['idsurveyor']);

$sqlx = ("SELECT p.nm_surveyor,q.nm_universitas,r.nm_fakultas
		 FROM ats_surveyor_2025 p LEFT JOIN ats_universitas_2025 q ON p.id_universitas=q.id_universitas
		 LEFT JOIN ats_fakultas_2025 r ON p.id_fakultas=r.id_fakultas
     WHERE p.id_surveyor='" . $idsurveyor . "'
		 ORDER BY q.nm_universitas,r.nm_fakultas DESC");
$dbsurveyor = mysqli_query($dbconn, $sqlx);
$s = mysqli_fetch_assoc($dbsurveyor);
$nmsurveyor = ucwords(strtolower($s['nm_surveyor']));
$nmuniversitas = ucwords(strtolower($s['nm_universitas']));
$nmfakultas = ucwords(strtolower($s['nm_fakultas']));

$qri = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.desk
		 FROM tbl_ats_2025 p WHERE p.id_siswa='" . $idsiswa . "'");
$dbquery = mysqli_query($dbconn, $qri);
$t = mysqli_fetch_assoc($dbquery);

$namasiswa = ucwords(strtolower($t['nama_siswa']));
$kelamin = $t['jenis_kelamin'];
if ($kelamin == "L") {
  $jeniskelamin = "Laki-laki";
} else if ($kelamin == "P") {
  $jeniskelamin = "Perempuan";
}
$tmplahir = ucwords(strtolower($t['tmp_lahir']));
$tgllahir = tgl_indo(date("Y-m-d", strtotime($t['tgl_lahir'])));
$umur = $t['umur'];

$alamat = ucwords(strtolower($t['alamat']));
$rt = $t['rt'];
$rw = $t['rw'];
$desa = ucwords(strtolower($t['desa']));
$kecamatan = ucwords(strtolower($t['kecamatan']));
$kdkecamatan = $t['kd_kecamatan'];

$namasekolah = strtoupper($t['nama_sekolah']);
$bentukpendidikan = $t['bentuk_pendidikan'];
$tingkatpendidikan = $t['tingkat_pendidikan'];
$tahun = $t['tahun'];
$semester = $t['semester'];
$statusats = $t['status_ats'];

$qridet = ("SELECT * FROM ats_detail_survei_2025 WHERE id_siswa='" . $idsiswa . "'");
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
    WHERE p.id_siswa='" . $idsiswa . "'");
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
    $hidarealanjut = "";
    $namasekolahdetail = $s['nama'];
    $npsn = $s['npsn'];
  } else if ($lanjutsekolah == "N") {
    $hidarealanjut = "display:none";
    $namasekolahdetail = "";
    $npsn = "";
  }
} else if ($desk == "N") {
  $tgldesk = "";
  $berhentisekolah = "";
  $berhenticovid = "";
  $alasan = "";
  $idkegiatansiswa = "";
  $kegiatansiswa = "";
  $idketerampilansiswa = "";
  $keterampilan = "";
  $lanjutsekolah = "";
  $notelepon = "";
  $namauserdesk = "";
  $idsekolah = "";
  $namasekolahdetail = "";
  $npsn = "";
  $hidarealanjut = "display:none";
}

mysqli_free_result($dbquery);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">Timeline Hasil Survei Siswa</h5>
    <p class="fs--1 mb-0 text-white">Timeline Status Hasil Survei Siswa</p>
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
              <h6 class="text-800 mb-2"><?php echo $namasiswa ?></h6>

              <table class="fs--1 text-800 mb-2">
                <tr>
                  <td width="140px">Kelahiran</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $tmplahir ?>, <?php echo $tgllahir ?></td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $jeniskelamin ?></td>
                </tr>
                <tr>
                  <td>Umur</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $umur ?></td>
                </tr>
                <tr>
                  <td width="140px">Alamat</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $alamat ?> RT <?php echo $rt ?> RW <?php echo $rw ?></td>
                </tr>
                <tr>
                  <td>Desa - Kelurahan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $desa ?></td>
                </tr>
                <tr>
                  <td>Kecamatan</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $kecamatan ?></td>
                </tr>
              </table>

            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-random"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0 border-bottom pb-card">
            <div class="col">
              <h6 class="text-800 mb-2">Data ATS</h6>
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td width="140px" class="align-top">Sekolah</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $namasekolah ?></td>
                </tr>
                <tr>
                  <td>Status ATS</td>
                  <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td><?php echo $statusats ?> <?php echo $bentukpendidikan ?> Tingkat <?php echo $tingkatpendidikan ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-3 timeline  timeline-primary timeline-past pb-card">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-chalkboard-teacher"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0">
            <div class="col">
              <h6 class="text-800 mb-2">Hasil Survei</h6>
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td class="align-top" width="140px" class="align-top">Tanggal Survei</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $tglsurvei ?></td>
                </tr>
                <tr>
                  <td class="align-top">Surveyor</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $nmsurveyor ?> - <?php echo $nmuniversitas ?> - <?php echo $nmfakultas ?></td>
                </tr>
              </table>
            </div>

          </div>
        </div>
      </div>

      <div class="row g-3 timeline  timeline-primary timeline-past pb-card" style="<?php echo $hidarealanjut ?>">
        <div class="col-auto ps-4 ms-2">
          <div class="ps-2">
            <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-tie"></span></div>
          </div>
        </div>
        <div class="col">
          <div class="row gx-0">
            <div class="col">
              <h6 class="text-800 mb-2">Wawancara Assesment Desk</h6>
              <table class="fs--1 text-800 mb-0">
                <tr>
                  <td class="align-top" width="140px" class="align-top">Tanggal Wawancara</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $tgldesk ?></td>
                </tr>
                <tr>
                  <td class="align-top">Pewawancara</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $namauserdesk ?></td>
                </tr>
                <tr>
                  <td class="align-top">Berhenti Sekolah</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $berhentisekolah ?></td>
                </tr>
                <tr>
                  <td class="align-top">Berhenti Saat Covid</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $berhenticovid ?></td>
                </tr>
                <tr>
                  <td class="align-top">Alasan</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $alasan ?></td>
                </tr>
                <tr>
                  <td class="align-top">Kegiatan Siswa</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $kegiatansiswa ?></td>
                </tr>
                <tr>
                  <td class="align-top">Keterampilan Siswa</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $keterampilan ?></td>
                </tr>
                <tr>
                  <td class="align-top">Sekolah Kembali</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $namasekolahdetail ?> - <?php echo $npsn ?></td>
                </tr>
                <tr>
                  <td class="align-top">No. Telepon</td>
                  <td class="align-top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                  <td class="align-top"><?php echo $notelepon ?></td>
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