<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idtransaksi = trim($_POST['idtransaksi']);
$idsekolah = trim($_POST['idsekolah']);

$sqlx = ("SELECT * FROM trans_pengaduan_dapodik p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$waktucreate = $sm['waktu_create'];$waktucreate = date('d-m-Y', strtotime($waktucreate));

$nik = $sm['nik'];
$nama = strtoupper($sm['nama']);
$alamat = $sm['alamat'];
$noorder = strtoupper($sm['no_order']);
$nowa = $sm['no_wa'];

$bentukpendidikan = strtoupper($sm['bentuk_pendidikan']);
$npsn = $sm['npsn'];
$namasekolah = strtoupper($sm['nama_sekolah']);
$uraianmasalah = $sm['uraian_masalah'];

$statusakhir = strtoupper($sm['ket_status_akhir']);

mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Data Pengaduan Dapodik</h5>
        <p class="fs--1 mb-0 text-white">Data pengaduan klinik dapodik</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-2 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        📢 <strong>Pengaduan Dapodik</strong> <i>NIK, Nama Lengkap, Alamat, No. HP/WA, Bentuk Pendidikan, Uraian Masalah dan Upload File (*.pdf)</i><br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-body px-3 py-3 mb-0">

            <div class="form-floating mb-2 mt-2">
                <input type="text" class="form-control form-control-sm" id="txtnikdapoE" value="<?php echo $nik ?>" maxlength="16" placeholder="NIK" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled >
                <label for="txtnikdapoE">NIK</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnamalengkapdapoE" value="<?php echo $nama ?>" maxlength="50" placeholder="Nama Lengkap" autocomplete="off" disabled >
                <label for="txtnamalengkapdapoE">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtalamatdapoE" value="<?php echo $alamat ?>" maxlength="200" placeholder="Alamat" autocomplete="off" disabled >
                <label for="txtalamatdapoE">Alamat</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnowadapoE" value="<?php echo $nowa ?>" maxlength="20" placeholder="No. WA" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled >
                <label for="txtnowadapoE">No. HP WhatsApp (Aktif)</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" id="cbobentukpendidikandapoE" size="1" required="required"
                    data-options='{"removeItemButton":true,"placeholder":true}'  disabled >
                    <option value="">Bentuk Pendidikan</option>
                    <?php
                    if ($bentukpendidikan == "PAUD"){$pilihpaud = "selected";} else {$pilihpaud = "";}
                    if ($bentukpendidikan == "SD"){$pilihSD = "selected";} else {$pilihSD = "";}
                    if ($bentukpendidikan == "SMP"){$pilihSMP = "selected";} else {$pilihSMP = "";}
                    if ($bentukpendidikan == "PNF"){$pilihPNF = "selected";} else {$pilihPNF = "";}
                        
                    echo "<option value='PAUD' $pilihpaud >PAUD</option>";
                    echo "<option value='SD' $pilihSD >Sekolah Dasar</option>";
                    echo "<option value='SMP' $pilihSMP >Sekolah Menengah Pertama</option>";
                    echo "<option value='PNF' $pilihPNF >Pendidikan Non Formal</option>";
                    ?>
                </select>
                <label for="cbobentukpendidikandapoE">Bentuk Pendidikan</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnamalengkapdapoE" value="<?php echo $npsn ?>" maxlength="50" placeholder="Nama Lengkap" autocomplete="off" disabled >
                <label for="txtnamalengkapdapoE">NPSN</label>
            </div>

            <div class="form-floating mb-0">
                <input type="text" class="form-control form-control-sm" id="txtalamatdapoE" value="<?php echo $namasekolah ?>" maxlength="200" placeholder="Alamat" autocomplete="off" disabled >
                <label for="txtalamatdapoE">Nama Sekolah</label>
            </div>

        </div>
    </div>

    <div class="row mb-2">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body align-items-center">
                    <div class="mb-0 mt-0">
                        <label for="txtmasalahdapoE">Uraian Masalah</label>
                        <textarea class="form-control form-control-sm fs--1" id="txtmasalahdapoE" placeholder="Uraian Masalah" style="height: 80px"  disabled ><?php echo $uraianmasalah ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
</div>
