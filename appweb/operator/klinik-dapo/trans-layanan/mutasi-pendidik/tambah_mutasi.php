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
                        (Data Pendidik / Tenaga Pendidik, Data Pengangkatan, Data Sekolah Tempat Tugas, Data Surat Tugas dan Data Ijazah).
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
                    <h5 class="mb-0 fs--1">Data Pendidik / Tenaga Pendidik</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 justify-content-between mt-3 px-card pb-3">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmpendidikmutasi" value="" maxlength="100" placeholder="Nama lengkap" autocomplete="off">
                    <label for="txtnmpendidikmutasi">Nama Lengkap</label>
                </div>
               
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboSttsKepegawaian" id="cboSttsKepegawaian" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Status Kepegawaian</option>
                        <?php
                        $sqlsttspeg = ("SELECT id_status,status_kepegawaian FROM tte_m_status_kepegawaian ORDER BY id_status ASC");
                        $resultsttspeg = mysqli_query($dbconn, $sqlsttspeg);
                        while ($sp = mysqli_fetch_array($resultsttspeg)) {
                            $idstatus = $sp['id_status'];
                            $statuskepegawaian = $sp['status_kepegawaian'];
                            echo "
                                        <option value='$idstatus'>$statuskepegawaian</option>";
                        }
                        mysqli_free_result($resultsttspeg);
                        ?>
                    </select>
                    <label for="cboSttsKepegawaian">Status Kepegawaian</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtnikmutasi" value="" maxlength="20" placeholder="NIK" autocomplete="off">
                    <label for="txtnikmutasi">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnipmutasi" value="" maxlength="35" placeholder="NIP" autocomplete="off">
                    <label for="txtnipmutasi">NIP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnuptkmutasi" value="" maxlength="35" placeholder="NUPTK" autocomplete="off">
                    <label for="txtnuptkmutasi">NUPTK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txttmplahirMutasi" value="" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
                    <label for="txttmplahirMutasi">Tempat Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control form-control-sm datetimepicker" id="txttgllahirMutasi" value="" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttgllahirMutasi">Tanggal Lahir</label>
                </div>
               
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojkMutasi" id="cbojkMutasi" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Jenis kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <label for="cbojkMutasi">Jenis Kelamin</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmibukandungmutasi" value="" maxlength="100" placeholder="Nama ibu kandung" autocomplete="off">
                    <label for="txtnmibukandungmutasi">Nama Ibu Kandung</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaMutasi" value="" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaMutasi">No. HP WhatsApp (WA) Aktif</label>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Pengangkatan</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnoskpengangkatanmutasi" value="" maxlength="50" placeholder="SK Pengangkatan" autocomplete="off">
                <label for="txtnoskpengangkatanmutasi">No. SK Pengangkatan</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttmtpengangkatan" value="" type="text" placeholder="TMT Pengangkatan" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttmtpengangkatan">TMT Pengangkatan</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cboLembagaPengangkat" id="cboLembagaPengangkat" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Lembaga Pengangkat</option>
                    <?php
                    $sqllembaga = ("SELECT id_lembaga,lembaga_pangangkat FROM tte_m_lembaga_pengangkat ORDER BY id_lembaga ASC");
                    $resultlembaga = mysqli_query($dbconn, $sqllembaga);
                    while ($lbg = mysqli_fetch_array($resultlembaga)) {
                        $idlembaga = $lbg['id_lembaga'];
                        $nmlembaga = ucwords(strtolower($lbg['lembaga_pangangkat']));
                        echo "
                                    <option value='$idlembaga'>$nmlembaga</option>";
                    }
                    mysqli_free_result($resultlembaga);
                    ?>
                </select>
                <label for="cboLembagaPengangkat">Lembaga Pengangkat</label>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Sekolah Tempat Tugas</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtsekolahtmptugasMutasi" value="" maxlength="100" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahtmptugasMutasi">Nama Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsntempattugasmutasi" value="" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsntempattugasmutasi">NPSN Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatuspenugasanmutasi" id="cbostatuspenugasanmutasi" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Status Penugasan</option>
                    <option value="sekolah induk">Sekolah Induk</option>
                    <option value="sekolah non induk">Sekolah Non Induk</option>
                </select>
                <label for="cbostatuspenugasanmutasi">Status Penugasan</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cboJenisPTKMutasi" id="cboJenisPTKMutasi" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Jenis PTK</option>
                    <?php
                    $sqljns = ("SELECT id_jenis,jenis_ptk FROM tte_m_jenis_ptk ORDER BY id_jenis ASC");
                    $resultjnsptk = mysqli_query($dbconn, $sqljns);
                    while ($sp = mysqli_fetch_array($resultjnsptk)) {
                        $idjenis = $sp['id_jenis'];
                        $jenisptk = $sp['jenis_ptk'];
                        echo "
                                    <option value='$idjenis'>$jenisptk</option>";
                    }
                    mysqli_free_result($resultjnsptk);
                    mysqli_close($dbconn);
                    ?>
                </select>
                <label for="cboJenisPTKMutasi">Jenis PTK</label>
            </div>
            
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Surat Tugas</h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnosurattugasmutasi" value="" maxlength="50" placeholder="No. Surat Tugas" autocomplete="off">
                <label for="txtnosurattugasmutasi">No. Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglsurattugasmutasi" value="" type="text" placeholder="Tanggal surat tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsurattugasmutasi">Tanggal Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttmtsurattugas" value="" type="text" placeholder="TMT Surat Tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttmtsurattugas">TMT Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtsekolahsurattugasMutasi" value="" maxlength="100" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahsurattugasMutasi">Nama Sekolah Sesuai Surat Tugas</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnpsnsurattugasmutasi" value="" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsnsurattugasmutasi">NPSN Sekolah Sesuai Surat Tugas</label>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header bg-light overflow-hidden">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h5 class="mb-0 fs--1">Data Ijazah S1 Keatas <code>(** Opsional ** Tidak Wajib hanya untuk yang ijazah S1 Ke atas **)</code></h5>
                </div>
            </div>
        </div>
        <div class="card-body px-3 py-2 mb-0">

             <input type="text" id="lblchkIjazahMutasi" value="" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkijazahMutasi" type="checkbox" />
                <label class="form-check-label" for="chkijazahMutasi">Ijazah S1 Ke atas</label>
            </div>
            <div id="area-ijazah-mutasi-pendidik" style="display:none">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmptijazahmutasi" value="" maxlength="50" placeholder="Perguruan tinggi" autocomplete="off">
                    <label for="txtnmptijazahmutasi">Nama Perguruan Tinggi</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtprostudymutasi" value="" maxlength="50" placeholder="Program study" autocomplete="off">
                    <label for="txtprostudymutasi">Program Study</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnoijazahmutasi" value="" maxlength="50" placeholder="Nomor ijazah" autocomplete="off">
                    <label for="txtnoijazahmutasi">Nomor Ijazah</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="number" class="form-control form-control-sm" id="txtthnlulusijazahmutasi" value="" maxlength="4" placeholder="Tahun lulus" autocomplete="off">
                    <label for="txtthnlulusijazahmutasi">Tahun Lulus</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanMutasiPendidik">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
 
            $("#txtnmpendidikmutasi").val("");$("#cboSttsKepegawaian").val("");$("#txtnikmutasi").val("");
            $("#txtnipmutasi").val("");$("#txtnuptkmutasi").val("");
            $("#txttmplahirMutasi").val("");$("#txttgllahirMutasi").val("");$("#cbojkMutasi").val("");
            $("#txtnmibukandungmutasi").val("");$("#txtnowaMutasi").val("");

            $("#txtnoskpengangkatanmutasi").val("");$("#txttmtpengangkatan").val("");$("#cboLembagaPengangkat").val("");

            $("#txtsekolahtmptugasMutasi").val("");$("#txtnpsntempattugasmutasi").val("");
            $("#cbostatuspenugasanmutasi").val("");$("#cboJenisPTKMutasi").val("");

            $("#txtnosurattugasmutasi").val("");$("#txttglsurattugasmutasi").val("");$("#txttmtsurattugas").val("");
            $("#txtsekolahsurattugasMutasi").val("");$("#txtnpsnsurattugasmutasi").val("");

            $("#lblchkIjazahMutasi").val("N");//$("#chkijazahMutasi").val("");
            $("#txtnmptijazahmutasi").val("");$("#txtprostudymutasi").val("");
            $("#txtnoijazahmutasi").val("");$("#txtthnlulusijazahmutasi").val("");
    });

    $("#chkijazahMutasi").on("change", function() {
        $("#txtnmptijazahmutasi").val("");$("#txtprostudymutasi").val("");
        $("#txtnoijazahmutasi").val("");$("#txtthnlulusijazahmutasi").val("");
        if ($(this).is(':checked')) {
            $("#lblchkIjazahMutasi").val("Y");
            $("#area-ijazah-mutasi-pendidik").fadeIn();
        } else {
            $("#lblchkIjazahMutasi").val("N");
            $("#area-ijazah-mutasi-pendidik").fadeOut("slow");
        }
    });
  
    $("#cmdsimpanMutasiPendidik").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var idlayanan = "3";

        var nmpendidik = $("#txtnmpendidikmutasi").val();
        var idstatuskepegawaian = $("#cboSttsKepegawaian").val();
        var nik = $("#txtnikmutasi").val();
        var nip = $("#txtnipmutasi").val();
        var nuptk = $("#txtnuptkmutasi").val();
        var tmplahir = $("#txttmplahirMutasi").val();
        var tgllahir = $("#txttgllahirMutasi").val();
        var kelamin = $("#cbojkMutasi").val();
        var nmibukandung = $("#txtnmibukandungmutasi").val();
        var noWA = $("#txtnowaMutasi").val();

        var noskpengangkatan = $("#txtnoskpengangkatanmutasi").val();
        var tmtpengangkatan = $("#txttmtpengangkatan").val();
        var idlembagapengangkat = $("#cboLembagaPengangkat").val();

        var nmsekolahtugas = $("#txtsekolahtmptugasMutasi").val();
        var npsntugas = $("#txtnpsntempattugasmutasi").val();
        var idstatuspenugasan = $("#cbostatuspenugasanmutasi").val();
        var idjenisptk = $("#cboJenisPTKMutasi").val();

        var nosurattugas = $("#txtnosurattugasmutasi").val();
        var tglsurattugas = $("#txttglsurattugasmutasi").val();
        var tmtsurattugas = $("#txttmtsurattugas").val();
        var nmsekolahsurattugas = $("#txtsekolahsurattugasMutasi").val();
        var npsnsurattugas = $("#txtnpsnsurattugasmutasi").val();

        var chkijazah = $("#lblchkIjazahMutasi").val();
        var namapt = $("#txtnmptijazahmutasi").val();
        var progstudy = $("#txtprostudymutasi").val();
        var noijazah = $("#txtnoijazahmutasi").val();
        var thnlulusijazah = $("#txtthnlulusijazahmutasi").val();
        
        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);

        data.append('nmpendidik', nmpendidik);
        data.append('idstatuskepegawaian', idstatuskepegawaian);
        data.append('nik', nik);
        data.append('nip', nip);
        data.append('nuptk', nuptk);
        data.append('tmplahir', tmplahir);
        data.append('tgllahir', tgllahir);
        data.append('kelamin', kelamin);
        data.append('nmibukandung', nmibukandung);
        data.append('noWA', noWA);

        data.append('noskpengangkatan', noskpengangkatan);
        data.append('tmtpengangkatan', tmtpengangkatan);
        data.append('idlembagapengangkat', idlembagapengangkat);

        data.append('nmsekolahtugas', nmsekolahtugas);
        data.append('npsntugas', npsntugas);
        data.append('idstatuspenugasan', idstatuspenugasan);
        data.append('idjenisptk', idjenisptk);
      
        data.append('nosurattugas', nosurattugas);
        data.append('tglsurattugas', tglsurattugas);
        data.append('tmtsurattugas', tmtsurattugas);
        data.append('nmsekolahsurattugas', nmsekolahsurattugas);
        data.append('npsnsurattugas', npsnsurattugas);

        data.append('chkijazah', chkijazah);
        data.append('namapt', namapt);
        data.append('progstudy', progstudy);
        data.append('noijazah', noijazah);
        data.append('thnlulusijazah', thnlulusijazah);

        if (idlayanan.length <= 0 || idinstansi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmpendidik.length <= 0) {
            $("#txtnmpendidikmutasi").focus();
            alert("Nama pendidik / tenaga pendidik masih kosong")
        } else if (idstatuskepegawaian.length <= 0) {
            $("#cboSttsKepegawaian").focus();
            alert("Status kepegawaian masih kosong")
        } else if (nik.length <= 0) {
            $("#txtnikmutasi").focus();
            alert("NIK masih kosong")
        } else if (nip.length <= 0) {
            $("#txtnipmutasi").focus();
            alert("NIP masih kosong")
        } else if (nuptk.length <= 0) {
            $("#txtnuptkmutasi").focus();
            alert("NUPTK masih kosong")
        } else if (tmplahir.length <= 0) {
            $("#txttmplahirMutasi").focus();
            alert("Tempat lahir masih kosong")
        } else if (tgllahir.length <= 0) {
            $("#txttgllahirMutasi").focus();
            alert("Tanggal lahir masih kosong")
        } else if (kelamin.length <= 0) {
            $("#cbojkMutasi").focus();
            alert("Jenis kelamin masih kosong")
        } else if (nmibukandung.length <= 0) {
            $("#txtnmibukandungmutasi").focus();
            alert("Nama ibu kandung masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaMutasi").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (noskpengangkatan.length <= 0) {
            $("#txtnoskpengangkatanmutasi").focus();
            alert("No. SK pengangkatan masih kosong")
        } else if (tmtpengangkatan.length <= 0) {
            $("#txttmtpengangkatan").focus();
            alert("TMT pengangkatan masih kosong")
        } else if (idlembagapengangkat.length <= 0) {
            $("#cboLembagaPengangkat").focus();
            alert("Lembaga pengangkat masih kosong")
        } else if (nmsekolahtugas.length <= 0) {
            $("#txtsekolahtmptugasMutasi").focus();
            alert("Nama sekolah tempat tugas masih kosong")
        } else if (npsntugas.length <= 0) {
            $("#txtnpsntempattugasmutasi").focus();
            alert("NPSN sekolah tempat tugas masih kosong")
        } else if (idstatuspenugasan.length <= 0) {
            $("#cbostatuspenugasanmutasi").focus();
            alert("Status penugasan masih kosong")
        } else if (idjenisptk.length <= 0) {
            $("#cboJenisPTKMutasi").focus();
            alert("Jenis PTK masih kosong")

        } else if (nosurattugas.length <= 0) {
            $("#txtnosurattugasmutasi").focus();
            alert("Nomor surat tugas masih kosong")
        } else if (tglsurattugas.length <= 0) {
            $("#txttglsurattugasmutasi").focus();
            alert("Tanggal surat tugas masih kosong")
        } else if (tmtsurattugas.length <= 0) {
            $("#txttmtsurattugas").focus();
            alert("TMT surat tugas masih kosong")
        } else if (nmsekolahsurattugas.length <= 0) {
            $("#txtsekolahsurattugasMutasi").focus();
            alert("Nama sekolah sesuai surat tugas masih kosong")
        } else if (npsnsurattugas.length <= 0) {
            $("#txtnpsnsurattugasmutasi").focus();
            alert("NPSN sesuai surat tugas masih kosong")

        } else if (chkijazah == "Y" && namapt == "") {
            $("#txtnmptijazahmutasi").focus();
            alert("Nama perguruan tinggi masih kosong")
        } else if (chkijazah == "Y" && progstudy == "") {
            $("#txtprostudymutasi").focus();
            alert("Program study masih kosong")
        } else if (chkijazah == "Y" && noijazah == "") {
            $("#txtnoijazahmutasi").focus();
            alert("Nomor ijazah masih kosong")
        } else if (chkijazah == "Y" && thnlulusijazah == "") {
            $("#txtthnlulusijazahmutasi").focus();
            alert("Tahun lulus ijazah masih kosong")
        } else {
            var urlnya = "klinik-dapo/trans-layanan/mutasi-pendidik/aksi_tambah.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanMutasiPendidik").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMutasiPendidik();
                        isiJumlahLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdsimpanMutasiPendidik").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanMutasiPendidik").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanMutasiPendidik").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>