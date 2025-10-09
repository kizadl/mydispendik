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

$sqlx = ("SELECT * FROM tte_trans_pengajuan_npyp p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$nmyayasan = strtoupper($sm['nm_yayasan']);
$nmpimpinan = $sm['nm_pimpinan'];
$propinsi = ucwords(strtolower($sm['propinsi']));
$kabupaten = ucwords(strtolower($sm['kota']));
$kecamatan = ucwords(strtolower($sm['kecamatan']));
$desa = ucwords(strtolower($sm['desa']));

$idpropinsi = $sm['id_propinsi'];
$idkota = $sm['id_kota'];
$idkecamatan = $sm['id_kecamatan'];
$iddesa = $sm['id_desa'];

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
$tglpendirian = $sm['tgl_pendirian'];
$tglpendirian = date('d-m-Y', strtotime($tglpendirian));
$nopengesahanpn = $sm['no_pengesahan_pn'];

$noskmenkumham = strtoupper($sm['no_sk_menkumham']);
$tglskmenkumham = $sm['tgl_sk_menkumham'];
$tglskmenkumham = date('d-m-Y', strtotime($tglskmenkumham));

$lokasi = $sm['lokasi'];
$nowa = $sm['no_wa'];

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
                        Isi dan lengkapi form isian data <strong><?php echo $layanan ?></strong></br>
                        1. Nama Yayasan (Nama yang tertera pada SK Kemenkumham)<br>
                        2. Nama Pimpinan Yayasan (Nama Ketua Pengurus yang tertera pada SK Kemenkumham)<br>
                        3. Data Pendirian Dan Pengesahan Yayasan<br>
                        4. Data Lokasi Dan Kontak
                        <br><br>
                        Pengisian data <strong>Alamat
                            (Provinsi, Kabupaten/Kota, Kecamatan dan Kelurahan/Desa)</strong>,
                        </br>Jika tidak ada dalam list, maka <strong>Isi / Tulis Di Isian (Sampingnya)</strong>
                        </br><strong>Catatan :</strong> Utamakan menggunakan data yang ada di dalam <strong>List</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" class="form-control form-control-sm" id="txtidtransaksiNPYPE" value="<?php echo $idtransaksi ?>" hidden>
    <input type="text" class="form-control form-control-sm" id="txtidlayananNPYPE" value="<?php echo $idlayanan ?>" hidden>

    <div class="card mb-2">
        <div class="card-body p-0">
            <div class="row g-2 justify-content-between mt-0 px-card pb-3">

                <div class="form-floating mb-1 mt-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmyayasanE" value="<?php echo $nmyayasan ?>" maxlength="100" placeholder="Nama Yayasan" autocomplete="off">
                    <label for="txtnmyayasanE">1. Nama Yayasan</label>
                </div>

                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="txtnmpimpinanE" value="<?php echo $nmpimpinan ?>" maxlength="50" placeholder="Nama Pimpinan Yayasan" autocomplete="off">
                    <label for="txtnmpimpinanE">2. Nama Pimpinan Yayasan</label>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboprovinsiNPYPE" id="cboprovinsiNPYPE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Provinsi</option>
                            <?php
                            $sqlprop = ("SELECT kd_propinsi,nm_propinsi FROM tte_m_propinsi ORDER BY nm_propinsi ASC");
                            $resultprop = mysqli_query($dbconn, $sqlprop);
                            while ($p = mysqli_fetch_array($resultprop)) {
                                $idprovinsix = $p['kd_propinsi'];
                                $nmprovinsix = ucwords(strtolower($p['nm_propinsi']));
                                if ($idpropinsi == $idprovinsix) {
                                    $plhpropinsi = "selected";
                                } else {
                                    $plhpropinsi = "";
                                }
                                echo "
                                        <option value='$idprovinsix' $plhpropinsi >$nmprovinsix</option>";
                            }
                            mysqli_free_result($resultprop);
                            ?>
                        </select>
                        <label for="cboprovinsiNPYPE">Pilih Provinsi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtprovinsiNPYPE" value="<?php echo $propinsi ?>" maxlength="50" placeholder="Provinsi" autocomplete="off">
                        <label for="txtprovinsiNPYPE">Provinsi</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokabupatenNPYPE" id="cbokabupatenNPYPE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kabupaten</option>
                            <?php
                            $sqlkab = ("SELECT kd_kota,nama_kota FROM tte_m_kota WHERE kd_propinsi='" . $idpropinsi . "' ORDER BY nama_kota ASC");
                            $resultkab = mysqli_query($dbconn, $sqlkab);
                            while ($k = mysqli_fetch_array($resultkab)) {
                                $kdkota = $k['kd_kota'];
                                $nmkota = ucwords(strtolower($k['nama_kota']));
                                if ($idkota == $kdkota) {
                                    $plhkab = "selected";
                                } else {
                                    $plhkab = "";
                                }
                                echo "
                                        <option value='$kdkota' $plhkab >$nmkota</option>";
                            }
                            mysqli_free_result($resultkab);
                            ?>
                        </select>
                        <label for="cbokabupatenNPYPE">Pilih Kabupaten</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkabupatenNPYPE" value="<?php echo $kabupaten ?>" maxlength="50" placeholder="Kabupaten/kota" autocomplete="off">
                        <label for="txtkabupatenNPYPE">Kabupaten</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokecamatanNPYPE" id="cbokecamatanNPYPE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kecamatan</option>
                            <?php
                            $sqlkec = ("SELECT kd_kecamatan,nama_kecamatan FROM tte_m_kecamatan WHERE kd_kota='" . $idkota . "' ORDER BY nama_kecamatan ASC");
                            $resultkec = mysqli_query($dbconn, $sqlkec);
                            while ($kc = mysqli_fetch_array($resultkec)) {
                                $kdkecamatan = $kc['kd_kecamatan'];
                                $namakecamatan = ucwords(strtolower($kc['nama_kecamatan']));
                                if ($idkecamatan == $kdkecamatan) {
                                    $plhkec = "selected";
                                } else {
                                    $plhkec = "";
                                }
                                echo "
                                        <option value='$kdkecamatan' $plhkec >$namakecamatan</option>";
                            }
                            mysqli_free_result($resultkec);
                            ?>
                        </select>
                        <label for="cbokecamatanNPYPE">Pilih Kecamatan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkecamatanNPYPE" value="<?php echo $kecamatan ?>" maxlength="50" placeholder="Kecamatan" autocomplete="off">
                        <label for="txtkecamatanNPYPE">Kecamatan</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbodesaNPYPE" id="cbodesaNPYPE" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Desa / Kelurahan</option>
                            <?php
                            $sqlds = ("SELECT kd_desa,nama_desa FROM tte_m_desa WHERE kd_kecamatan='" . $idkecamatan . "' ORDER BY nama_desa ASC");
                            $resultds = mysqli_query($dbconn, $sqlds);
                            while ($ds = mysqli_fetch_array($resultds)) {
                                $kddesa = $ds['kd_desa'];
                                $namadesa = ucwords(strtolower($ds['nama_desa']));
                                if ($iddesa == $kddesa) {
                                    $plhds = "selected";
                                } else {
                                    $plhds = "";
                                }
                                echo "
                                        <option value='$kddesa' $plhds >$namadesa</option>";
                            }
                            mysqli_free_result($resultds);
                            mysqli_close($dbconn);
                            ?>
                        </select>
                        <label for="cbodesaNPYPE">Pilih Desa / Kelurahan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtdesaNPYPE" value="<?php echo $desa ?>" maxlength="50" placeholder="Kelurahan/desa" autocomplete="off">
                        <label for="txtdesaNPYPE">Desa / Kelurahan</label>
                    </div>
                </div>

                <div class="form-floating mb-0">
                    <input type="text" class="form-control form-control-sm" id="txtdusunNPYPE" value="<?php echo $dusun ?>" maxlength="50" placeholder="Dusun" autocomplete="off">
                    <label for="txtdusunNPYPE">Dusun</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="text" class="form-control form-control-sm" id="txtalamatNPYPE" value="<?php echo $alamat ?>" maxlength="200" placeholder="Alamat" autocomplete="off">
                    <label for="txtalamatNPYPE">Alamat</label>
                </div>

                <div class="col-4">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtRTNPYPE" value="<?php echo $rt ?>" maxlength="10" placeholder="RT" autocomplete="off">
                        <label for="txtRTNPYPE">RT</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtRWNPYPE" value="<?php echo $rw ?>" maxlength="10" placeholder="RW" autocomplete="off">
                        <label for="txtRWNPYPE">RW</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-0">
                        <input type="number" class="form-control form-control-sm" id="txtposcodeNPYPE" value="<?php echo $kodepos ?>" maxlength="5" placeholder="Kode Pos" autocomplete="off">
                        <label for="txtposcodeNPYPE">Kode Pos</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtteleponNPYPE" value="<?php echo $telepon ?>" maxlength="25" placeholder="No. Telepon" autocomplete="off">
                        <label for="txtteleponNPYPE">No. Telepon</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtFaxNPYPE" value="<?php echo $fax ?>" maxlength="25" placeholder="Faximile" autocomplete="off">
                        <label for="txtFaxNPYPE">Faximile</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtemailNPYPE" value="<?php echo $email ?>" maxlength="50" placeholder="Email" autocomplete="off">
                        <label for="txtemailNPYPE">Email</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtWebsiteNPYPE" value="<?php echo $website ?>" maxlength="50" placeholder="Website" autocomplete="off">
                        <label for="txtWebsiteNPYPE">Website</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">3. Data Pendirian Dan Pengesahan Yayasan</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnopendirianNPYPE" value="<?php echo $nopendirian ?>" maxlength="50" placeholder="No. Pendirian Yayasan" autocomplete="off">
                <label for="txtnopendirianNPYPE">No. Pendirian Yayasan</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglpendirianNPYPE" value="<?php echo $tglpendirian ?>" type="text" placeholder="Tanggal Pendirian Yayasan" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglpendirianNPYPE">Tanggal Pendirian Yayasan</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnopengesahanpnNPYPE" value="<?php echo $nopengesahanpn ?>" maxlength="50" placeholder="No. Pengesahan Pengadilan Negeri" autocomplete="off">
                <label for="txtnopengesahanpnNPYPE">No. Pengesahan Pengadilan Negeri</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnoskBHmenkumNPYPE" value="<?php echo $noskmenkumham ?>" maxlength="50" placeholder="No. SK Pengesahan Badan Hukum Menkumham" autocomplete="off">
                <label for="txtnoskBHmenkumNPYPE">No. SK Pengesahan Badan Hukum Menkumham</label>
            </div>

            <div class="form-floating mb-1">
                <input class="form-control form-control-sm datetimepicker" id="txttanggalskBHmenkumNPYPE" value="<?php echo $tglskmenkumham ?>" type="text" placeholder="Tanggal SK Pengesahan Badan Hukum Menkumham" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttanggalskBHmenkumNPYPE">Tanggal SK Pengesahan Badan Hukum Menkumham</label>
            </div>

        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">4. Data Lokasi Dan Kontak</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <label class="form-label fs--1 mb-1 ms-1"><a href="https://www.google.co.id/maps" target="_blank">Click untuk mencari lokasi</a></label>
            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtlonlatNPYPE" value="<?php echo $lokasi ?>" maxlength="100" placeholder="Lokasi" autocomplete="off">
                <label for="txtlonlatNPYPE">Lokasi</label>
            </div>

            <div class="form-floating mb-1">
                <input type="number" class="form-control form-control-sm" id="txtnowaNPYPE" value="<?php echo $nowa ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                <label for="txtnowaNPYPE">No. HP WhatsApp (WA) Aktif</label>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanNPYPE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $("#cboprovinsiNPYPE").on("change", function() {
        $("#txtprovinsiNPYPE").val("");
        $("#cbokabupatenNPYPE").val("");
        $("#txtkabupatenNPYPE").val("");
        $("#cbokecamatanNPYPE").val("");
        $("#txtkecamatanNPYPE").val("");
        $("#cbodesaNPYPE").val("");
        $("#txtdesaNPYPE").val("");
        var kdpropinsi = $("#cboprovinsiNPYPE").val();
        var nmprovinsi = $("#cboprovinsiNPYPE :selected").text();
        $("#txtprovinsiNPYPE").val(nmprovinsi);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_kota.php",
            data: {
                kdpropinsi: kdpropinsi
            },
            success: function(resp) {
                $("#cbokabupatenNPYPE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokabupatenNPYPE").on("change", function() {
        $("#txtkabupatenNPYPE").val("");
        $("#cbokecamatanNPYPE").val("");
        $("#txtkecamatanNPYPE").val("");
        $("#cbodesaNPYPE").val("");
        $("#txtdesaNPYPE").val("");
        var kdkota = $("#cbokabupatenNPYPE").val();
        var nmkota = $("#cbokabupatenNPYPE :selected").text();
        $("#txtkabupatenNPYPE").val(nmkota);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_kecamatan.php",
            data: {
                kdkota: kdkota
            },
            success: function(resp) {
                $("#cbokecamatanNPYPE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokecamatanNPYPE").on("change", function() {
        $("#txtkecamatanNPYPE").val("");
        $("#cbodesaNPYPE").val("");
        $("#txtdesaNPYPE").val("");
        var kdkecamatan = $("#cbokecamatanNPYPE").val();
        var nmkecamatan = $("#cbokecamatanNPYPE :selected").text();
        $("#txtkecamatanNPYPE").val(nmkecamatan);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_desa.php",
            data: {
                kdkecamatan: kdkecamatan
            },
            success: function(resp) {
                $("#cbodesaNPYPE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbodesaNPYPE").on("change", function() {
        $("#txtdesaNPYPE").val("");
        var nmdesa = $("#cbodesaNPYPE :selected").text();
        $("#txtdesaNPYPE").val(nmdesa);
    });

    $("#cmdsimpanNPYPE").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var idlayanan = $("#txtidlayananNPYPE").val();
        var idtransaksi = $("#txtidtransaksiNPYPE").val();
   
        var nmyayasan = $("#txtnmyayasanE").val();
        var nmpimpinan = $("#txtnmpimpinanE").val();

        var propinsi = $("#txtprovinsiNPYPE").val();
        var kota = $("#txtkabupatenNPYPE").val();
        var kecamatan = $("#txtkecamatanNPYPE").val();
        var desa = $("#txtdesaNPYPE").val();
        var idpropinsi = $("#cboprovinsiNPYPE").val();
        var idkota = $("#cbokabupatenNPYPE").val();
        var idkecamatan = $("#cbokecamatanNPYPE").val();
        var iddesa = $("#cbodesaNPYPE").val();

        var dusun = $("#txtdusunNPYPE").val();
        var alamat = $("#txtalamatNPYPE").val();
        var rt = $("#txtRTNPYPE").val();
        var rw = $("#txtRWNPYPE").val();
        var kodepos = $("#txtposcodeNPYPE").val();
        var telepon = $("#txtteleponNPYPE").val();
        var fax = $("#txtFaxNPYPE").val();
        var email = $("#txtemailNPYPE").val();
        var website = $("#txtWebsiteNPYPE").val();

        var nopendirian = $("#txtnopendirianNPYPE").val();
        var tglpendirian = $("#txttglpendirianNPYPE").val();
        var nopengesahanpn = $("#txtnopengesahanpnNPYPE").val();

        var noskBH = $("#txtnoskBHmenkumNPYPE").val();
        var tglskBH = $("#txttanggalskBHmenkumNPYPE").val();

        var lokasi = $("#txtlonlatNPYPE").val();
        var noWA = $("#txtnowaNPYPE").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);
        data.append('idtransaksi', idtransaksi);

        data.append('nmyayasan', nmyayasan);
        data.append('nmpimpinan', nmpimpinan);

        data.append('propinsi', propinsi);
        data.append('kota', kota);
        data.append('kecamatan', kecamatan);
        data.append('desa', desa);
        data.append('idpropinsi', idpropinsi);
        data.append('idkota', idkota);
        data.append('idkecamatan', idkecamatan);
        data.append('iddesa', iddesa);

        data.append('dusun', dusun);
        data.append('alamat', alamat);
        data.append('rt', rt);
        data.append('rw', rw);
        data.append('kodepos', kodepos);
        data.append('telepon', telepon);
        data.append('fax', fax);
        data.append('email', email);
        data.append('website', website);

        data.append('nopendirian', nopendirian);
        data.append('tglpendirian', tglpendirian);
        data.append('nopengesahanpn', nopengesahanpn);
        data.append('noskBH', noskBH);
        data.append('tglskBH', tglskBH);

        data.append('lokasi', lokasi);
        data.append('noWA', noWA);

        if (idlayanan.length <= 0 || idinstansi.length <= 0 || idtransaksi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmyayasan.length <= 0) {
            $("#txtnmyayasanE").focus();
            alert("Nama yayasan masih kosong")
        } else if (nmpimpinan.length <= 0) {
            $("#txtnmpimpinanE").focus();
            alert("Nama pimpinan yayasan masih kosong")

        } else if (propinsi.length <= 0) {
            $("#cboprovinsiNPYPE").focus();
            alert("Provinsi masih kosong")
        } else if (kota.length <= 0) {
            $("#cbokabupatenNPYPE").focus();
            alert("Kota/kabupaten masih kosong")
        } else if (kecamatan.length <= 0) {
            $("#cbokecamatanNPYPE").focus();
            alert("Kecamatan masih kosong")
        } else if (desa.length <= 0) {
            $("#cbodesaNPYPE").focus();
            alert("Kelurahan/desa masih kosong")

        } else if (dusun.length <= 0) {
            $("#txtdusunNPYPE").focus();
            alert("Dusun masih kosong")
        } else if (alamat.length <= 0) {
            $("#txtalamatNPYPE").focus();
            alert("Alamat masih kosong")
        } else if (rt.length <= 0) {
            $("#txtRTNPYPE").focus();
            alert("RT masih kosong")
        } else if (rw.length <= 0) {
            $("#txtRWNPYPE").focus();
            alert("RW masih kosong")
        } else if (kodepos.length <= 0) {
            $("#txtposcodeNPYPE").focus();
            alert("Kode pos masih kosong")
        } else if (telepon.length <= 0) {
            $("#txtteleponNPYPE").focus();
            alert("No. telepon masih kosong")
        } else if (fax.length <= 0) {
            $("#txtFaxNPYPE").focus();
            alert("No. Faximile masih kosong")
        } else if (email.length <= 0) {
            $("#txtemailNPYPE").focus();
            alert("Email masih kosong")
        } else if (website.length <= 0) {
            $("#txtWebsiteNPYPE").focus();
            alert("Website masih kosong")

        } else if (nopendirian.length <= 0) {
            $("#txtnopendirianNPYPE").focus();
            alert("No. Pendirian masih kosong")
        } else if (tglpendirian.length <= 0) {
            $("#txttglpendirianNPYPE").focus();
            alert("Tanggal pendirian masih kosong")
        } else if (nopengesahanpn.length <= 0) {
            $("#txtnopengesahanpnNPYPE").focus();
            alert("No. SK pengesahan PN masih kosong")
        } else if (noskBH.length <= 0) {
            $("#txtnoskBHmenkumNPYPE").focus();
            alert("No. SK badan hukum kemenkumham masih kosong")
        } else if (tglskBH.length <= 0) {
            $("#txttanggalskBHmenkumNPYPE").focus();
            alert("Tanggal SK badan hukum kemenkumham masih kosong")

        } else if (lokasi.length <= 0) {
            $("#txtlonlatNPYPE").focus();
            alert("Lintang bujur lokasi masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaNPYPE").focus();
            alert("No. HP whatsApp masih kosong")

        } else {
            var urlnya = "klinik-dapo/trans-layanan/pengajuan-npyp/aksi_edit.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanNPYPE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiPengajuanNPYP();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanNPYPE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanNPYPE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanNPYPE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>