<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idlayanan = trim($_POST['idlayanan']);
$qrilay = ("SELECT layanan FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
mysqli_free_result($dblayanan);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Input Data <?php echo $layanan ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi data <?php echo $layanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong><?php echo $layanan ?></strong>
                        (Data Siswa, Data Alamat dan Data Sekolah).
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Siswa</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsiswaMI" value="" maxlength="100" placeholder="Nama siswa" autocomplete="off">
                    <label for="txtnmsiswaMI">Nama Siswa</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtniksiswaMI" value="" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtniksiswaMI">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txttmplahirMI" value="" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
                    <label for="txttmplahirMI">Tempat Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control form-control-sm datetimepicker" id="txttgllahirMI" value="" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttgllahirMI">Tanggal Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojkMI" id="cbojkMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Jenis kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <label for="cbojkMI">Jenis Kelamin</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboagamaMI" id="cboagamaMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Agama</option>
                        <option value="ISLAM">Islam</option>
                        <option value="KRISTEN">Kristen</option>
                        <option value="KATHOLIK">Katholik</option>
                        <option value="HINDU">Hindu</option>
                        <option value="BUDHA">Budha</option>
                        <option value="KHONGHUCU">Khonghucu</option>
                        <option value="KEPERCAYAAN">Kepercayaan</option>
                    </select>
                    <label for="cboagamaMI">Pilih Agama</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboWargaNegaraPDBMI" id="cboWargaNegaraPDBMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Warganegara</option>
                        <option value="wni">WNI</option>
                        <option value="wna">WNA</option>
                    </select>
                    <label for="cboWargaNegaraPDBMI">Kewarganegaraan</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmortuMI" value="" maxlength="100" placeholder="Nama ibu kandung" autocomplete="off">
                    <label for="txtnmortuMI">Nama Ibu Kandung</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaMI" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaMI">No. HP WhatsApp (WA) Aktif</label>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Pengisian data <strong>
                            (Provinsi, Kabupaten/Kota, Kecamatan dan Kelurahan/Desa)</strong>,
                        </br>Jika tidak ada dalam list, maka <strong>Isi / Tulis Di Isian (Sampingnya)</strong>
                        </br><strong>Catatan :</strong> Utamakan menggunakan data yang ada di dalam <strong>List</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body p-0">
            <div class="row g-2 justify-content-between mt-0 px-card pb-3">
                <div class="form-floating mb-1 mt-3">
                    <input type="text" class="form-control form-control-sm" id="txtalamatsiswaMI" value="" maxlength="200" placeholder="Alamat" autocomplete="off">
                    <label for="txtalamatsiswaMI">Alamat</label>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboprovinsiMI" id="cboprovinsiMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Provinsi</option>
                            <?php
                            $sqlprop = ("SELECT kd_propinsi,nm_propinsi FROM tte_m_propinsi ORDER BY nm_propinsi ASC");
                            $resultprop = mysqli_query($dbconn, $sqlprop);
                            while ($p = mysqli_fetch_array($resultprop)) {
                                $idprovinsi = $p['kd_propinsi'];
                                $nmprovinsi = ucwords(strtolower($p['nm_propinsi']));
                                echo "
                                        <option value='$idprovinsi'>$nmprovinsi</option>";
                            }
                            mysqli_free_result($resultprop);
                            mysqli_close($dbconn);
                            ?>
                        </select>
                        <label for="cboprovinsiMI">Pilih Provinsi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtprovinsiMI" value="" maxlength="50" placeholder="Provimsi" autocomplete="off">
                        <label for="txtprovinsiMI">Provinsi</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokabupatenMI" id="cbokabupatenMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kabupaten</option>
                        </select>
                        <label for="cbokabupatenMI">Pilih Kabupaten</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkabupatenMI" value="" maxlength="50" placeholder="Kabupaten/kota" autocomplete="off">
                        <label for="txtkabupatenMI">Kabupaten</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokecamatanMI" id="cbokecamatanMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <label for="cbokecamatanMI">Pilih Kecamatan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkecamatanMI" value="" maxlength="50" placeholder="Kecamatan" autocomplete="off">
                        <label for="txtkecamatanMI">Kecamatan</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbodesaMI" id="cbodesaMI" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Desa / Kelurahan</option>
                        </select>
                        <label for="cbodesaMI">Pilih Desa / Kelurahan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtdesaMI" value="" maxlength="50" placeholder="Kelurahan/desa" autocomplete="off">
                        <label for="txtdesaMI">Desa / Kelurahan</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtsekolahasalMI" value="" maxlength="200" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahasalMI">Nama Sekolah</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsnasalMI" value="" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsnasalMI">NPSN</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnissiswaMI" value="" maxlength="25" placeholder="NISN" autocomplete="off">
                <label for="txtnissiswaMI">NISN</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtrombelMI" value="" maxlength="25" placeholder="rombel" autocomplete="off">
                <label for="txtrombelMI">Rombel</label>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPDBMI">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#cboprovinsiMI").val("");
        $("#txtprovinsiMI").val("");
        $("#cbokabupatenMI").val("");
        $("#txtkabupatenMI").val("");
        $("#cbokecamatanMI").val("");
        $("#txtkecamatanMI").val("");
        $("#cbodesaMI").val("");
        $("#txtdesaMI").val("");
    });

    $("#cboprovinsiMI").on("change", function() {
        $("#txtprovinsiMI").val("");
        $("#cbokabupatenMI").val("");
        $("#txtkabupatenMI").val("");
        $("#cbokecamatanMI").val("");
        $("#txtkecamatanMI").val("");
        $("#cbodesaMI").val("");
        $("#txtdesaMI").val("");
        var kdpropinsi = $("#cboprovinsiMI").val();
        var nmprovinsi = $("#cboprovinsiMI :selected").text();
        $("#txtprovinsiMI").val(nmprovinsi);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_kota.php",
            data: {kdpropinsi: kdpropinsi},
            success: function(resp) {
                $("#cbokabupatenMI").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokabupatenMI").on("change", function() {
        $("#txtkabupatenMI").val("");
        $("#cbokecamatanMI").val("");
        $("#txtkecamatanMI").val("");
        $("#cbodesaMI").val("");
        $("#txtdesaMI").val("");
        var kdkota = $("#cbokabupatenMI").val();
        var nmkota = $("#cbokabupatenMI :selected").text();
        $("#txtkabupatenMI").val(nmkota);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_kecamatan.php",
            data: {kdkota: kdkota},
            success: function(resp) {
                $("#cbokecamatanMI").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokecamatanMI").on("change", function() {
        $("#txtkecamatanMI").val("");
        $("#cbodesaMI").val("");
        $("#txtdesaMI").val("");
        var kdkecamatan = $("#cbokecamatanMI").val();
        var nmkecamatan = $("#cbokecamatanMI :selected").text();
        $("#txtkecamatanMI").val(nmkecamatan);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_desa.php",
            data: {kdkecamatan: kdkecamatan},
            success: function(resp) {
                $("#cbodesaMI").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbodesaMI").on("change", function() {
        $("#txtdesaMI").val("");
        var nmdesa = $("#cbodesaMI :selected").text();
        $("#txtdesaMI").val(nmdesa);
    });

    $("#cmdsimpanPDBMI").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var idlayanan = "2";

        var nmsiswa = $("#txtnmsiswaMI").val();
        var nik = $("#txtniksiswaMI").val();
        var tmplahir = $("#txttmplahirMI").val();
        var tgllahir = $("#txttgllahirMI").val();
        var kelamin = $("#cbojkMI").val();
        var agama = $("#cboagamaMI").val()
        var wn = $("#cboWargaNegaraPDBMI").val()
        var nmibukandung = $("#txtnmortuMI").val();
        var noWA = $("#txtnowaMI").val();

        var alamat = $("#txtalamatsiswaMI").val();
        var propinsi = $("#txtprovinsiMI").val();
        var kota = $("#txtkabupatenMI").val();
        var kecamatan = $("#txtkecamatanMI").val();
        var desa = $("#txtdesaMI").val();
        var idpropinsi = $("#cboprovinsiMI").val();
        var idkota = $("#cbokabupatenMI").val();
        var idkecamatan = $("#cbokecamatanMI").val();
        var iddesa = $("#cbodesaMI").val();
        
        var nmsekolah = $("#txtsekolahasalMI").val();
        var npsn = $("#txtnpsnasalMI").val();
        var nisn = $("#txtnissiswaMI").val();
        var rombel = $("#txtrombelMI").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

        data.append('nmsiswa', nmsiswa);
        data.append('nik', nik);
        data.append('tmplahir', tmplahir);
        data.append('tgllahir', tgllahir);
        data.append('kelamin', kelamin);
        data.append('agama', agama);
        data.append('wn', wn);
        data.append('nmibukandung', nmibukandung);
        data.append('noWA', noWA);

        data.append('alamat', alamat);
        data.append('propinsi', propinsi);
        data.append('kota', kota);
        data.append('kecamatan', kecamatan);
        data.append('desa', desa);
        data.append('idpropinsi', idpropinsi);
        data.append('idkota', idkota);
        data.append('idkecamatan', idkecamatan);
        data.append('iddesa', iddesa);

        data.append('nmsekolah', nmsekolah);
        data.append('npsn', npsn);
        data.append('nisn', nisn);
        data.append('rombel', rombel);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmsiswa.length <= 0) {
            $("#txtnmsiswaMI").focus();
            alert("Nama siswa masih kosong")
        } else if (nik.length <= 0) {
            $("#txtniksiswaMI").focus();
            alert("NIK siswa masih kosong")
        } else if (tmplahir.length <= 0) {
            $("#txttmplahirMI").focus();
            alert("Tempat lahir masih kosong")
        } else if (tgllahir.length <= 0) {
            $("#txttgllahirMI").focus();
            alert("Tanggal lahir masih kosong")
        } else if (kelamin.length <= 0) {
            $("#cbojkMI").focus();
            alert("Jenis kelamin masih kosong")
        } else if (agama.length <= 0) {
            $("#cboagamaMI").focus();
            alert("Agama masih kosong")
        } else if (wn.length <= 0) {
            $("#cboWargaNegaraPDBMI").focus();
            alert("Warga negara masih kosong")
        } else if (nmibukandung.length <= 0) {
            $("#txtnmortuMI").focus();
            alert("Nama ibu kandung masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaMI").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")
        } else if (alamat.length <= 0) {
            $("#txtalamatsiswaMI").focus();
            alert("Alamat masih kosong")
        } else if (propinsi.length <= 0) {
            $("#cboprovinsiMI").focus();
            alert("Provinsi masih kosong")
        } else if (kota.length <= 0) {
            $("#cbokabupatenMI").focus();
            alert("Kota/kabupaten masih kosong")
        } else if (kecamatan.length <= 0) {
            $("#cbokecamatanMI").focus();
            alert("Kecamatan masih kosong")
        } else if (desa.length <= 0) {
            $("#cbodesaMI").focus();
            alert("Kelurahan/desa masih kosong")
 
        } else if (nmsekolah.length <= 0) {
            $("#txtsekolahasalMI").focus();
            alert("Nama sekolah masih kosong")
        } else if (npsn.length <= 0) {
            $("#txtnpsnasalMI").focus();
            alert("NPSN sekolah masih kosong")
        } else if (nisn.length <= 0) {
            $("#txtnissiswaMI").focus();
            alert("NISN masih kosong")
        } else if (rombel.length <= 0) {
            $("#txtrombelMI").focus();
            alert("Rombel masih kosong")
        } else {
            var urlnya = "klinik-dapo/trans-layanan/pdb-mi/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanPDBMI").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiPDBMI();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanPDBMI").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanPDBMI").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanPDBMI").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>