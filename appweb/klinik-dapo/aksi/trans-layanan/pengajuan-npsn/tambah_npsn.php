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

    <div class="card mb-3">
        <div class="card-body p-0">
            <div class="row g-2 justify-content-between mt-0 px-card pb-3">

                <div class="form-floating mb-1 mt-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsekolahnpsn" value="" maxlength="100" placeholder="Nama Sekolah" autocomplete="off">
                    <label for="txtnmsekolahnpsn">Nama Sekolah</label>
                </div>

                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="txtalamatnpsn" value="" maxlength="200" placeholder="Alamat" autocomplete="off">
                    <label for="txtalamatnpsn">Alamat</label>
                </div>
                
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboprovinsiNPSN" id="cboprovinsiNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                        <label for="cboprovinsiNPSN">Pilih Provinsi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtprovinsiNPSN" value="" maxlength="50" placeholder="Provimsi" autocomplete="off">
                        <label for="txtprovinsiNPSN">Provinsi</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokabupatenNPSN" id="cbokabupatenNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kabupaten</option>
                        </select>
                        <label for="cbokabupatenNPSN">Pilih Kabupaten</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkabupatenNPSN" value="" maxlength="50" placeholder="Kabupaten/kota" autocomplete="off">
                        <label for="txtkabupatenNPSN">Kabupaten</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokecamatanNPSN" id="cbokecamatanNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <label for="cbokecamatanNPSN">Pilih Kecamatan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkecamatanNPSN" value="" maxlength="50" placeholder="Kecamatan" autocomplete="off">
                        <label for="txtkecamatanNPSN">Kecamatan</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbodesaNPSN" id="cbodesaNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Desa / Kelurahan</option>
                        </select>
                        <label for="cbodesaNPSN">Pilih Desa / Kelurahan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtdesaNPSN" value="" maxlength="50" placeholder="Kelurahan/desa" autocomplete="off">
                        <label for="txtdesaNPSN">Desa / Kelurahan</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojenjangNPSN" id="cbojenjangNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Jenjang</option>
                        <option value="TK">TK</option>
                        <option value="KB">KB</option>
                        <option value="SPS">SPS</option>
                        <option value="TPA">TPA</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="PKBM">PKBM</option>
                    </select>
                    <label for="cbojenjangNPSN">Pilih Jenjang</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatusNPSN" id="cbostatusNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Status</option>
                        <option value="NEGERI">Negeri</option>
                        <option value="SWASTA">Swasta</option>
                    </select>
                    <label for="cbostatusNPSN">Pilih Status</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokepemilikanNPSN" id="cbokepemilikanNPSN" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Kepemilikan</option>
                        <option value="YAYASAN">Yayasan</option>
                        <option value="PEMERINTAH DAERAH">Pemerintah Daerah</option>
                        <option value="PEMERINTAH PUSAT">Pemerintah Pusat</option>
                        <option value="LAINNYA">Lainnya</option>
                    </select>
                    <label for="cbokepemilikanNPSN">Kepemilikan</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtluasmilikNPSN" value="" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtluasmilikNPSN">Luas Tanah Milik (M2)</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtluasnonmilikNPSN" value="" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtluasnonmilikNPSN">Luas Tanah Bukan Milik (M2)</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaNPSN" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaNPSN">No. HP WhatsApp (WA) Aktif</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnoskoperasionalNPSN" value="" maxlength="50" placeholder="No. SK Operasional" autocomplete="off">
                <label for="txtnoskoperasionalNPSN">No. SK Operasional</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglskoperasionalNPSN" value="" type="text" placeholder="Tanggal SK Operasional" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglskoperasionalNPSN">Tanggal SK Operasional</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglselesaiskoperasionalNPSN" value="" type="text" placeholder="Tanggal Selesai SK Operasional" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglselesaiskoperasionalNPSN">Tanggal Selesai SK Operasional</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtskpendirianNPSN" value="" maxlength="50" placeholder="No. SK Pendirian" autocomplete="off">
                <label for="txtskpendirianNPSN">No. SK Pendirian</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglskpendirianNPSN" value="" type="text" placeholder="Tanggal SK Pendirian" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglskpendirianNPSN">Tanggal SK Pendirian</label>
            </div>

            <label class="form-label fs--1 mb-1 ms-1"><a href="https://www.google.co.id/maps" target="_blank">Click untuk mencari lokasi</a></label>
            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtlonlatNPSN" value="" maxlength="100" placeholder="Lokasi" autocomplete="off">
                <label for="txtlonlatNPSN">Lokasi</label>
            </div>
            
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanNPSN">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        $("#txtnmsekolahnpsn").val("");
        $("#txtalamatnpsn").val("");

        $("#cboprovinsiNPSN").val("");
        $("#txtprovinsiNPSN").val("");
        $("#cbokabupatenNPSN").val("");
        $("#txtkabupatenNPSN").val("");
        $("#cbokecamatanNPSN").val("");
        $("#txtkecamatanNPSN").val("");
        $("#cbodesaNPSN").val("");
        $("#txtdesaNPSN").val("");

        $("#cbojenjangNPSN").val("");
        $("#cbostatusNPSN").val("");
        $("#cbokepemilikanNPSN").val("");
        $("#txtluasmilikNPSN").val("");
        $("#txtluasnonmilikNPSN").val("");
        $("#txtnowaNPSN").val("");

        $("#txtnoskoperasionalNPSN").val("");
        $("#txttglskoperasionalNPSN").val("");
        $("#txttglselesaiskoperasionalNPSN").val("");

        $("#txtskpendirianNPSN").val("");
        $("#txttglskpendirianNPSN").val("");
        $("#txtlonlatNPSN").val("");
    });

    $("#cboprovinsiNPSN").on("change", function() {
        $("#txtprovinsiNPSN").val("");
        $("#cbokabupatenNPSN").val("");
        $("#txtkabupatenNPSN").val("");
        $("#cbokecamatanNPSN").val("");
        $("#txtkecamatanNPSN").val("");
        $("#cbodesaNPSN").val("");
        $("#txtdesaNPSN").val("");
        var kdpropinsi = $("#cboprovinsiNPSN").val();
        var nmprovinsi = $("#cboprovinsiNPSN :selected").text();
        $("#txtprovinsiNPSN").val(nmprovinsi);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_kota.php",
            data: {
                kdpropinsi: kdpropinsi
            },
            success: function(resp) {
                $("#cbokabupatenNPSN").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokabupatenNPSN").on("change", function() {
        $("#txtkabupatenNPSN").val("");
        $("#cbokecamatanNPSN").val("");
        $("#txtkecamatanNPSN").val("");
        $("#cbodesaNPSN").val("");
        $("#txtdesaNPSN").val("");
        var kdkota = $("#cbokabupatenNPSN").val();
        var nmkota = $("#cbokabupatenNPSN :selected").text();
        $("#txtkabupatenNPSN").val(nmkota);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_kecamatan.php",
            data: {
                kdkota: kdkota
            },
            success: function(resp) {
                $("#cbokecamatanNPSN").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokecamatanNPSN").on("change", function() {
        $("#txtkecamatanNPSN").val("");
        $("#cbodesaNPSN").val("");
        $("#txtdesaNPSN").val("");
        var kdkecamatan = $("#cbokecamatanNPSN").val();
        var nmkecamatan = $("#cbokecamatanNPSN :selected").text();
        $("#txtkecamatanNPSN").val(nmkecamatan);
        $.ajax({
            type: "POST",
            url: "aksi/ambil_desa.php",
            data: {
                kdkecamatan: kdkecamatan
            },
            success: function(resp) {
                $("#cbodesaNPSN").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbodesaNPSN").on("change", function() {
        $("#txtdesaNPSN").val("");
        var nmdesa = $("#cbodesaNPSN :selected").text();
        $("#txtdesaNPSN").val(nmdesa);
    });

    $("#cmdsimpanNPSN").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
        var idlayanan = "6";

        var nmsekolah = $("#txtnmsekolahnpsn").val();
        var alamat = $("#txtalamatnpsn").val();
        var propinsi = $("#txtprovinsiNPSN").val();
        var kota = $("#txtkabupatenNPSN").val();
        var kecamatan = $("#txtkecamatanNPSN").val();
        var desa = $("#txtdesaNPSN").val();
        var idpropinsi = $("#cboprovinsiNPSN").val();
        var idkota = $("#cbokabupatenNPSN").val();
        var idkecamatan = $("#cbokecamatanNPSN").val();
        var iddesa = $("#cbodesaNPSN").val();

        var jenjang = $("#cbojenjangNPSN").val();
        var status = $("#cbostatusNPSN").val();
        var kepemilikan = $("#cbokepemilikanNPSN").val();
        var luasmilik = $("#txtluasmilikNPSN").val();
        var luasnonmilik = $("#txtluasnonmilikNPSN").val();
        var noWA = $("#txtnowaNPSN").val();

        var noskoperasional = $("#txtnoskoperasionalNPSN").val();
        var tglskoperasional = $("#txttglskoperasionalNPSN").val();
        var tglselesaisk = $("#txttglselesaiskoperasionalNPSN").val();
        var noskpendirian = $("#txtskpendirianNPSN").val();
        var tglskpendirian = $("#txttglskpendirianNPSN").val();
        var lonlat = $("#txtlonlatNPSN").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
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
            $("#txtnmsekolahnpsn").focus();
            alert("Nama sekolah masih kosong")
        } else if (alamat.length <= 0) {
            $("#txtalamatnpsn").focus();
            alert("Alamat sekolah masih kosong")
        } else if (propinsi.length <= 0) {
            $("#cboprovinsiNPSN").focus();
            alert("Provinsi masih kosong")
        } else if (kota.length <= 0) {
            $("#cbokabupatenNPSN").focus();
            alert("Kota/kabupaten masih kosong")
        } else if (kecamatan.length <= 0) {
            $("#cbokecamatanNPSN").focus();
            alert("Kecamatan masih kosong")
        } else if (desa.length <= 0) {
            $("#cbodesaNPSN").focus();
            alert("Kelurahan/desa masih kosong")

        } else if (jenjang.length <= 0) {
            $("#cbojenjangNPSN").focus();
            alert("Jenjang masih kosong")
        } else if (status.length <= 0) {
            $("#cbostatusNPSN").focus();
            alert("Status sekolah masih kosong")
        } else if (kepemilikan.length <= 0) {
            $("#cbokepemilikanNPSN").focus();
            alert("Kepemilikan masih kosong")
        } else if (luasmilik.length <= 0) {
            $("#txtluasmilikNPSN").focus();
            alert("Luas milik masih kosong")
        } else if (luasnonmilik.length <= 0) {
            $("#txtluasnonmilikNPSN").focus();
            alert("Luas non milik masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaNPSN").focus();
            alert("No. HP WhatsApp (WA ** Aktif) masih kosong")

        } else if (noskoperasional.length <= 0) {
            $("#txtnoskoperasionalNPSN").focus();
            alert("No. SK operasional masih kosong")
        } else if (tglskoperasional.length <= 0) {
            $("#txttglskoperasionalNPSN").focus();
            alert("Tanggal SK operasional masih kosong")
        } else if (tglselesaisk.length <= 0) {
            $("#txttglselesaiskoperasionalNPSN").focus();
            alert("Tanggal selesai SK Operasional masih kosong")
        } else if (noskpendirian.length <= 0) {
            $("#txtskpendirianNPSN").focus();
            alert("No. SK pendirian masih kosong")
        } else if (tglskpendirian.length <= 0) {
            $("#txttglskpendirianNPSN").focus();
            alert("Tanggal SK pendirian masih kosong")
        } else if (lonlat.length <= 0) {
            $("#txtlonlatNPSN").focus();
            alert("Lintang bujur lokasi masih kosong")

        } else {
            var urlnya = "aksi/trans-layanan/pengajuan-npsn/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanNPSN").attr("disabled", "disabled");
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
                        $("#cmdsimpanNPSN").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanNPSN").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanNPSN").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>