<?php
error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idlayanan = trim($_POST['idlayanan']);
$idtransaksi = trim($_POST['idtransaksi']);

$sqlx = ("SELECT * FROM tte_trans_mutasi_siswa p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$nosurat = $sm['no_surat'];
$nowa = $sm['no_wa'];
$tglsurat = $sm['tgl_surat'];$tglsurat = date('d-m-Y', strtotime($tglsurat));
$namasiswa = ucwords(strtolower($sm['nama_siswa']));
$kelamin = $sm['kelamin'];
$tempatlahir = ucwords(strtolower($sm['tempat_lahir']));
$tgllahir = $sm['tgl_lahir'];$tgllahir = date('d-m-Y', strtotime($tgllahir));
$agama = $sm['agama'];
$namaortu = ucwords(strtolower($sm['nama_ortu']));
$pekerjaanortu = ucwords(strtolower($sm['pekerjaan_ortu']));
$nowa = $sm['no_wa'];
$kelas = strtoupper($sm['kelas']);
$nik = $sm['nik'];
$nis = $sm['nis'];

$asalsekolah = strtoupper($sm['asal_sekolah']);
$npsnasal = strtoupper($sm['npsn_asal_sekolah']);
$mutasike = strtoupper($sm['mutasi_ke']);
$npsnmutasi = strtoupper($sm['npsn_mutasi']);
$alasanmutasi = ucwords(strtolower($sm['alasan_mutasi']));

$nosuketmutasi = strtoupper($sm['no_suket_mutasi']);
$tglsuketmutasi = $sm['tgl_suket_mutasi'];$tglsuketmutasi = date('d-m-Y', strtotime($tglsuketmutasi));
$nosuketpindah = strtoupper($sm['no_suket_pindah']);
$tglsuketpindah = $sm['tgl_suket_pindah'];$tglsuketpindah = date('d-m-Y', strtotime($tglsuketpindah));

$filerekom = $sm['file_rekomendasi'];
if ($filerekom == "ada"){
    $hidrekom = ""; $chkrekomval = "checked";
    $rekomendasi = ucwords(strtolower($sm['rekomendasi']));
    $norekomendasi = strtoupper($sm['no_rekomendasi']);
    $tglrekomendasi = $sm['tgl_rekomendasi'];
    $tglrekomendasi = date('d-m-Y', strtotime($tglrekomendasi));
} else if ($filerekom == "tidak"){
    $hidrekom = "display:none"; $chkrekomval = "";
    $rekomendasi ="";
    $norekomendasi = "";
    $tglrekomendasi = "";
}

mysqli_free_result($restps);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data Layanan Mutasi Siswa</h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi edit data mutasi siswa</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Mutasi Siswa</strong> :<br>
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

    <input type="text" class="form-control form-control-sm" id="txtidtransaksimutsiswaE" value="<?php echo $idtransaksi ?>" hidden>
    <input type="text" class="form-control form-control-sm" id="txtidlayananmutsiswaE" value="<?php echo $idlayanan ?>" hidden>

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker bg-white" id="txttglsuratMSE" value="<?php echo $tglsurat ?>" type="text" placeholder="Tanggal surat rekomendasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' disabled />
        <label for="txttglsuratMSE">Tanggal Surat Rekomendasi</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm bg-white" id="txtnosuratMSE" value="<?php echo $nosurat ?>" placeholder="Nomor surat rekomendasi" maxlength="50" autocomplete="off" disabled>
        <label for="txtnosuratMSE">Nomor Surat Rekomendasi</label>
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
                    <input type="text" class="form-control form-control-sm" id="txtnmsiswaMSE" value="<?php echo $namasiswa ?>" maxlength="100" placeholder="Nama siswa" autocomplete="off">
                    <label for="txtnmsiswaMSE">Nama Siswa</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtniksiswaMSE" value="<?php echo $nik ?>" maxlength="20" placeholder="NIK siswa" autocomplete="off">
                    <label for="txtniksiswaMSE">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnissiswaMSE" value="<?php echo $nis ?>" maxlength="25" placeholder="NIS siswa" autocomplete="off">
                    <label for="txtnissiswaMSE">NIS</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtkelassiswaMSE" value="<?php echo $kelas ?>" maxlength="25" placeholder="Kelas" autocomplete="off">
                    <label for="txtkelassiswaMSE">Kelas</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txttmplahirMSE" value="<?php echo $tempatlahir ?>" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
                    <label for="txttmplahirMSE">Tempat Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control form-control-sm datetimepicker" id="txttgllahirMSE" value="<?php echo $tgllahir ?>" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttgllahirMSE">Tanggal Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojkMSE" id="cbojkMSE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                    <label for="cbojkMSE">Jenis Kelamin</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboagamaMSE" id="cboagamaMSE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                    <label for="cboagamaMSE">Pilih Agama</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmortuMSE" value="<?php echo $namaortu ?>" maxlength="100" placeholder="Nama orang tua" autocomplete="off">
                    <label for="txtnmortuMSE">Nama Orang Tua</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtpekerjaanortuMSE" value="<?php echo $pekerjaanortu ?>" maxlength="50" placeholder="Pekerjaan orang tua" autocomplete="off">
                    <label for="txtpekerjaanortuMSE">Pekerjaan Orang Tua</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaMSE" value="<?php echo $nowa ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaMSE">No. HP WhatsApp (WA) Aktif</label>
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
                <input type="text" class="form-control form-control-sm" id="txtsekolahasalMSE" value="<?php echo $asalsekolah ?>" maxlength="200" placeholder="Sekolah asal" autocomplete="off">
                <label for="txtsekolahasalMSE">Sekolah Asal</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsnasalMSE" value="<?php echo $npsnasal ?>" maxlength="50" placeholder="NPSN Sekolah Asal" autocomplete="off">
                <label for="txtnpsnasalMSE">NPSN Sekolah Asal</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnmsekolahmutasiMSE" value="<?php echo $mutasike ?>" maxlength="200" placeholder="Mutasi Ke Sekolah" autocomplete="off">
                <label for="txtnmsekolahmutasiMSE">Mutasi Ke Sekolah</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsnmutasiMSE" value="<?php echo $npsnmutasi ?>" maxlength="50" placeholder="NPSN Sekolah Mutasi" autocomplete="off">
                <label for="txtnpsnmutasiMSE">NPSN Sekolah Mutasi</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtalasanmutasiMSE" value="<?php echo $alasanmutasi ?>" maxlength="100" placeholder="Alasan Mutasi" autocomplete="off">
                <label for="txtalasanmutasiMSE">Alasan Mutasi</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnosuketpindahMSE" value="<?php echo $nosuketpindah ?>" maxlength="50" placeholder="Nomor Surat" autocomplete="off">
                <label for="txtnosuketpindahMSE">Nomor Surat</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglsuketpindahMSE" value="<?php echo $tglsuketpindah ?>" type="text" placeholder="Tanggal Surat" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsuketpindahMSE">Tanggal Surat</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnosuketsanggupMSE" value="<?php echo $nosuketmutasi ?>" maxlength="50" placeholder="Nomor Surat" autocomplete="off">
                <label for="txtnosuketsanggupMSE">Nomor Surat</label>
            </div>

            <div class="form-floating mb-2">
                <input class="form-control form-control-sm datetimepicker" id="txttglsuketsanggupMSE" value="<?php echo $tglsuketmutasi ?>" type="text" placeholder="Tanggal Surat" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsuketsanggupMSE">Tanggal Surat</label>
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

            <input type="text" id="lblchkrekomMSE" value="" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkrekomendasimutasisiswaE" type="checkbox" <?php echo $chkrekomval ?> />
                <label class="form-check-label" for="chkrekomendasimutasisiswaE">Surat Rekomendasi</label>
            </div>
            <div id="area-rekomendasi-mutasi-siswa-edit" style="<?php echo $hidrekom ?>">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtrekomdariMSE" value="<?php echo $rekomendasi ?>" maxlength="100" placeholder="Rekomendasi dari" autocomplete="off">
                    <label for="txtrekomdariMSE">Rekomendasi Dari</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnorekomMSE" value="<?php echo $norekomendasi ?>" maxlength="50" placeholder="Nomor Surat" autocomplete="off">
                    <label for="txtnorekomMSE">Nomor Surat</label>
                </div>

                <div class="form-floating mb-2">
                    <input class="form-control form-control-sm datetimepicker" id="txttglrekomMSE" value="<?php echo $tglrekomendasi ?>" type="text" placeholder="Tanggal rekomendasi" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttglrekomMSE">Tanggal Surat</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanMutasiSiswaE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">

    $("#chkrekomendasimutasisiswaE").on("change", function() {
        if ($(this).is(':checked')) {
            $("#lblchkrekomMSE").val("ada");
            $("#area-rekomendasi-mutasi-siswa-edit").fadeIn();
        } else {
            $("#lblchkrekomMSE").val("tidak ada");
            $("#area-rekomendasi-mutasi-siswa-edit").fadeOut("slow");
        }
    });

    $("#cmdsimpanMutasiSiswaE").click(function() {

        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidinstansi").val();
        
        var idlayanan = $("#txtidlayananmutsiswaE").val();
        var idtransaksi = $("#txtidtransaksimutsiswaE").val();

        var tglsurat = $("#txttglsuratMSE").val();
        var nosurat = $("#txtnosuratMSE").val();

        var nmsiswa = $("#txtnmsiswaMSE").val();
        var nik = $("#txtniksiswaMSE").val();
        var nis = $("#txtnissiswaMSE").val();
        var kelas = $("#txtkelassiswaMSE").val();
        var tmplahir = $("#txttmplahirMSE").val();
        var tgllahir = $("#txttgllahirMSE").val();
        var kelamin = $("#cbojkMSE").val();
        var agama = $("#cboagamaMSE").val()
        var nmortu = $("#txtnmortuMSE").val();
        var pekerjaanortu = $("#txtpekerjaanortuMSE").val();
        var noWA = $("#txtnowaMSE").val();

        var nmsekolahasal = $("#txtsekolahasalMSE").val();
        var npsnasal = $("#txtnpsnasalMSE").val();
        var nmsekolahmutasi = $("#txtnmsekolahmutasiMSE").val();
        var npsnmutasi = $("#txtnpsnmutasiMSE").val();
        var alasanmutasi = $("#txtalasanmutasiMSE").val();

        var nosuketpindah = $('#txtnosuketpindahMSE').val();
        var tglsuketpindah = $('#txttglsuketpindahMSE').val();

        var nosuketsanggup = $('#txtnosuketsanggupMSE').val();
        var tglsuketsanggup = $('#txttglsuketsanggupMSE').val();

        var ketrekom = $('#lblchkrekomMSE').val();
        var rekomdari = $('#txtrekomdariMSE').val();
        var norekom = $('#txtnorekomMSE').val();
        var tglrekom = $('#txttglrekomMSE').val();

        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idtransaksi', idtransaksi);
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

        if (idtransaksi.length <= 0) {
            alert("Mutasi siswa tidak terdeteksi")
        } else if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (tglsurat.length <= 0) {
            alert("Tanggal surat tidak terdeteksi")
        } else if (nosurat.length <= 0) {
            alert("Nomor surat tidak terdeteksi")

        } else if (nmsiswa.length <= 0) {
            $("#txtnmsiswaMSE").focus();
            alert("Nama siswa masih kosong")
        } else if (nik.length <= 0) {
            $("#txtniksiswaMSE").focus();
            alert("NIK siswa masih kosong")
        } else if (nis.length <= 0) {
            $("#txtnissiswaMSE").focus();
            alert("NIS siswa masih kosong")
        } else if (kelas.length <= 0) {
            $("#txtkelassiswaMSE").focus();
            alert("Kelas siswa masih kosong")
        } else if (tmplahir.length <= 0) {
            $("#txttmplahirMSE").focus();
            alert("Tempat lahir masih kosong")
        } else if (tgllahir.length <= 0) {
            $("#txttgllahirMSE").focus();
            alert("Tanggal lahir masih kosong")
        } else if (kelamin.length <= 0) {
            $("#cbojkMSE").focus();
            alert("Jenis kelamin masih kosong")
        } else if (agama.length <= 0) {
            $("#cboagamaMSE").focus();
            alert("Agama masih kosong")
        } else if (nmortu.length <= 0) {
            $("#txtnmortuMSE").focus();
            alert("Nama orang tua masih kosong")
        } else if (pekerjaanortu.length <= 0) {
            $("#txtpekerjaanortuMSE").focus();
            alert("Pekerjaan orang tua masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaMSE").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (nmsekolahasal.length <= 0) {
            $("#txtsekolahasalMSE").focus();
            alert("Nama sekolah asal masih kosong")
        } else if (npsnasal.length <= 0) {
            $("#txtnpsnasalMSE").focus();
            alert("NPSN sekolah asal masih kosong")
        } else if (nmsekolahmutasi.length <= 0) {
            $("#txtnmsekolahmutasiMSE").focus();
            alert("Nama sekolah mutasi masih kosong")
        } else if (npsnmutasi.length <= 0) {
            $("#txtnpsnmutasiMSE").focus();
            alert("NPSN sekolah mutasi masih kosong")
        } else if (alasanmutasi.length <= 0) {
            $("#txtalasanmutasiMSE").focus();
            alert("Alasan mutasi masih kosong")

        } else if (nosuketpindah.length <= 0) {
            $("#txtnosuketpindahMSE").focus();
            alert("Nomor surat keterangan pindah masih kosong")
        } else if (tglsuketpindah.length <= 0) {
            $("#txttglsuketpindahMSE").focus();
            alert("Tanggal surat keterangan pindah masih kosong")
        } else if (nosuketsanggup.length <= 0) {
            $("#txtnosuketsanggupMSE").focus();
            alert("Nomor surat keterangan sanggup menerima siswa masih kosong")
        } else if (tglsuketsanggup.length <= 0) {
            $("#txttglsuketsanggupMSE").focus();
            alert("Tanggal surat keterangan sanggup menerima siswa masih kosong")
        } else if (ketrekom == "ada" && rekomdari == "") {
            $("#txtrekomdariMSE").focus();
            alert("Rekomendasi dari masih kosong")
        } else if (ketrekom == "ada" && norekom == "") {
            $("#txtnorekomMSE").focus();
            alert("Nomor rekomendasi masih kosong")
        } else if (ketrekom == "ada" && tglrekom == "") {
            $("#txttglrekomMSE").focus();
            alert("Tanggal rekomendasi masih kosong")
        } else {

            var urlnya = "aksi/trans-layanan/mutasi-siswa/aksi_edit.php";

            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanMutasiSiswaE").attr("disabled", "disabled");
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
                        $("#cmdsimpanMutasiSiswaE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanMutasiSiswaE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanMutasiSiswaE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>