<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$qrilay = ("SELECT layanan FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
mysqli_free_result($dblayanan);

$sqlx = ("SELECT * FROM tte_trans_verifikasi_pdb_mi p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$namasiswa = ucwords(strtolower($sm['nama_siswa']));
$nik = $sm['nik'];
$kelamin = $sm['kelamin'];
$tempatlahir = ucwords(strtolower($sm['tempat_lahir']));
$tgllahir = $sm['tgl_lahir'];$tgllahir = date('d-m-Y', strtotime($tgllahir));
$agama = $sm['agama'];
$wn = $sm['kewarganegaraan'];
$nmibukandung = ucwords(strtolower($sm['nm_ibu_kandung']));
$nowa = $sm['no_wa'];

$alamat = $sm['alamat'];
$propinsi = ucwords(strtolower($sm['propinsi']));
$kabupaten = ucwords(strtolower($sm['kabupaten']));
$kecamatan = ucwords(strtolower($sm['kecamatan']));
$desa = ucwords(strtolower($sm['desa']));

$idpropinsi = $sm['id_propinsi'];
$idkota = $sm['id_kota'];
$idkecamatan = $sm['id_kecamatan'];
$iddesa = $sm['id_desa'];

$nmsekolah = strtoupper($sm['nm_sekolah']);
$npsn = strtoupper($sm['npsn']);
$nisn = $sm['nisn'];
$rombel = strtoupper($sm['rombel']);

mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data <?php echo $layanan ?></h5>
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

                <input type="text" class="form-control form-control-sm" id="txtidtransaksiMIE" value="<?php echo $idtransaksi ?>" hidden >
                <input type="text" class="form-control form-control-sm" id="txtidlayananMIE" value="<?php echo $idlayanan ?>" hidden >
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsiswaMIE" value="<?php echo $namasiswa ?>" maxlength="100" placeholder="Nama siswa" autocomplete="off">
                    <label for="txtnmsiswaMIE">Nama Siswa</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtniksiswaMIE" value="<?php echo $nik ?>" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtniksiswaMIE">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txttmplahirMIE" value="<?php echo $tempatlahir ?>" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
                    <label for="txttmplahirMIE">Tempat Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control form-control-sm datetimepicker" id="txttgllahirMIE" value="<?php echo $tgllahir ?>" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttgllahirMIE">Tanggal Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojkMIE" id="cbojkMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                    <label for="cbojkMIE">Jenis Kelamin</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboagamaMIE" id="cboagamaMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Agama</option>
                        <?php
                        if ($agama == "ISLAM") {
                            $plhislam = "selected";
                        } else if ($agama == "KRISTEN") {
                            $plhkristen = "selected";
                        } else if ($agama == "KATHOLIK") {
                            $plhkatolik = "selected";
                        } else if ($agama == "HINDU") {
                            $plhhindu = "selected";
                        } else if ($agama == "BUDHA") {
                            $plhbudha = "selected";
                        } else if ($agama == "KHONGHUCU") {
                            $plhkonghucu = "selected";
                        } else if ($agama == "KEPERCAYAAN") {
                            $plhkepercayaan = "selected";
                        }
                        echo "<option value='ISLAM' $plhislam >Islam</option>
                        <option value='KRISTEN' $plhkristen >Kristen</option>
                        <option value='KATHOLIK' $plhkatolik >Katholik</option>
                        <option value='HINDU' $plhhindu >Hindu</option>
                        <option value='BUDHA' $plhbudha >Budha</option>
                        <option value='KHONGHUCU' $plhkonghucu >Khonghucu</option>
                        <option value='KEPERCAYAAN' $plhkepercayaan >Kepercayaan</option>";
                        ?>
                    </select>
                    <label for="cboagamaMIE">Pilih Agama</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboWargaNegaraPDBMIE" id="cboWargaNegaraPDBMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Warganegara</option>
                        <?php
                        if ($wn == "wni") {
                            $plhwni = "selected";
                        } else if ($wn == "wna") {
                            $plhwna = "selected";
                        }
                        echo "<option value='wni' $plhwni >WNI</option>
                        <option value='wna' $plhwna >WNA</option>";
                        ?>
                    </select>
                    <label for="cboWargaNegaraPDBMIE">Kewarganegaraan</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmortuMIE" value="<?php echo $nmibukandung ?>" maxlength="100" placeholder="Nama ibu kandung" autocomplete="off">
                    <label for="txtnmortuMIE">Nama Ibu Kandung</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaMIE" value="<?php echo $nowa ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaMIE">No. HP WhatsApp (WA) Aktif</label>
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
                    <input type="text" class="form-control form-control-sm" id="txtalamatsiswaMIE" value="<?php echo $alamat ?>" maxlength="200" placeholder="Alamat" autocomplete="off">
                    <label for="txtalamatsiswaMIE">Alamat</label>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboprovinsiMIE" id="cboprovinsiMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Provinsi</option>
                            <?php
                            $sqlprop = ("SELECT kd_propinsi,nm_propinsi FROM tte_m_propinsi ORDER BY nm_propinsi ASC");
                            $resultprop = mysqli_query($dbconn, $sqlprop);
                            while ($p = mysqli_fetch_array($resultprop)) {
                                $idprovinsix = $p['kd_propinsi'];
                                $nmprovinsix = ucwords(strtolower($p['nm_propinsi']));
                                if ($idpropinsi == $idprovinsix){$plhpropinsi = "selected";} else {$plhpropinsi = "";}
                                echo "
                                        <option value='$idprovinsix' $plhpropinsi >$nmprovinsix</option>";
                            }
                            mysqli_free_result($resultprop);
                            ?>
                        </select>
                        <label for="cboprovinsiMIE">Pilih Provinsi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtprovinsiMIE" value="<?php echo $propinsi ?>" maxlength="50" placeholder="Provinsi" autocomplete="off">
                        <label for="txtprovinsiMIE">Provinsi</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokabupatenMIE" id="cbokabupatenMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kabupaten</option>
                            <?php
                            $sqlkab = ("SELECT kd_kota,nama_kota FROM tte_m_kota WHERE kd_propinsi='".$idpropinsi."' ORDER BY nama_kota ASC");
                            $resultkab = mysqli_query($dbconn, $sqlkab);
                            while ($k = mysqli_fetch_array($resultkab)) {
                                $kdkota = $k['kd_kota'];
                                $nmkota = ucwords(strtolower($k['nama_kota']));
                                if ($idkota == $kdkota){$plhkab = "selected";} else {$plhkab = "";}
                                echo "
                                        <option value='$kdkota' $plhkab >$nmkota</option>";
                            }
                            mysqli_free_result($resultkab);
                            ?>
                        </select>
                        <label for="cbokabupatenMIE">Pilih Kabupaten</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkabupatenMIE" value="<?php echo $kabupaten ?>" maxlength="50" placeholder="Kabupaten/kota" autocomplete="off">
                        <label for="txtkabupatenMIE">Kabupaten</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokecamatanMIE" id="cbokecamatanMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kecamatan</option>
                            <?php
                            $sqlkec = ("SELECT kd_kecamatan,nama_kecamatan FROM tte_m_kecamatan WHERE kd_kota='".$idkota."' ORDER BY nama_kecamatan ASC");
                            $resultkec = mysqli_query($dbconn, $sqlkec);
                            while ($kc = mysqli_fetch_array($resultkec)) {
                                $kdkecamatan = $kc['kd_kecamatan'];
                                $namakecamatan = ucwords(strtolower($kc['nama_kecamatan']));
                                if ($idkecamatan == $kdkecamatan){$plhkec = "selected";} else {$plhkec = "";}
                                echo "
                                        <option value='$kdkecamatan' $plhkec >$namakecamatan</option>";
                            }
                            mysqli_free_result($resultkec);
                            ?>
                        </select>
                        <label for="cbokecamatanMIE">Pilih Kecamatan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkecamatanMIE" value="<?php echo $kecamatan ?>" maxlength="50" placeholder="Kecamatan" autocomplete="off">
                        <label for="txtkecamatanMIE">Kecamatan</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbodesaMIE" id="cbodesaMIE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Desa / Kelurahan</option>
                            <?php
                            $sqlds = ("SELECT kd_desa,nama_desa FROM tte_m_desa WHERE kd_kecamatan='".$idkecamatan."' ORDER BY nama_desa ASC");
                            $resultds = mysqli_query($dbconn, $sqlds);
                            while ($ds = mysqli_fetch_array($resultds)) {
                                $kddesa = $ds['kd_desa'];
                                $namadesa = ucwords(strtolower($ds['nama_desa']));
                                if ($iddesa == $kddesa){$plhds = "selected";} else {$plhds = "";}
                                echo "
                                        <option value='$kddesa' $plhds >$namadesa</option>";
                            }
                            mysqli_free_result($resultds);
                            mysqli_close($dbconn);
                            ?>
                        </select>
                        <label for="cbodesaMIE">Pilih Desa / Kelurahan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtdesaMIE" value="<?php echo $desa ?>" maxlength="50" placeholder="Kelurahan/desa" autocomplete="off">
                        <label for="txtdesaMIE">Desa / Kelurahan</label>
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
                <input type="text" class="form-control form-control-sm" id="txtsekolahasalMIE" value="<?php echo $nmsekolah ?>" maxlength="200" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahasalMIE">Nama Sekolah</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsnasalMIE" value="<?php echo $npsn ?>" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsnasalMIE">NPSN</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnissiswaMIE" value="<?php echo $nisn ?>" maxlength="25" placeholder="NISN" autocomplete="off">
                <label for="txtnissiswaMIE">NISN</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtrombelMIE" value="<?php echo $rombel ?>" maxlength="25" placeholder="Rombel" autocomplete="off">
                <label for="txtrombelMIE">Rombel</label>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPDBMIE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $("#cboprovinsiMIE").on("change", function() {
        $("#txtprovinsiMIE").val("");
        $("#cbokabupatenMIE").val("");
        $("#txtkabupatenMIE").val("");
        $("#cbokecamatanMIE").val("");
        $("#txtkecamatanMIE").val("");
        $("#cbodesaMIE").val("");
        $("#txtdesaMIE").val("");
        var kdpropinsi = $("#cboprovinsiMIE").val();
        var nmprovinsi = $("#cboprovinsiMIE :selected").text();
        $("#txtprovinsiMIE").val(nmprovinsi);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_kota.php",
            data: {kdpropinsi: kdpropinsi},
            success: function(resp) {
                $("#cbokabupatenMIE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokabupatenMIE").on("change", function() {
        $("#txtkabupatenMIE").val("");
        $("#cbokecamatanMIE").val("");
        $("#txtkecamatanMIE").val("");
        $("#cbodesaMIE").val("");
        $("#txtdesaMIE").val("");
        var kdkota = $("#cbokabupatenMIE").val();
        var nmkota = $("#cbokabupatenMIE :selected").text();
        $("#txtkabupatenMIE").val(nmkota);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_kecamatan.php",
            data: {kdkota: kdkota},
            success: function(resp) {
                $("#cbokecamatanMIE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokecamatanMIE").on("change", function() {
        $("#txtkecamatanMIE").val("");
        $("#cbodesaMIE").val("");
        $("#txtdesaMIE").val("");
        var kdkecamatan = $("#cbokecamatanMIE").val();
        var nmkecamatan = $("#cbokecamatanMIE :selected").text();
        $("#txtkecamatanMIE").val(nmkecamatan);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_desa.php",
            data: {kdkecamatan: kdkecamatan},
            success: function(resp) {
                $("#cbodesaMIE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbodesaMIE").on("change", function() {
        $("#txtdesaMIE").val("");
        var nmdesa = $("#cbodesaMIE :selected").text();
        $("#txtdesaMIE").val(nmdesa);
    });

    $("#cmdsimpanPDBMIE").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
        var idlayanan = $("#txtidlayananMIE").val();
        var idtransaksi = $("#txtidtransaksiMIE").val();

        var nmsiswa = $("#txtnmsiswaMIE").val();
        var nik = $("#txtniksiswaMIE").val();
        var tmplahir = $("#txttmplahirMIE").val();
        var tgllahir = $("#txttgllahirMIE").val();
        var kelamin = $("#cbojkMIE").val();
        var agama = $("#cboagamaMIE").val()
        var wn = $("#cboWargaNegaraPDBMIE").val()
        var nmibukandung = $("#txtnmortuMIE").val();
        var noWA = $("#txtnowaMIE").val();

        var alamat = $("#txtalamatsiswaMIE").val();
        var propinsi = $("#txtprovinsiMIE").val();
        var kota = $("#txtkabupatenMIE").val();
        var kecamatan = $("#txtkecamatanMIE").val();
        var desa = $("#txtdesaMIE").val();
        
        var idpropinsi = $("#cboprovinsiMIE").val();
        var idkota = $("#cbokabupatenMIE").val();
        var idkecamatan = $("#cbokecamatanMIE").val();
        var iddesa = $("#cbodesaMIE").val();

        var nmsekolah = $("#txtsekolahasalMIE").val();
        var npsn = $("#txtnpsnasalMIE").val();
        var nisn = $("#txtnissiswaMIE").val();
        var rombel = $("#txtrombelMIE").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);
        data.append('idtransaksi', idtransaksi);

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
            $("#txtnmsiswaMIE").focus();
            alert("Nama siswa masih kosong")
        } else if (nik.length <= 0) {
            $("#txtniksiswaMIE").focus();
            alert("NIK siswa masih kosong")
        } else if (tmplahir.length <= 0) {
            $("#txttmplahirMIE").focus();
            alert("Tempat lahir masih kosong")
        } else if (tgllahir.length <= 0) {
            $("#txttgllahirMIE").focus();
            alert("Tanggal lahir masih kosong")
        } else if (kelamin.length <= 0) {
            $("#cbojkMIE").focus();
            alert("Jenis kelamin masih kosong")
        } else if (agama.length <= 0) {
            $("#cboagamaMIE").focus();
            alert("Agama masih kosong")
        } else if (wn.length <= 0) {
            $("#cboWargaNegaraPDBMIE").focus();
            alert("Warga negara masih kosong")
        } else if (nmibukandung.length <= 0) {
            $("#txtnmortuMIE").focus();
            alert("Nama ibu kandung masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaMIE").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")
        } else if (alamat.length <= 0) {
            $("#txtalamatsiswaMIE").focus();
            alert("Alamat masih kosong")
        } else if (propinsi.length <= 0) {
            $("#cboprovinsiMIE").focus();
            alert("Provinsi masih kosong")
        } else if (kota.length <= 0) {
            $("#cbokabupatenMIE").focus();
            alert("Kota/kabupaten masih kosong")
        } else if (kecamatan.length <= 0) {
            $("#cbokecamatanMIE").focus();
            alert("Kecamatan masih kosong")
        } else if (desa.length <= 0) {
            $("#cbodesaMIE").focus();
            alert("Kelurahan/desa masih kosong")
 
        } else if (nmsekolah.length <= 0) {
            $("#txtsekolahasalMIE").focus();
            alert("Nama sekolah masih kosong")
        } else if (npsn.length <= 0) {
            $("#txtnpsnasalMIE").focus();
            alert("NPSN sekolah masih kosong")
        } else if (nisn.length <= 0) {
            $("#txtnissiswaMIE").focus();
            alert("NISN masih kosong")
        } else if (rombel.length <= 0) {
            $("#txtrombelMIE").focus();
            alert("Rombel masih kosong")
        } else {
            var urlnya = "aksi/trans-layanan/pdb-mi/aksi_edit.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanPDBMIE").attr("disabled", "disabled");
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
                        $("#cmdsimpanPDBMIE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanPDBMIE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanPDBMIE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>