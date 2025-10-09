<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsiswa = trim($_POST['idsiswa']);
$idsurveyor = trim($_POST['idsurveyor']);

$qri = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats,p.desk
		 FROM tbl_ats p WHERE p.id_siswa='" . $idsiswa . "'");
$dbquery = mysqli_query($dbconn, $qri);
$t = mysqli_fetch_assoc($dbquery);

$namasiswa = ucwords(strtolower($t['nama_siswa']));
$kelamin = $t['jenis_kelamin'];
$tmplahir = ucwords(strtolower($t['tmp_lahir']));
$tgllahir = date("d-m-Y", strtotime($t['tgl_lahir']));
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

$desk = $t['desk'];
if ($desk == "Y"){
    $qrids = ("SELECT p.berhenti_sekolah,p.berhenti_covid,p.alasan,p.id_kegiatan_siswa,p.id_keterampilan_siswa,p.lanjut_sekolah,p.id_sekolah,p.no_telepon,
        q.npsn,q.nama
		 FROM ats_detail_desk p LEFT JOIN tbl_api_dispendik q ON p.id_sekolah=q.id_sekolah
         WHERE p.id_siswa='" . $idsiswa . "'");
        $dbqueryds = mysqli_query($dbconn, $qrids);
        $d = mysqli_fetch_assoc($dbqueryds);
        $berhentisekolah = $d['berhenti_sekolah'];
        $berhenticovid = $d['berhenti_covid'];
        $alasan = $d['alasan'];
        $idkegiatansiswa = $d['id_kegiatan_siswa'];
        $idketerampilansiswa = $d['id_keterampilan_siswa'];
        $lanjutsekolah = $d['lanjut_sekolah'];
        $notelepon = $d['no_telepon'];

        if ($lanjutsekolah == "Y"){
            $hidarealanjut = "";
            $idsekolah = $d['id_sekolah'];
            $namasekolahdetail = $d['nama'];$npsn = $d['npsn'];
        } else if ($lanjutsekolah == "N"){
            $idsekolah ="";
            $hidarealanjut = "display:none";
            $namasekolahdetail = "";$npsn = "";
        }
} else if ($desk == "N"){
        $berhentisekolah = "";
        $berhenticovid = "";
        $alasan = "";
        $idkegiatansiswa = "";
        $lanjutsekolah = "";
        $notelepon = "";
        $idsekolah ="";
        $namasekolahdetail = "";$npsn = "";
        $hidarealanjut = "display:none";
}

mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Input Data Assesment ATS</h5>
        <p class="fs--1 mb-0 text-white">Silahkan input data assesment ATS</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $namasiswa; ?></strong><br>
                        <?php echo $alamat; ?> RT <?php echo $rt; ?> RW <?php echo $rw; ?> - <?php echo $desa; ?> - <?php echo $kecamatan; ?>
                        <br>Kelahiran : <?php echo $tmplahir; ?>, <?php echo $tgllahir; ?> (<?php echo $umur; ?> Tahun)
                        <br><br>
                        <strong><?php echo $namasekolah; ?></strong><br>
                        <?php echo $statusats; ?> Tahun <?php echo $tahun; ?> - Kelas <?php echo $tingkatpendidikan; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control" type="text" id="txtidsiswaDesk" value="<?php echo $idsiswa; ?>" style="display:none;" />
    <input class="form-control" type="text" id="txttransidsekolahdesk" value="<?php echo $idsekolah; ?>" style="display:none;" />

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboberhentisekolah" id="cboberhentisekolah" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Berhenti Sekolah ?</option>
            <?php
            if ($berhentisekolah == "Y") {
                $plhYBS = "selected";
            } else if ($berhentisekolah == "N") {
                $plhNBS = "selected";
            }
            echo "<option value='Y' $plhYBS >Ya</option>
                <option value='N' $plhNBS >Tidak</option>";
            ?>
        </select>
        <label for="cboberhentisekolah">Berhenti Sekolah</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboberhenticovid" id="cboberhenticovid" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Berhenti Pada Saat Covid ?</option>
            <?php
            if ($berhenticovid == "Y") {
                $plhYBC = "selected";
            } else if ($berhenticovid == "N") {
                $plhNBC = "selected";
            }
            echo "<option value='Y' $plhYBC >Ya</option>
                <option value='N' $plhNBC >Tidak</option>";
            ?>
        </select>
        <label for="cboberhenticovid">Berhenti Pada Saat Covid</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtalasan" value="<?php echo $alasan; ?>" placeholder="Alasan" maxlength="200" autocomplete="off">
        <label for="txtalasan">Alasan Berhenti Sekolah</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbokegiatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih kegiatan siswa</option>
            <?php
            $sqlds = ("SELECT id_kegiatan,kegiatan_siswa FROM ats_kegiatan_siswa ORDER BY id_kegiatan ASC");
            $resultds = mysqli_query($dbconn, $sqlds);
            while ($ds = mysqli_fetch_array($resultds)) {
                $idkegiatan = $ds['id_kegiatan'];
                $kegiatansiswa = ucwords(strtolower($ds['kegiatan_siswa']));
                if($idkegiatansiswa == $idkegiatan){$plhkegiatan = "selected";} else {$plhkegiatan = "";}
                echo "
                        <option value='$idkegiatan' $plhkegiatan >$kegiatansiswa</option>";
            }
            mysqli_free_result($resultds);
            ?>
        </select>
        <label for="cbokegiatan">Kegiatan Siswa Saat Ini</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbosekolahlagi" id="cbosekolahlagi" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Apakah Mau Sekolah Kembali ?</option>
            <?php
            if ($lanjutsekolah == "Y") {
                $plhSL = "selected";
            } else if ($lanjutsekolah == "N") {
                $plhSN = "selected";
            }
            echo "<option value='Y' $plhSL >Ya</option>
                <option value='N' $plhSN >Tidak</option>";
            ?>
        </select>
        <label for="cbosekolahlagi">Sekolah Kembali</label>
    </div>

    <div class="form-floating mb-2 area-sekolah-lagi" style="<?php echo $hidarealanjut; ?>">
        <input type="text" class="form-control form-control-sm" id="txtnamasekolahdesk" value="<?php echo $namasekolahdetail; ?>" placeholder="Nama Sekolah" maxlength="100" autocomplete="off" disabled>
        <label for="txtnamasekolahdesk">Nama Sekolah</label>
    </div>

    <div class="form-floating mb-3 area-sekolah-lagi" style="<?php echo $hidarealanjut; ?>">
        <input type="text" class="form-control form-control-sm" id="txtnpsndesk" value="<?php echo $npsn; ?>" placeholder="NPSN" maxlength="20" autocomplete="off" disabled>
        <label for="txtnpsndesk">NPSN</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboketrampilan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Keterampilan yang dimiliki</option>
            <?php
            $sqlkt = ("SELECT id_keterampilan,keterampilan FROM ats_keterampilan_siswa ORDER BY id_keterampilan ASC");
            $resultkt = mysqli_query($dbconn, $sqlkt);
            while ($kt = mysqli_fetch_array($resultkt)) {
                $idketerampilan = $kt['id_keterampilan'];
                $keterampilansiswa = ucwords(strtolower($kt['keterampilan']));
                if($idketerampilansiswa == $idketerampilan){$plhketerampilan = "selected";} else {$plhketerampilan = "";}
                echo "
                        <option value='$idketerampilan' $plhketerampilan >$keterampilansiswa</option>";
            }
            mysqli_free_result($resultkt);
            mysqli_close($dbconn);
            ?>
        </select>
        <label for="cboketrampilan">Keterampilan Yang Dimiliki</label>
    </div>

    <div class="form-floating mb-0">
        <input type="text" class="form-control form-control-sm" id="txtnotelepon" value="<?php echo $notelepon; ?>" placeholder="No. Telepon" maxlength="20" autocomplete="off">
        <label for="txtnotelepon">No. Telepon</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanDesk">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cbosekolahlagi").on("change", function() {
        $("#txttransidsekolahdesk").val("");
        $("#txtnamasekolahdesk").val("");
        $("#txtnpsndesk").val("");
        var opsisekolah = $("#cbosekolahlagi").val()
        if (opsisekolah == "Y") {
            $(".area-sekolah-lagi").css("display", "block")
            $.ajax({
                type: "POST",
                url: "aksi/hasil-survei/tambah_data_sekolah.php",
                data: {},
                success: function(resp) {
                    $("#isianModTambahDataLarge").html(resp);
                    $("#isianModTambahDataLarge").fadeIn(1000);
                    $("#modTambahDataLarge").modal('show');
                },
                error: function() {
                    console.log('Koneksi bermasalah periksa internet');
                },
            });
        } else {
            $(".area-sekolah-lagi").css("display", "none")
        }
    });

    $("#cmdSimpanDesk").click(function() {
        
        var idsiswa = $('#txtidsiswaDesk').val();
        var iduser = $('#lbleditor').val();
        var idsekolah = $('#txttransidsekolahdesk').val();

        var berhentisekolah = $('#cboberhentisekolah').val();
        var berhenticovid = $('#cboberhenticovid').val();
        var alasan = $('#txtalasan').val();
        var idkegiatan = $('#cbokegiatan').val();
        var idketerampilan = $('#cboketrampilan').val();
        var sekolahlagi = $('#cbosekolahlagi').val();
        var telepon = $('#txtnotelepon').val();

        var data = new FormData();
        data.append('idsiswa', idsiswa);
        data.append('iduser', iduser);
        data.append('idsekolah', idsekolah);

        data.append('berhentisekolah', berhentisekolah);
        data.append('berhenticovid', berhenticovid);
        data.append('alasan', alasan);
        data.append('idkegiatan', idkegiatan);
        data.append('idketerampilan', idketerampilan);
        data.append('sekolahlagi', sekolahlagi);
        data.append('telepon', telepon);

        if (iduser.length <= 0) {
            alert('Data user tidak terdeteksi')
        } else if (idsiswa.length <= 0) {
            alert('Data siswa tidak terdeteksi')
        } else if (berhentisekolah.length <= 0) {
            $('#cboberhentisekolah').focus();
            alert('Opsi berhenti sekolah masih kosong')
        } else if (berhenticovid.length <= 0) {
            $('#cboberhenticovid').focus();
            alert('Opsi berhenti sekolah ketika covid masih kosong')
        } else if (alasan.length <= 0) {
            $('#txtalasan').focus();
            alert('Alasan berhenti sekolah masih kosong')
        } else if (idkegiatan.length <= 0) {
            $('#cbokegiatan').focus();
            alert('Opsi kegiatan siswa masih kosong')
        } else if (sekolahlagi.length <= 0) {
            $('#cbosekolahlagi').focus();
            alert('Opsi bersekolah kembali masih kosong')

        } else if (sekolahlagi == "Y" && idsekolah.length <= 0) {
            alert('Anda belum menentukan pilihan sekolah')
        } else if (idketerampilan.length <= 0) {
            $('#cboketrampilan').focus();
            alert('Opsi keterampilan siswa masih kosong')
        } else if (telepon.length <= 0) {
            $('#txtnotelepon').focus();
            alert('Nomor telepon masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/hasil-survei/aksi_tambah_desk.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanDesk").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiHasilSurvei();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanDesk").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanDesk").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanDesk").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };

    });
</script>