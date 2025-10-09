<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsiswa = trim($_POST['idsiswa']);
$idsurveyor = trim($_POST['idsurveyor']);

$qri = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats
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

mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Data Survei ATS</h5>
        <p class="fs--1 mb-0 text-white">Silahkan input data survei ATS</p>
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

    <input class="form-control" type="text" id="txtidsiswasurveiAts" value="<?php echo $idsiswa; ?>" style="display:none;" />
    <input class="form-control" type="text" id="txtidsurveyorsurveiAts" value="<?php echo $idsurveyor; ?>" style="display:none;" />

    <div class="card bg-light mb-2">
        <div class="card-body align-items-center p-0 mb-0">
            <div class="form-check mt-2 ms-3">
                <input class="form-check-input" id="opt1" value="pilihan1" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt1">Lulus Melanjutkan</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt2" value="pilihan2" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt2">Mutasi / Pindah Sekolah</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt3" value="pilihan3" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt3">Melanjutkan Ke Luar Negeri</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt4" value="pilihan4" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt4">Melanjutkan Ke Pondok Pesantren</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt5" value="pilihan5" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt5">Lulus Tidak Melanjutkan</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt6" value="pilihan6" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt6">Dikeluarkan</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt7" value="pilihan7" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt7">Mengundurkan Diri</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt8" value="pilihan8" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt8">Putus Sekolah</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt9" value="pilihan9" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt9">Hilang</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt10" value="pilihan10" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt10">Meninggal Dunia</label>
            </div>

            <div class="form-check ms-3">
                <input class="form-check-input" id="opt11" value="pilihan11" type="radio" name="optdefault" />
                <label class="form-check-label" for="opt11">Aktif Kembali</label>
            </div>

        </div>
    </div>

    <div class="form-floating mb-0">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbocatatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih catatan</option>
            <?php
            $sqlcatt = ("SELECT id_catatan,catatan FROM ats_catatan_survei ORDER BY id_catatan ASC");
            $resultcatt = mysqli_query($dbconn, $sqlcatt);
            while ($ct = mysqli_fetch_array($resultcatt)) {
                $idcatatan = $ct['id_catatan'];
                $catatan = ucwords(strtolower($ct['catatan']));
                echo "
                        <option value='$idcatatan'>$catatan</option>";
            }
            mysqli_free_result($resultcatt);
            ?>
        </select>
        <label for="cbocatatan">Catatan</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanSurvei">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cmdSimpanSurvei").click(function() {

        var selectedOption = $("input:radio[name=optdefault]:checked").val()
        if (selectedOption == null) {
            alert("Anda belum memilih opsi survei")
        } else {
            var pilihan = selectedOption;
            var idsiswa = $('#txtidsiswasurveiAts').val();
            var idsurveyor = $('#txtidsurveyorsurveiAts').val();
            var idcatatan = $('#cbocatatan').val();
            var catatan = $('#cbocatatan :selected').text();

            var data = new FormData();
            data.append('idsiswa', idsiswa);
            data.append('idsurveyor', idsurveyor);
            data.append('idcatatan', idcatatan);
            data.append('catatan', catatan);
            data.append('pilihan', pilihan);

            if (idsurveyor.length <= 0) {
                alert('Data surveyor tidak terdeteksi')
            } else if (idsiswa.length <= 0) {
                alert('Data siswa tidak terdeteksi')
            } else if (idcatatan.length <= 0) {
                $('#txtcatatan').focus();
                alert('Catatan hasil survei masih kosong')
            } else if (pilihan.length <= 0) {
                alert('Anda belum memilih opsi survei')
            } else {
                $.ajax({
                    type: "POST",
                    url: 'aksi/hasil-survei/aksi_tambah_survei.php',
                    data: data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function(e) {
                        $("#cmdSimpanSurvei").attr("disabled", "disabled");
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
                            $("#cmdSimpanSurvei").removeAttr("disabled");
                        } else {
                            alert('Ada sedikit masalah, silakan coba lagi.');
                            $("#cmdSimpanSurvei").removeAttr("disabled");
                        }
                    },
                    error: function() {
                        alert('Koneksi bermasalah periksa internet');
                        $("#cmdSimpanSurvei").removeAttr("disabled");
                        $(".modal-body").css("opacity", "");
                    },
                });
            };
        }
    });
</script>