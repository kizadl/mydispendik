<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idlayanan = trim($_POST['idlayanan']);

$qrilay = ("SELECT layanan,awal_no_surat,no_urut,akhir_no_surat FROM tte_m_layanan WHERE id_layanan='" . $idlayanan . "'");
$dblayanan = mysqli_query($dbconn, $qrilay);
$d = mysqli_fetch_assoc($dblayanan);
$layanan = $d['layanan'];
$nourut = $d['no_urut'] + 1;
$nosurat = $d['awal_no_surat'] . $nourut . $d['akhir_no_surat'];
mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Input Data Layanan <?php echo $layanan ?></h5>
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
                        Isi dan lengkapi form isian data <strong><?php echo $layanan ?></strong> :<br>
                        1. Data Siswa<br />
                        2. Data Sekolah Mutasi Siswa<br />
                        3. Data Surat Keterangan Pindah Sekolah<br />
                        4. Data Surat Keterangan Sanggup Menerima Mutasi Siswa<br />
                        5. Data Surat Rekomendasi Mutasi Siswa (** Opsional ** Tidak Wajib **)<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3" hidden>
        <input class="form-control form-control-sm datetimepicker" id="txttglsuratMS" value="" type="text" placeholder="Tanggal surat rekomendasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' disabled />
        <label for="txttglsuratMS">Tanggal Surat Rekomendasi</label>
    </div>

    <div class="form-floating mb-3" hidden>
        <input type="text" class="form-control form-control-sm bg-white" id="txtnosuratMS" value="<?php echo $nosurat ?>" placeholder="Nomor surat rekomendasi" maxlength="50" autocomplete="off" disabled>
        <label for="txtnosuratMS">Nomor Surat Rekomendasi</label>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">1. Data Siswa</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmsiswaMS" value="" maxlength="100" placeholder="Nama siswa" autocomplete="off">
                    <label for="txtnmsiswaMS">Nama Siswa</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtniksiswaMS" value="" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtniksiswaMS">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnissiswaMS" value="" maxlength="25" placeholder="NIS siswa" autocomplete="off">
                    <label for="txtnissiswaMS">NIS</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtkelassiswaMS" value="" maxlength="25" placeholder="Kelas" autocomplete="off">
                    <label for="txtkelassiswaMS">Kelas</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txttmplahirMS" value="" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
                    <label for="txttmplahirMS">Tempat Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control form-control-sm datetimepicker" id="txttgllahirMS" value="" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttgllahirMS">Tanggal Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojkMS" id="cbojkMS" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Jenis kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <label for="cbojkMS">Jenis Kelamin</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboagamaMS" id="cboagamaMS" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Agama</option>
                        <option value="ISLAM">Islam</option>
                        <option value="KRISTEN">Kristen</option>
                        <option value="KATHOLIK">Katholik</option>
                        <option value="HINDU">Hindu</option>
                        <option value="BUDHA">Budha</option>
                        <option value="KHONGHUCU">Khonghucu</option>
                        <option value="KEPERCAYAAN">Kepercayaan</option>
                    </select>
                    <label for="cboagamaMS">Pilih Agama</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmortuMS" value="" maxlength="100" placeholder="Nama orang tua" autocomplete="off">
                    <label for="txtnmortuMS">Nama Orang Tua</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtpekerjaanortuMS" value="" maxlength="50" placeholder="Pekerjaan orang tua" autocomplete="off">
                    <label for="txtpekerjaanortuMS">Pekerjaan Orang Tua</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaMS" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaMS">No. HP WhatsApp (WA) Aktif</label>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">2. Data Sekolah Mutasi Siswa</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtsekolahasalMS" value="" maxlength="200" placeholder="Sekolah asal" autocomplete="off">
                <label for="txtsekolahasalMS">Sekolah Asal</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsnasalMS" value="" maxlength="50" placeholder="NPSN Sekolah Asal" autocomplete="off">
                <label for="txtnpsnasalMS">NPSN Sekolah Asal</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnmsekolahmutasiMS" value="" maxlength="200" placeholder="Mutasi Ke Sekolah" autocomplete="off">
                <label for="txtnmsekolahmutasiMS">Mutasi Ke Sekolah</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsnmutasiMS" value="" maxlength="50" placeholder="NPSN Sekolah Mutasi" autocomplete="off">
                <label for="txtnpsnmutasiMS">NPSN Sekolah Mutasi</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtalasanmutasiMS" value="" maxlength="100" placeholder="Alasan Mutasi" autocomplete="off">
                <label for="txtalasanmutasiMS">Alasan Mutasi</label>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">3. Data Surat Keterangan Pindah Sekolah</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnosuketpindahMS" value="" maxlength="50" placeholder="Nomor Surat" autocomplete="off">
                <label for="txtnosuketpindahMS">Nomor Surat</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglsuketpindahMS" value="" type="text" placeholder="Tanggal Surat" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsuketpindahMS">Tanggal Surat</label>
            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">4. Data Surat Keterangan Sanggup Menerima Mutasi Siswa</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnosuketsanggupMS" value="" maxlength="50" placeholder="Nomor Surat" autocomplete="off">
                <label for="txtnosuketsanggupMS">Nomor Surat</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglsuketsanggupMS" value="" type="text" placeholder="Tanggal Surat" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsuketsanggupMS">Tanggal Surat</label>
            </div>

        </div>
    </div>

    <div class="card mb-1">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">5. Data Surat Rekomendasi Mutasi Siswa <code>(** Opsional ** Tidak Wajib **)</code></h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

             <input type="text" id="lblchkrekomMS" value="" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkrekomendasimutasisiswa" type="checkbox" />
                <label class="form-check-label" for="chkrekomendasimutasisiswa">Surat Rekomendasi</label>
            </div>
            <div id="area-rekomendasi-mutasi-siswa" style="display:none">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtrekomdariMS" value="" maxlength="100" placeholder="Rekomendasi dari" autocomplete="off">
                    <label for="txtrekomdariMS">Rekomendasi Dari</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnorekomMS" value="" maxlength="50" placeholder="Nomor Surat" autocomplete="off">
                    <label for="txtnorekomMS">Nomor Surat</label>
                </div>

                <div class="form-floating mb-2">
                    <input class="form-control form-control-sm datetimepicker" id="txttglrekomMS" value="" type="text" placeholder="Tanggal rekomendasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttglrekomMS">Tanggal Surat</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanMutasiSiswa">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        var tglserver = $("#lbltglserver").val();
        arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
            "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
        ];
        mydate = new Date(tglserver);

        tanggal = mydate.getDate();
        bulan = mydate.getMonth();
        tahun = mydate.getFullYear();

        $("#txttglsuratMS").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
        $("#lblchkrekomMS").val("tidak ada");

    });

    $("#chkrekomendasimutasisiswa").on("change", function() {
        if ($(this).is(':checked')) {
            $("#lblchkrekomMS").val("ada");
            $("#area-rekomendasi-mutasi-siswa").fadeIn();
        } else {
            $("#lblchkrekomMS").val("tidak ada");
            $("#area-rekomendasi-mutasi-siswa").fadeOut("slow");
        }
    });

    $("#cmdsimpanMutasiSiswa").click(function() {

        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
        var idlayanan = "1";

        var tglsurat = $("#txttglsuratMS").val();
        var nosurat = $("#txtnosuratMS").val();

        var nmsiswa = $("#txtnmsiswaMS").val();
        var nik = $("#txtniksiswaMS").val();
        var nis = $("#txtnissiswaMS").val();
        var kelas = $("#txtkelassiswaMS").val();
        var tmplahir = $("#txttmplahirMS").val();
        var tgllahir = $("#txttgllahirMS").val();
        var kelamin = $("#cbojkMS").val();
        var agama = $("#cboagamaMS").val()
        var nmortu = $("#txtnmortuMS").val();
        var pekerjaanortu = $("#txtpekerjaanortuMS").val();
        var noWA = $("#txtnowaMS").val();

        var nmsekolahasal = $("#txtsekolahasalMS").val();
        var npsnasal = $("#txtnpsnasalMS").val();
        var nmsekolahmutasi = $("#txtnmsekolahmutasiMS").val();
        var npsnmutasi = $("#txtnpsnmutasiMS").val();
        var alasanmutasi = $("#txtalasanmutasiMS").val();

        var nosuketpindah = $('#txtnosuketpindahMS').val();
        var tglsuketpindah = $('#txttglsuketpindahMS').val();

        var nosuketsanggup = $('#txtnosuketsanggupMS').val();
        var tglsuketsanggup = $('#txttglsuketsanggupMS').val();
      
        var ketrekom = $('#lblchkrekomMS').val();
        var rekomdari = $('#txtrekomdariMS').val();
        var norekom = $('#txtnorekomMS').val();
        var tglrekom = $('#txttglrekomMS').val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

        data.append('tglsurat', tglsurat);
        data.append('nosurat', nosurat);

        data.append('nmsiswa', nmsiswa);
        data.append('nik', nik);
        data.append('nis', nis);
        data.append('kelas', kelas);
        data.append('tmplahir', tmplahir);
        data.append('tgllahir', tgllahir);
        data.append('kelamin', kelamin);
        data.append('agama', agama);
        data.append('nmortu', nmortu);
        data.append('pekerjaanortu', pekerjaanortu);
        data.append('noWA', noWA);

        data.append('nmsekolahasal', nmsekolahasal);
        data.append('npsnasal', npsnasal);
        data.append('nmsekolahmutasi', nmsekolahmutasi);
        data.append('npsnmutasi', npsnmutasi);
        data.append('alasanmutasi', alasanmutasi);

        data.append('nosuketpindah', nosuketpindah);
        data.append('tglsuketpindah', tglsuketpindah);

        data.append('nosuketsanggup', nosuketsanggup);
        data.append('tglsuketsanggup', tglsuketsanggup);

        data.append('ketrekom', ketrekom);
        data.append('rekomdari', rekomdari);
        data.append('norekom', norekom);
        data.append('tglrekom', tglrekom);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (tglsurat.length <= 0) {
            alert("Tanggal surat tidak terdeteksi")
        } else if (nosurat.length <= 0) {
            alert("Nomor surat tidak terdeteksi")

        } else if (nmsiswa.length <= 0) {
            $("#txtnmsiswaMS").focus();
            alert("Nama siswa masih kosong")
        } else if (nik.length <= 0) {
            $("#txtniksiswaMS").focus();
            alert("NIK siswa masih kosong")
        } else if (nis.length <= 0) {
            $("#txtnissiswaMS").focus();
            alert("NIS siswa masih kosong")
        } else if (kelas.length <= 0) {
            $("#txtkelassiswaMS").focus();
            alert("Kelas siswa masih kosong")
        } else if (tmplahir.length <= 0) {
            $("#txttmplahirMS").focus();
            alert("Tempat lahir masih kosong")
        } else if (tgllahir.length <= 0) {
            $("#txttgllahirMS").focus();
            alert("Tanggal lahir masih kosong")
        } else if (kelamin.length <= 0) {
            $("#cbojkMS").focus();
            alert("Jenis kelamin masih kosong")
        } else if (agama.length <= 0) {
            $("#cboagamaMS").focus();
            alert("Agama masih kosong")
        } else if (nmortu.length <= 0) {
            $("#txtnmortuMS").focus();
            alert("Nama orang tua masih kosong")
        } else if (pekerjaanortu.length <= 0) {
            $("#txtpekerjaanortuMS").focus();
            alert("Pekerjaan orang tua masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaMS").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (nmsekolahasal.length <= 0) {
            $("#txtsekolahasalMS").focus();
            alert("Nama sekolah asal masih kosong")
        } else if (npsnasal.length <= 0) {
            $("#txtnpsnasalMS").focus();
            alert("NPSN sekolah asal masih kosong")
        } else if (nmsekolahmutasi.length <= 0) {
            $("#txtnmsekolahmutasiMS").focus();
            alert("Nama sekolah mutasi masih kosong")
        } else if (npsnmutasi.length <= 0) {
            $("#txtnpsnmutasiMS").focus();
            alert("NPSN sekolah mutasi masih kosong")
        } else if (alasanmutasi.length <= 0) {
            $("#txtalasanmutasiMS").focus();
            alert("Alasan mutasi masih kosong")

        } else if (nosuketpindah.length <= 0) {
            $("#txtnosuketpindahMS").focus();
            alert("Nomor surat keterangan pindah masih kosong")
        } else if (tglsuketpindah.length <= 0) {
            $("#txttglsuketpindahMS").focus();
            alert("Tanggal surat keterangan pindah masih kosong")
        } else if (nosuketsanggup.length <= 0) {
            $("#txtnosuketsanggupMS").focus();
            alert("Nomor surat keterangan sanggup menerima siswa masih kosong")
        } else if (tglsuketsanggup.length <= 0) {
            $("#txttglsuketsanggupMS").focus();
            alert("Tanggal surat keterangan sanggup menerima siswa masih kosong")
        } else if (ketrekom == "ada" && rekomdari == "") {
            $("#txtrekomdariMS").focus();
            alert("Rekomendasi dari masih kosong")
        } else if (ketrekom == "ada" && norekom == "") {
            $("#txtnorekomMS").focus();
            alert("Nomor rekomendasi masih kosong")
        } else if (ketrekom == "ada" && tglrekom == "") {
            $("#txttglrekomMS").focus();
            alert("Tanggal rekomendasi masih kosong")
        } else {

            var urlnya = "aksi/trans-layanan/mutasi-siswa/aksi_tambah.php";

            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanMutasiSiswa").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMutasiSiswa();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanMutasiSiswa").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanMutasiSiswa").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanMutasiSiswa").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>