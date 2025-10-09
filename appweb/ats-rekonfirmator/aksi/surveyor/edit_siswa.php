<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsiswa = trim($_POST['idsiswa']);
$idsurveyor = trim($_POST['idsurveyor']);

$qri = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,p.kd_desa,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats
		 FROM tbl_ats_2025 p WHERE p.id_siswa='" . $idsiswa . "'");
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
$kddesa = $t['kd_desa'];

$namasekolah = ucwords(strtolower($t['nama_sekolah']));
$bentukpendidikan = $t['bentuk_pendidikan'];
$tingkatpendidikan = $t['tingkat_pendidikan'];
$tahun = $t['tahun'];
$semester = $t['semester'];
$statusats = $t['status_ats'];

mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Siswa ATS</h5>
        <p class="fs--1 mb-0 text-white">Silahkan merubah data siswa ATS</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Survei ATS</strong> dibawah ini.<br />
                        Isi data <strong>Siswa</strong> dibawah ini dengan benar.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control" type="text" id="txtidsiswaE" value="<?php echo $idsiswa; ?>" style="display:none;" />

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtnamasiswa" value="<?php echo $namasiswa; ?>" placeholder="Nama Siswa" maxlength="100" autocomplete="off">
        <label for="txtnamasiswa">Nama Siswa</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojk" id="cbojk" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Jenis kelamin</option>
            <?php
            if ($kelamin == "L") {
                $plhL = "selected";
            } else if ($kelamin == "P") {
                $plhP = "selected";
            }
            echo "<option value='L' $plhL >Laki-laki</option>
                        <option value='P' $plhP >Perempuan</option>";
            ?>
        </select>
        <label for="cbojk">Jenis Kelamin</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txttmplahir" value="<?php echo $tmplahir ?>" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
        <label for="txttmplahir">Tempat Lahir</label>
    </div>

    <div class="form-floating mb-2">
        <input class="form-control form-control-sm datetimepicker" id="txttgllahir" value="<?php echo $tgllahir ?>" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttgllahir">Tanggal Lahir</label>
    </div>

    <div class="form-floating mb-2">
        <input type="number" class="form-control form-control-sm" id="txtumur" value="<?php echo $umur ?>" maxlength="3" placeholder="Umur" autocomplete="off">
        <label for="txtumur">Umur</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtalamat" value="<?php echo $alamat; ?>" placeholder="Alamat" maxlength="200" autocomplete="off">
        <label for="txtalamat">Alamat</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtrt" value="<?php echo $rt; ?>" placeholder="RT" maxlength="15" autocomplete="off">
        <label for="txtrt">RT</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtrw" value="<?php echo $rw; ?>" placeholder="RW" maxlength="15" autocomplete="off">
        <label for="txtrw">RW</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control form-control-sm" id="txtdesa" value="<?php echo $desa; ?>" placeholder="Desa" maxlength="50" autocomplete="off">
        <label for="txtdesa">Desa / Kelurahan</label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbokecamatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih kecamatan</option>
            <?php
            $sqlkc = ("SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan ASC");
            $resultkc = mysqli_query($dbconn, $sqlkc);
            while ($kc = mysqli_fetch_array($resultkc)) {
                $kdkecamatane = $kc['kd_kecamatan'];
                $namakecamatane = ucwords(strtolower($kc['nama_kecamatan']));
                if ($kdkecamatane == $kdkecamatan) {
                    $plhkec = "selected";
                } else {
                    $plhkec = "";
                }
                echo "
                        <option value='$kdkecamatane' $plhkec >$namakecamatane</option>";
            }
            mysqli_free_result($resultkc);
            ?>
        </select>
        <label for="cbokecamatan">Kecamatan</label>
    </div>

    <div class="form-floating mb-0">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbodesa" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih desa</option>
            <?php
            $sqlds = ("SELECT kd_desa,nama_desa FROM m_desa WHERE kd_kecamatan='" . $kdkecamatan . "' ORDER BY nama_desa ASC");
            $resultds = mysqli_query($dbconn, $sqlds);
            while ($ds = mysqli_fetch_array($resultds)) {
                $kddesane = $ds['kd_desa'];
                $namadesane = ucwords(strtolower($ds['nama_desa']));
                if ($kddesane == $kddesa) {
                    $plhdesa = "selected";
                } else {
                    $plhdesa = "";
                }
                echo "
                        <option value='$kddesane' $plhdesa >$namadesane</option>";
            }
            mysqli_free_result($resultds);
            mysqli_close($dbconn);
            ?>
        </select>
        <label for="cbodesa">Desa</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanDataSiswa">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $("#cbokecamatan").on("change", function() {
        var idkecamatan = $("#cbokecamatan").val()
        $.ajax({
            type: "POST",
            url: "aksi/surveyor/ambil_data_desa.php",
            data: {
                idkecamatan: idkecamatan
            },
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";

                $("#cbodesa").empty()
                $("#cbodesa").append('<option value="">Pilih desa</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cbodesa").append('<option value="' + data[i].iddesa + '">' + data[i].nmdesa + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cmdSimpanDataSiswa").click(function() {

        var idsiswa = $('#txtidsiswaE').val();
        var idsurveyor = $('#lbleditor').val();
        var namasiswa = $('#txtnamasiswa').val();
        var kelamin = $("#cbojk").val();
        var tmplahir = $("#txttmplahir").val();
        var tgllahir = $('#txttgllahir').val();
        var umur = $('#txtumur').val();

        var alamat = $('#txtalamat').val();
        var rt = $('#txtrt').val();
        var rw = $('#txtrw').val();
        var desa = $('#txtdesa').val();
        var idkecamatan = $('#cbokecamatan').val();
        var namakecamatan = $('#cbokecamatan :selected').text();
        var iddesa = $('#cbodesa').val();

        var data = new FormData();
        data.append('idsiswa', idsiswa);
        data.append('idsurveyor', idsurveyor);
        data.append('namasiswa', namasiswa);
        data.append('kelamin', kelamin);
        data.append('tmplahir', tmplahir);
        data.append('tgllahir', tgllahir);
        data.append('umur', umur);

        data.append('alamat', alamat);
        data.append('rt', rt);
        data.append('rw', rw);
        data.append('desa', desa);
        data.append('idkecamatan', idkecamatan);
        data.append('namakecamatan', namakecamatan);
        data.append('iddesa', iddesa);

        if (idsurveyor.length <= 0) {
            alert('Data surveyor tidak terdeteksi')
        } else if (idsiswa.length <= 0) {
            alert('Data siswa tidak terdeteksi')
        } else if (namasiswa.length <= 0) {
            $('#txtnamasiswa').focus();
            alert('Nama siswa masih kosong')
        } else if (kelamin.length <= 0) {
            $('#cbojk').focus();
            alert('Kelamin masih kosong')
        } else if (tmplahir.length <= 0) {
            $('#txttmplahir').focus();
            alert('Tempat Lahir masih kosong')
        } else if (tgllahir.length <= 0) {
            $('#txttgllahir').focus();
            alert('Tanggal lahir masih kosong')
        } else if (umur.length <= 0) {
            $('#txtumur').focus();
            alert('Umur masih kosong')

        } else if (alamat.length <= 0) {
            $('#txtalamat').focus();
            alert('Alamat masih kosong')
        } else if (rt.length <= 0) {
            $('#txtrt').focus();
            alert('RT masih kosong')
        } else if (rw.length <= 0) {
            $('#txtrw').focus();
            alert('RW masih kosong')
        } else if (desa.length <= 0) {
            $('#txtdesa').focus();
            alert('Desa kelurahan masih kosong')
        } else if (idkecamatan.length <= 0) {
            $('#cbokecamatan').focus();
            alert('Kecamatan masih kosong')
        } else if (iddesa.length <= 0) {
            $('#cbodesa').focus();
            alert('Desa masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/surveyor/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanDataSiswa").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterSurveyor();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanDataSiswa").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanDataSiswa").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanDataSiswa").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>