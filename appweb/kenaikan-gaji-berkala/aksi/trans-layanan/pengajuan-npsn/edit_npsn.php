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

$sqlx = ("SELECT * FROM tte_trans_pengajuan_npsn p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$nmsekolah = strtoupper($sm['nama']);
$alamat = $sm['alamat'];
$propinsi = ucwords(strtolower($sm['propinsi']));
$kabupaten = ucwords(strtolower($sm['kabupaten']));
$kecamatan = ucwords(strtolower($sm['kecamatan']));
$desa = ucwords(strtolower($sm['desa']));

$idpropinsi = $sm['id_propinsi'];
$idkota = $sm['id_kabupaten'];
$idkecamatan = $sm['id_kecamatan'];
$iddesa = $sm['id_desa'];

$jenjang = strtoupper($sm['jenjang']);
$statussekolah = strtoupper($sm['status_sekolah']);
$kepemilikan = strtoupper($sm['kepemilikan']);

$luasmilik = $sm['luas_tanah_milik'];
$luasbukanmilik = $sm['luas_tanah_bukan_milik'];

$noskoperasional = strtoupper($sm['no_sk_operasional']);
$tglskoperasional = $sm['tgl_sk_operasional'];$tglskoperasional = date('d-m-Y', strtotime($tglskoperasional));
$tglselesai = $sm['tgl_selesai_sk_operasional'];$tglselesai = date('d-m-Y', strtotime($tglselesai));

$noskpendirian = strtoupper($sm['no_sk_pendirian']);
$tglskpendirian = $sm['tgl_sk_pendirian'];$tglskpendirian = date('d-m-Y', strtotime($tglskpendirian));

$lonlatlokasi = $sm['lonlat_lokasi'];
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
                        Pengisian data <strong>
                            (Provinsi, Kabupaten/Kota, Kecamatan dan Kelurahan/Desa)</strong>,
                        </br>Jika tidak ada dalam list, maka <strong>Isi / Tulis Di Isian (Sampingnya)</strong>
                        </br><strong>Catatan :</strong><br />Utamakan menggunakan data yang ada di dalam <strong>List</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" class="form-control form-control-sm" id="txtidtransaksiNPSNE" value="<?php echo $idtransaksi ?>" hidden >
    <input type="text" class="form-control form-control-sm" id="txtidlayananNPSNE" value="<?php echo $idlayanan ?>" hidden >

    <div class="card mb-3">
        <div class="card-body p-0">
            <div class="row g-2 justify-content-between mt-0 px-card pb-3">

                <div class="form-floating mb-1 mt-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsekolahnpsnE" value="<?php echo $nmsekolah ?>" maxlength="100" placeholder="Nama Sekolah" autocomplete="off">
                    <label for="txtnmsekolahnpsnE">Nama Sekolah</label>
                </div>

                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="txtalamatnpsnE" value="<?php echo $alamat ?>" maxlength="200" placeholder="Alamat" autocomplete="off">
                    <label for="txtalamatnpsnE">Alamat</label>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboprovinsiNPSNE" id="cboprovinsiNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                        <label for="cboprovinsiNPSNE">Pilih Provinsi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtprovinsiNPSNE" value="<?php echo $propinsi ?>" maxlength="50" placeholder="Provinsi" autocomplete="off">
                        <label for="txtprovinsiNPSNE">Provinsi</label>
                    </div>
                </div>
               
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokabupatenNPSNE" id="cbokabupatenNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                        <label for="cbokabupatenNPSNE">Pilih Kabupaten</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkabupatenNPSNE" value="<?php echo $kabupaten ?>" maxlength="50" placeholder="Kabupaten/kota" autocomplete="off">
                        <label for="txtkabupatenNPSNE">Kabupaten</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokecamatanNPSNE" id="cbokecamatanNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                        <label for="cbokecamatanNPSNE">Pilih Kecamatan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkecamatanNPSNE" value="<?php echo $kecamatan ?>" maxlength="50" placeholder="Kecamatan" autocomplete="off">
                        <label for="txtkecamatanNPSNE">Kecamatan</label>
                    </div>
                </div>
               
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbodesaNPSNE" id="cbodesaNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                        <label for="cbodesaNPSNE">Pilih Desa / Kelurahan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtdesaNPSNE" value="<?php echo $desa ?>" maxlength="50" placeholder="Kelurahan/desa" autocomplete="off">
                        <label for="txtdesaNPSNE">Desa / Kelurahan</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojenjangNPSNE" id="cbojenjangNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Jenjang</option>
                        <?php
                        if ($jenjang == "TK") {
                            $plhTK = "selected";
                        } else if ($jenjang == "KB") {
                            $plhKB = "selected";
                        } else if ($jenjang == "SPS") {
                            $plhSPS = "selected";
                        } else if ($jenjang == "TPA") {
                            $plhTPA = "selected";
                        } else if ($jenjang == "SD") {
                            $plhSD = "selected";
                        } else if ($jenjang == "SMP") {
                            $plhSMP = "selected";
                        } else if ($jenjang == "PKBM") {
                            $plhPKBM = "selected";
                        }
                        echo "<option value='TK' $plhTK >TK</option>
                        <option value='KB' $plhKB >KB</option>
                        <option value='SPS' $plhSPS >SPS</option>
                        <option value='TPA' $plhTPA >TPA</option>
                        <option value='SD' $plhSD >SD</option>
                        <option value='SMP' $plhSMP >SMP</option>
                        <option value='PKBM' $plhPKBM >PKBM</option>";
                        ?>
                    </select>
                    <label for="cbojenjangNPSNE">Pilih Jenjang</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatusNPSNE" id="cbostatusNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Status</option>
                        <?php
                        if ($statussekolah == "NEGERI") {
                            $plhNeg = "selected";
                        } else if ($statussekolah == "SWASTA") {
                            $plhSws = "selected";
                        } 
                        echo "<option value='NEGERI' $plhNeg >Negeri</option>
                        <option value='SWASTA' $plhSws >Swasta</option>";
                        ?>
                    </select>
                    <label for="cbostatusNPSNE">Pilih Status</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokepemilikanNPSNE" id="cbokepemilikanNPSNE" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Kepemilikan</option>
                        <?php
                        if ($kepemilikan == "YAYASAN") {
                            $plhyysn = "selected";
                        } else if ($kepemilikan == "PEMERINTAH DAERAH") {
                            $plhpemda = "selected";
                        } else if ($kepemilikan == "PEMERINTAH PUSAT") {
                            $plhpempus = "selected";
                        } else if ($kepemilikan == "LAINNYA") {
                            $plhlain = "selected";
                        }
                        echo "<option value='YAYASAN' $plhyysn >Yayasan</option>
                        <option value='PEMERINTAH DAERAH' $plhpemda >Pemerintah Daerah</option>
                        <option value='PEMERINTAH PUSAT' $plhpempus >Pemerintah Pusat</option>
                        <option value='LAINNYA' $plhlain >Lainnya</option>";
                        ?>
                    </select>
                    <label for="cbokepemilikanNPSNE">Kepemilikan</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtluasmilikNPSNE" value="<?php echo $luasmilik ?>" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtluasmilikNPSNE">Luas Tanah Milik (M2)</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtluasnonmilikNPSNE" value="<?php echo $luasbukanmilik ?>" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtluasnonmilikNPSNE">Luas Tanah Bukan Milik (M2)</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaNPSNE" value="<?php echo $nowa ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaNPSNE">No. HP WhatsApp (WA) Aktif</label>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data SK Operasional Dan Pendirian Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnoskoperasionalNPSNE" value="<?php echo $noskoperasional ?>" maxlength="50" placeholder="No. SK Operasional" autocomplete="off">
                <label for="txtnoskoperasionalNPSNE">No. SK Operasional</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglskoperasionalNPSNE" value="<?php echo $tglskoperasional ?>" type="text" placeholder="Tanggal SK Operasional" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglskoperasionalNPSNE">Tanggal SK Operasional</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglselesaiskoperasionalNPSNE" value="<?php echo $tglselesai ?>" type="text" placeholder="Tanggal Selesai SK Operasional" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglselesaiskoperasionalNPSNE">Tanggal Selesai SK Operasional</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtskpendirianNPSNE" value="<?php echo $noskpendirian ?>" maxlength="50" placeholder="No. SK Pendirian" autocomplete="off">
                <label for="txtskpendirianNPSNE">No. SK Pendirian</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglskpendirianNPSNE" value="<?php echo $tglskpendirian ?>" type="text" placeholder="Tanggal SK Pendirian" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglskpendirianNPSNE">Tanggal SK Pendirian</label>
            </div>

            <label class="form-label fs--1 mb-1 ms-1"><a href="https://www.google.co.id/maps" target="_blank">Click untuk mencari lokasi</a></label>
            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtlonlatNPSNE" value="<?php echo $lonlatlokasi ?>" maxlength="100" placeholder="Lokasi" autocomplete="off">
                <label for="txtlonlatNPSNE">Lokasi</label>
            </div>
            
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanNPSNE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">

    $("#cboprovinsiNPSNE").on("change", function() {
        $("#txtprovinsiNPSNE").val("");
        $("#cbokabupatenNPSNE").val("");
        $("#txtkabupatenNPSNE").val("");
        $("#cbokecamatanNPSNE").val("");
        $("#txtkecamatanNPSNE").val("");
        $("#cbodesaNPSNE").val("");
        $("#txtdesaNPSNE").val("");
        var kdpropinsi = $("#cboprovinsiNPSNE").val();
        var nmprovinsi = $("#cboprovinsiNPSNE :selected").text();
        $("#txtprovinsiNPSNE").val(nmprovinsi);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_kota.php",
            data: {
                kdpropinsi: kdpropinsi
            },
            success: function(resp) {
                $("#cbokabupatenNPSNE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokabupatenNPSNE").on("change", function() {
        $("#txtkabupatenNPSNE").val("");
        $("#cbokecamatanNPSNE").val("");
        $("#txtkecamatanNPSNE").val("");
        $("#cbodesaNPSNE").val("");
        $("#txtdesaNPSNE").val("");
        var kdkota = $("#cbokabupatenNPSNE").val();
        var nmkota = $("#cbokabupatenNPSNE :selected").text();
        $("#txtkabupatenNPSNE").val(nmkota);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_kecamatan.php",
            data: {
                kdkota: kdkota
            },
            success: function(resp) {
                $("#cbokecamatanNPSNE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokecamatanNPSNE").on("change", function() {
        $("#txtkecamatanNPSNE").val("");
        $("#cbodesaNPSNE").val("");
        $("#txtdesaNPSNE").val("");
        var kdkecamatan = $("#cbokecamatanNPSNE").val();
        var nmkecamatan = $("#cbokecamatanNPSNE :selected").text();
        $("#txtkecamatanNPSNE").val(nmkecamatan);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_desa.php",
            data: {
                kdkecamatan: kdkecamatan
            },
            success: function(resp) {
                $("#cbodesaNPSNE").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbodesaNPSNE").on("change", function() {
        $("#txtdesaNPSNE").val("");
        var nmdesa = $("#cbodesaNPSNE :selected").text();
        $("#txtdesaNPSNE").val(nmdesa);
    });

    $("#cmdsimpanNPSNE").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
        
        var idtransaksi = $("#txtidtransaksiNPSNE").val();
        var idlayanan = $("#txtidlayananNPSNE").val();

        var nmsekolah = $("#txtnmsekolahnpsnE").val();
        var alamat = $("#txtalamatnpsnE").val();
        var propinsi = $("#txtprovinsiNPSNE").val();
        var kota = $("#txtkabupatenNPSNE").val();
        var kecamatan = $("#txtkecamatanNPSNE").val();
        var desa = $("#txtdesaNPSNE").val();
        var idpropinsi = $("#cboprovinsiNPSNE").val();
        var idkota = $("#cbokabupatenNPSNE").val();
        var idkecamatan = $("#cbokecamatanNPSNE").val();
        var iddesa = $("#cbodesaNPSNE").val();

        var jenjang = $("#cbojenjangNPSNE").val();
        var status = $("#cbostatusNPSNE").val();
        var kepemilikan = $("#cbokepemilikanNPSNE").val();
        var luasmilik = $("#txtluasmilikNPSNE").val();
        var luasnonmilik = $("#txtluasnonmilikNPSNE").val();
        var noWA = $("#txtnowaNPSNE").val();

        var noskoperasional = $("#txtnoskoperasionalNPSNE").val();
        var tglskoperasional = $("#txttglskoperasionalNPSNE").val();
        var tglselesaisk = $("#txttglselesaiskoperasionalNPSNE").val();
        var noskpendirian = $("#txtskpendirianNPSNE").val();
        var tglskpendirian = $("#txttglskpendirianNPSNE").val();
        var lonlat = $("#txtlonlatNPSNE").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idtransaksi', idtransaksi);
        data.append('idlayanan', idlayanan);

        data.append('nmsekolah', nmsekolah);
        data.append('alamat', alamat);
        data.append('propinsi', propinsi);
        data.append('kota', kota);
        data.append('kecamatan', kecamatan);
        data.append('desa', desa);
        data.append('idpropinsi', idpropinsi);
        data.append('idkota', idkota);
        data.append('idkecamatan', idkecamatan);
        data.append('iddesa', iddesa);

        data.append('jenjang', jenjang);
        data.append('status', status);
        data.append('kepemilikan', kepemilikan);
        data.append('luasmilik', luasmilik);
        data.append('luasnonmilik', luasnonmilik);
        data.append('noWA', noWA);

        data.append('noskoperasional', noskoperasional);
        data.append('tglskoperasional', tglskoperasional);
        data.append('tglselesaisk', tglselesaisk);
        data.append('noskpendirian', noskpendirian);
        data.append('tglskpendirian', tglskpendirian);
        data.append('lonlat', lonlat);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmsekolah.length <= 0) {
            $("#txtnmsekolahnpsnE").focus();
            alert("Nama sekolah masih kosong")
        } else if (alamat.length <= 0) {
            $("#txtalamatnpsnE").focus();
            alert("Alamat sekolah masih kosong")
        } else if (propinsi.length <= 0) {
            $("#cboprovinsiNPSNE").focus();
            alert("Provinsi masih kosong")
        } else if (kota.length <= 0) {
            $("#cbokabupatenNPSNE").focus();
            alert("Kota/kabupaten masih kosong")
        } else if (kecamatan.length <= 0) {
            $("#cbokecamatanNPSNE").focus();
            alert("Kecamatan masih kosong")
        } else if (desa.length <= 0) {
            $("#cbodesaNPSNE").focus();
            alert("Kelurahan/desa masih kosong")

        } else if (jenjang.length <= 0) {
            $("#cbojenjangNPSNE").focus();
            alert("Jenjang masih kosong")
        } else if (status.length <= 0) {
            $("#cbostatusNPSNE").focus();
            alert("Status sekolah masih kosong")
        } else if (kepemilikan.length <= 0) {
            $("#cbokepemilikanNPSNE").focus();
            alert("Kepemilikan masih kosong")
        } else if (luasmilik.length <= 0) {
            $("#txtluasmilikNPSNE").focus();
            alert("Luas milik masih kosong")
        } else if (luasnonmilik.length <= 0) {
            $("#txtluasnonmilikNPSNE").focus();
            alert("Luas non milik masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaNPSNE").focus();
            alert("No. HP WhatsApp (WA ** Aktif) masih kosong")

        } else if (noskoperasional.length <= 0) {
            $("#txtnoskoperasionalNPSNE").focus();
            alert("No. SK operasional masih kosong")
        } else if (tglskoperasional.length <= 0) {
            $("#txttglskoperasionalNPSNE").focus();
            alert("Tanggal SK operasional masih kosong")
        } else if (tglselesaisk.length <= 0) {
            $("#txttglselesaiskoperasionalNPSNE").focus();
            alert("Tanggal selesai SK Operasional masih kosong")
        } else if (noskpendirian.length <= 0) {
            $("#txtskpendirianNPSNE").focus();
            alert("No. SK pendirian masih kosong")
        } else if (tglskpendirian.length <= 0) {
            $("#txttglskpendirianNPSNE").focus();
            alert("Tanggal SK pendirian masih kosong")
        } else if (lonlat.length <= 0) {
            $("#txtlonlatNPSNE").focus();
            alert("Lintang bujur lokasi masih kosong")

        } else {
            var urlnya = "aksi/trans-layanan/pengajuan-npsn/aksi_edit.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanNPSNE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiPengajuanNPSN();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanNPSNE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanNPSNE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanNPSNE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>