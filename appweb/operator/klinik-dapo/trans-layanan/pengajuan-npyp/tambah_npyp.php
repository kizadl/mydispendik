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

    <div class="card mb-2">
        <div class="card-body p-0">
            <div class="row g-2 justify-content-between mt-0 px-card pb-3">

                <div class="form-floating mb-1 mt-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmyayasan" value="" maxlength="100" placeholder="Nama Yayasan" autocomplete="off">
                    <label for="txtnmyayasan">1. Nama Yayasan</label>
                </div>

                <div class="form-floating mb-1">
                    <input type="text" class="form-control form-control-sm" id="txtnmpimpinan" value="" maxlength="50" placeholder="Nama Pimpinan Yayasan" autocomplete="off">
                    <label for="txtnmpimpinan">2. Nama Pimpinan Yayasan</label>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cboprovinsiNPYP" id="cboprovinsiNPYP" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                        <label for="cboprovinsiNPYP">Pilih Provinsi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtprovinsiNPYP" value="" maxlength="50" placeholder="Provimsi" autocomplete="off">
                        <label for="txtprovinsiNPYP">Provinsi</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokabupatenNPYP" id="cbokabupatenNPYP" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kabupaten</option>
                        </select>
                        <label for="cbokabupatenNPYP">Pilih Kabupaten</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkabupatenNPYP" value="" maxlength="50" placeholder="Kabupaten/kota" autocomplete="off">
                        <label for="txtkabupatenNPYP">Kabupaten</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-1">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokecamatanNPYP" id="cbokecamatanNPYP" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <label for="cbokecamatanNPYP">Pilih Kecamatan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control form-control-sm" id="txtkecamatanNPYP" value="" maxlength="50" placeholder="Kecamatan" autocomplete="off">
                        <label for="txtkecamatanNPYP">Kecamatan</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbodesaNPYP" id="cbodesaNPYP" data-options='{"removeItemButton":true,"placeholder":true}'>
                            <option value="">Pilih Desa / Kelurahan</option>
                        </select>
                        <label for="cbodesaNPYP">Pilih Desa / Kelurahan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtdesaNPYP" value="" maxlength="50" placeholder="Kelurahan/desa" autocomplete="off">
                        <label for="txtdesaNPYP">Desa / Kelurahan</label>
                    </div>
                </div>

                <div class="form-floating mb-0">
                    <input type="text" class="form-control form-control-sm" id="txtdusunNPYP" value="" maxlength="50" placeholder="Dusun" autocomplete="off">
                    <label for="txtdusunNPYP">Dusun</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="text" class="form-control form-control-sm" id="txtalamatNPYP" value="" maxlength="200" placeholder="Alamat" autocomplete="off">
                    <label for="txtalamatNPYP">Alamat</label>
                </div>

                <div class="col-4">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtRTNPYP" value="" maxlength="10" placeholder="RT" autocomplete="off">
                        <label for="txtRTNPYP">RT</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtRWNPYP" value="" maxlength="10" placeholder="RW" autocomplete="off">
                        <label for="txtRWNPYP">RW</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating mb-0">
                        <input type="number" class="form-control form-control-sm" id="txtposcodeNPYP" value="" maxlength="5" placeholder="Kode Pos" autocomplete="off">
                        <label for="txtposcodeNPYP">Kode Pos</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtteleponNPYP" value="" maxlength="25" placeholder="No. Telepon" autocomplete="off">
                        <label for="txtteleponNPYP">No. Telepon</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtFaxNPYP" value="" maxlength="25" placeholder="Faximile" autocomplete="off">
                        <label for="txtFaxNPYP">Faximile</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtemailNPYP" value="" maxlength="50" placeholder="Email" autocomplete="off">
                        <label for="txtemailNPYP">Email</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-0">
                        <input type="text" class="form-control form-control-sm" id="txtWebsiteNPYP" value="" maxlength="50" placeholder="Website" autocomplete="off">
                        <label for="txtWebsiteNPYP">Website</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnopendirianNPYP" value="" maxlength="50" placeholder="No. Pendirian Yayasan" autocomplete="off">
                <label for="txtnopendirianNPYP">No. Pendirian Yayasan</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglpendirianNPYP" value="" type="text" placeholder="Tanggal Pendirian Yayasan" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglpendirianNPYP">Tanggal Pendirian Yayasan</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnopengesahanpnNPYP" value="" maxlength="50" placeholder="No. Pengesahan Pengadilan Negeri" autocomplete="off">
                <label for="txtnopengesahanpnNPYP">No. Pengesahan Pengadilan Negeri</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnoskBHmenkumNPYP" value="" maxlength="50" placeholder="No. SK Pengesahan Badan Hukum Menkumham" autocomplete="off">
                <label for="txtnoskBHmenkumNPYP">No. SK Pengesahan Badan Hukum Menkumham</label>
            </div>

            <div class="form-floating mb-1">
                <input class="form-control form-control-sm datetimepicker" id="txttanggalskBHmenkumNPYP" value="" type="text" placeholder="Tanggal SK Pengesahan Badan Hukum Menkumham" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttanggalskBHmenkumNPYP">Tanggal SK Pengesahan Badan Hukum Menkumham</label>
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
                <input type="text" class="form-control form-control-sm" id="txtlonlatNPYP" value="" maxlength="100" placeholder="Lokasi" autocomplete="off">
                <label for="txtlonlatNPYP">Lokasi</label>
            </div>

            <div class="form-floating mb-1">
                <input type="number" class="form-control form-control-sm" id="txtnowaNPYP" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                <label for="txtnowaNPYP">No. HP WhatsApp (WA) Aktif</label>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanNPYP">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        $("#txtnmyayasan").val("");
        $("#txtnmpimpinan").val("");

        $("#cboprovinsiNPYP").val("");
        $("#txtprovinsiNPYP").val("");
        $("#cbokabupatenNPYP").val("");
        $("#txtkabupatenNPYP").val("");
        $("#cbokecamatanNPYP").val("");
        $("#txtkecamatanNPYP").val("");
        $("#cbodesaNPYP").val("");
        $("#txtdesaNPYP").val("");

        $("#txtdusunNPYP").val("");
        $("#txtalamatNPYP").val("");

        $("#txtRTNPYP").val("");
        $("#txtRWNPYP").val("");
        $("#txtposcodeNPYP").val("");
        $("#txtteleponNPYP").val("");
        $("#txtFaxNPYP").val("");
        $("#txtemailNPYP").val("");
        $("#txtWebsiteNPYP").val("");

        $("#txtnopendirianNPYP").val("");
        $("#txttglpendirianNPYP").val("");
        $("#txtnopengesahanpnNPYP").val("");

        $("#txtnoskBHmenkumNPYP").val("");
        $("#txttanggalskBHmenkumNPYP").val("");

        $("#txtlonlatNPYP").val("");
        $("#txtnowaNPYP").val("");
    });

    $("#cboprovinsiNPYP").on("change", function() {
        $("#txtprovinsiNPYP").val("");
        $("#cbokabupatenNPYP").val("");
        $("#txtkabupatenNPYP").val("");
        $("#cbokecamatanNPYP").val("");
        $("#txtkecamatanNPYP").val("");
        $("#cbodesaNPYP").val("");
        $("#txtdesaNPYP").val("");
        var kdpropinsi = $("#cboprovinsiNPYP").val();
        var nmprovinsi = $("#cboprovinsiNPYP :selected").text();
        $("#txtprovinsiNPYP").val(nmprovinsi);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_kota.php",
            data: {
                kdpropinsi: kdpropinsi
            },
            success: function(resp) {
                $("#cbokabupatenNPYP").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokabupatenNPYP").on("change", function() {
        $("#txtkabupatenNPYP").val("");
        $("#cbokecamatanNPYP").val("");
        $("#txtkecamatanNPYP").val("");
        $("#cbodesaNPYP").val("");
        $("#txtdesaNPYP").val("");
        var kdkota = $("#cbokabupatenNPYP").val();
        var nmkota = $("#cbokabupatenNPYP :selected").text();
        $("#txtkabupatenNPYP").val(nmkota);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_kecamatan.php",
            data: {
                kdkota: kdkota
            },
            success: function(resp) {
                $("#cbokecamatanNPYP").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbokecamatanNPYP").on("change", function() {
        $("#txtkecamatanNPYP").val("");
        $("#cbodesaNPYP").val("");
        $("#txtdesaNPYP").val("");
        var kdkecamatan = $("#cbokecamatanNPYP").val();
        var nmkecamatan = $("#cbokecamatanNPYP :selected").text();
        $("#txtkecamatanNPYP").val(nmkecamatan);
        $.ajax({
            type: "POST",
            url: "klinik-dapo/ambil_desa.php",
            data: {
                kdkecamatan: kdkecamatan
            },
            success: function(resp) {
                $("#cbodesaNPYP").html(resp);
            },
            error: function() {
                console.log('Ajax Bermasalah !!!')
            },
        });
    });

    $("#cbodesaNPYP").on("change", function() {
        $("#txtdesaNPYP").val("");
        var nmdesa = $("#cbodesaNPYP :selected").text();
        $("#txtdesaNPYP").val(nmdesa);
    });

    $("#cmdsimpanNPYP").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var idlayanan = "8";

        var nmyayasan = $("#txtnmyayasan").val();
        var nmpimpinan = $("#txtnmpimpinan").val();

        var propinsi = $("#txtprovinsiNPYP").val();
        var kota = $("#txtkabupatenNPYP").val();
        var kecamatan = $("#txtkecamatanNPYP").val();
        var desa = $("#txtdesaNPYP").val();
        var idpropinsi = $("#cboprovinsiNPYP").val();
        var idkota = $("#cbokabupatenNPYP").val();
        var idkecamatan = $("#cbokecamatanNPYP").val();
        var iddesa = $("#cbodesaNPYP").val();

        var dusun = $("#txtdusunNPYP").val();
        var alamat = $("#txtalamatNPYP").val();
        var rt = $("#txtRTNPYP").val();
        var rw = $("#txtRWNPYP").val();
        var kodepos = $("#txtposcodeNPYP").val();
        var telepon = $("#txtteleponNPYP").val();
        var fax = $("#txtFaxNPYP").val();
        var email = $("#txtemailNPYP").val();
        var website = $("#txtWebsiteNPYP").val();

        var nopendirian = $("#txtnopendirianNPYP").val();
        var tglpendirian = $("#txttglpendirianNPYP").val();
        var nopengesahanpn = $("#txtnopengesahanpnNPYP").val();

        var noskBH = $("#txtnoskBHmenkumNPYP").val();
        var tglskBH = $("#txttanggalskBHmenkumNPYP").val();

        var lokasi = $("#txtlonlatNPYP").val();
        var noWA = $("#txtnowaNPYP").val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

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

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmyayasan.length <= 0) {
            $("#txtnmyayasan").focus();
            alert("Nama yayasan masih kosong")
        } else if (nmpimpinan.length <= 0) {
            $("#txtnmpimpinan").focus();
            alert("Nama pimpinan yayasan masih kosong")

        } else if (propinsi.length <= 0) {
            $("#cboprovinsiNPYP").focus();
            alert("Provinsi masih kosong")
        } else if (kota.length <= 0) {
            $("#cbokabupatenNPYP").focus();
            alert("Kota/kabupaten masih kosong")
        } else if (kecamatan.length <= 0) {
            $("#cbokecamatanNPYP").focus();
            alert("Kecamatan masih kosong")
        } else if (desa.length <= 0) {
            $("#cbodesaNPYP").focus();
            alert("Kelurahan/desa masih kosong")

        } else if (dusun.length <= 0) {
            $("#txtdusunNPYP").focus();
            alert("Dusun masih kosong")
        } else if (alamat.length <= 0) {
            $("#txtalamatNPYP").focus();
            alert("Alamat masih kosong")
        } else if (rt.length <= 0) {
            $("#txtRTNPYP").focus();
            alert("RT masih kosong")
        } else if (rw.length <= 0) {
            $("#txtRWNPYP").focus();
            alert("RW masih kosong")
        } else if (kodepos.length <= 0) {
            $("#txtposcodeNPYP").focus();
            alert("Kode pos masih kosong")
        } else if (telepon.length <= 0) {
            $("#txtteleponNPYP").focus();
            alert("No. telepon masih kosong")
        } else if (fax.length <= 0) {
            $("#txtFaxNPYP").focus();
            alert("No. Faximile masih kosong")
        } else if (email.length <= 0) {
            $("#txtemailNPYP").focus();
            alert("Email masih kosong")
        } else if (website.length <= 0) {
            $("#txtWebsiteNPYP").focus();
            alert("Website masih kosong")

        } else if (nopendirian.length <= 0) {
            $("#txtnopendirianNPYP").focus();
            alert("No. Pendirian masih kosong")
        } else if (tglpendirian.length <= 0) {
            $("#txttglpendirianNPYP").focus();
            alert("Tanggal pendirian masih kosong")
        } else if (nopengesahanpn.length <= 0) {
            $("#txtnopengesahanpnNPYP").focus();
            alert("No. SK pengesahan PN masih kosong")
        } else if (noskBH.length <= 0) {
            $("#txtnoskBHmenkumNPYP").focus();
            alert("No. SK badan hukum kemenkumham masih kosong")
        } else if (tglskBH.length <= 0) {
            $("#txttanggalskBHmenkumNPYP").focus();
            alert("Tanggal SK badan hukum kemenkumham masih kosong")

        } else if (lokasi.length <= 0) {
            $("#txtlonlatNPYP").focus();
            alert("Lintang bujur lokasi masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaNPYP").focus();
            alert("No. HP whatsApp masih kosong")

        } else {
            var urlnya = "klinik-dapo/trans-layanan/pengajuan-npyp/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanNPYP").attr("disabled", "disabled");
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
                        $("#cmdsimpanNPYP").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanNPYP").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanNPYP").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>