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

$sqlx = ("SELECT nama_ptk,id_status_kepegawaian,nik,nip,nuptk,
	tempat_lahir,tgl_lahir,kelamin,nm_ibu_kandung,no_wa,
	no_sk_pengangkatan,tmt_pengangkatan,id_lembaga_pengangkat,
	nm_sekolah_penugasan,npsn_penugasan,stts_penugasan,id_jenis_ptk,
	no_surat_tugas,tgl_surat_tugas,tmt_surat_tugas,nm_sekolah_surat_tugas,npsn_surat_tugas,
	ijazah_s1,nm_pt,prog_studi,no_ijazah,thn_lulus FROM tte_trans_mutasi_pendidik WHERE id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$nmpendidik = $sm['nama_ptk'];
$idstatuskepegawaian = $sm['id_status_kepegawaian'];
$nik = $sm['nik'];
$nip = strtoupper($sm['nip']);
$nuptk = strtoupper($sm['nuptk']);
$tmplahir = strtoupper($sm['tempat_lahir']);
$tgllahir = $sm['tgl_lahir'];$tgllahir = date('d-m-Y', strtotime($tgllahir));
$kelamin = $sm['kelamin'];
$nmibukandung = strtoupper($sm['nm_ibu_kandung']);
$noWA = $sm['no_wa'];

$noskpengangkatan = strtoupper($sm['no_sk_pengangkatan']);
$tmtpengangkatan = $sm['tmt_pengangkatan'];$tmtpengangkatan = date('d-m-Y', strtotime($tmtpengangkatan));
$idlembagapengangkat = $sm['id_lembaga_pengangkat'];

$nmsekolahtugas = strtoupper($sm['nm_sekolah_penugasan']);
$npsntugas = strtoupper($sm['npsn_penugasan']);
$sttspenugasan = $sm['stts_penugasan'];
$idjenisptk = $sm['id_jenis_ptk'];

$nosurattugas = strtoupper($sm['no_surat_tugas']);
$tglsurattugas = $sm['tgl_surat_tugas'];$tglsurattugas = date('d-m-Y', strtotime($tglsurattugas));
$tmtsurattugas = $sm['tmt_surat_tugas'];$tmtsurattugas = date('d-m-Y', strtotime($tmtsurattugas));
$nmsekolahsurattugas = strtoupper($sm['nm_sekolah_surat_tugas']);
$npsnsurattugas = strtoupper($sm['npsn_surat_tugas']);

$ijazahs1 = $sm['ijazah_s1'];
if ($ijazahs1 == "Y"){
    $hidrekom = ""; $chkrekomval = "checked";
    $namapt = strtoupper($sm['nm_pt']);
    $progstudy = strtoupper($sm['prog_studi']);
    $noijazah = strtoupper($sm['no_ijazah']);
    $thnlulus = $sm['thn_lulus'];
} else if ($ijazahs1 == "N"){
    $hidrekom = "display:none"; $chkrekomval = "";
    $namapt = "";
    $progstudy = "";
    $noijazah = "";
    $thnlulus = "";
}

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
                        (Data Pendidik / Tenaga Pendidik, Data Pengangkatan, Data Sekolah Tempat Tugas, Data Surat Tugas dan Data Ijazah).
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" class="form-control form-control-sm" id="txtidTransaksiMutasiE" value="<?php echo $idtransaksi ?>" hidden >
    <input type="text" class="form-control form-control-sm" id="txtidlayananmutasiE" value="<?php echo $idlayanan ?>" hidden >

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
                    <input type="text" class="form-control form-control-sm" id="txtnmpendidikmutasiE" value="<?php echo $nmpendidik ?>" maxlength="100" placeholder="Nama lengkap" autocomplete="off">
                    <label for="txtnmpendidikmutasiE">Nama Lengkap</label>
                </div>
               
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboSttsKepegawaianE" id="cboSttsKepegawaianE" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Status Kepegawaian</option>
                        <?php
                        $sqlsttspeg = ("SELECT id_status,status_kepegawaian FROM tte_m_status_kepegawaian ORDER BY id_status ASC");
                        $resultsttspeg = mysqli_query($dbconn, $sqlsttspeg);
                        while ($sp = mysqli_fetch_array($resultsttspeg)) {
                            $idstatus = $sp['id_status'];
                            $statuskepegawaian = $sp['status_kepegawaian'];
                            if ($idstatuskepegawaian == $idstatus){$plhsttspeg = "selected";} else {$plhsttspeg = "";}
                            echo "
                                        <option value='$idstatus' $plhsttspeg >$statuskepegawaian</option>";
                        }
                        mysqli_free_result($resultsttspeg);
                        ?>
                    </select>
                    <label for="cboSttsKepegawaianE">Status Kepegawaian</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="txtnikmutasiE" value="<?php echo $nik ?>" maxlength="20" placeholder="NIK" autocomplete="off">
                    <label for="txtnikmutasiE">NIK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnipmutasiE" value="<?php echo $nip ?>" maxlength="35" placeholder="NIP" autocomplete="off">
                    <label for="txtnipmutasiE">NIP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnuptkmutasiE" value="<?php echo $nuptk ?>" maxlength="35" placeholder="NUPTK" autocomplete="off">
                    <label for="txtnuptkmutasiE">NUPTK</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txttmplahirMutasiE" value="<?php echo $tmplahir ?>" maxlength="50" placeholder="Tempat lahir" autocomplete="off">
                    <label for="txttmplahirMutasiE">Tempat Lahir</label>
                </div>

                <div class="form-floating mb-3">
                    <input class="form-control form-control-sm datetimepicker" id="txttgllahirMutasiE" value="<?php echo $tgllahir ?>" type="text" placeholder="Tanggal lahir" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                    <label for="txttgllahirMutasiE">Tanggal Lahir</label>
                </div>
               
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbojkMutasiE" id="cbojkMutasiE" data-options='{"removeItemButton":true,"placeholder":true}'>
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
                    <label for="cbojkMutasiE">Jenis Kelamin</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmibukandungmutasiE" value="<?php echo $nmibukandung ?>" maxlength="100" placeholder="Nama ibu kandung" autocomplete="off">
                    <label for="txtnmibukandungmutasiE">Nama Ibu Kandung</label>
                </div>

                <div class="form-floating mb-0">
                    <input type="number" class="form-control form-control-sm" id="txtnowaMutasiE" value="<?php echo $noWA ?>" maxlength="20" placeholder="Nomor WA (Aktif)" autocomplete="off">
                    <label for="txtnowaMutasiE">No. HP WhatsApp (WA) Aktif</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnoskpengangkatanmutasiE" value="<?php echo $noskpengangkatan ?>" maxlength="50" placeholder="SK Pengangkatan" autocomplete="off">
                <label for="txtnoskpengangkatanmutasiE">No. SK Pengangkatan</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttmtpengangkatanE" value="<?php echo $tmtpengangkatan ?>" type="text" placeholder="TMT Pengangkatan" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttmtpengangkatanE">TMT Pengangkatan</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cboLembagaPengangkatE" id="cboLembagaPengangkatE" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Lembaga Pengangkat</option>
                    <?php
                    $sqllembaga = ("SELECT id_lembaga,lembaga_pangangkat FROM tte_m_lembaga_pengangkat ORDER BY id_lembaga ASC");
                    $resultlembaga = mysqli_query($dbconn, $sqllembaga);
                    while ($lbg = mysqli_fetch_array($resultlembaga)) {
                        $idlembaga = $lbg['id_lembaga'];
                        $nmlembaga = ucwords(strtolower($lbg['lembaga_pangangkat']));
                        if ($idlembagapengangkat == $idlembaga){$plhlembaga = "selected";} else {$plhlembaga = "";}
                        echo "
                                    <option value='$idlembaga' $plhlembaga >$nmlembaga</option>";
                    }
                    mysqli_free_result($resultlembaga);
                    ?>
                </select>
                <label for="cboLembagaPengangkatE">Lembaga Pengangkat</label>
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
                <input type="text" class="form-control form-control-sm" id="txtsekolahtmptugasMutasiE" value="<?php echo $nmsekolahtugas ?>" maxlength="100" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahtmptugasMutasiE">Nama Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnpsntempattugasmutasiE" value="<?php echo $npsntugas ?>" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsntempattugasmutasiE">NPSN Sekolah Tempat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatuspenugasanmutasiE" id="cbostatuspenugasanmutasiE" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Status Penugasan</option>
                    <?php
                        if ($sttspenugasan == "sekolah induk") {
                            $plhInduk = "selected";
                        } else if ($sttspenugasan == "sekolah non induk") {
                            $plhNonInduk = "selected";
                        }
                        echo "<option value='sekolah induk' $plhInduk >Sekolah Induk</option>
                        <option value='sekolah non induk' $plhNonInduk >Sekolah Non Induk</option>";
                    ?>
                </select>
                <label for="cbostatuspenugasanmutasiE">Status Penugasan</label>
            </div>

            <div class="form-floating mb-2">
                <select class="form-select form-select-sm js-choice px-3" size="1" name="cboJenisPTKMutasiE" id="cboJenisPTKMutasiE" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Jenis PTK</option>
                    <?php
                    $sqljns = ("SELECT id_jenis,jenis_ptk FROM tte_m_jenis_ptk ORDER BY id_jenis ASC");
                    $resultjnsptk = mysqli_query($dbconn, $sqljns);
                    while ($sp = mysqli_fetch_array($resultjnsptk)) {
                        $idjenis = $sp['id_jenis'];
                        $jenisptk = $sp['jenis_ptk'];
                        if ($idjenisptk == $idjenis){$plhjns = "selected";} else {$plhjns = "";}
                        echo "
                                    <option value='$idjenis' $plhjns >$jenisptk</option>";
                    }
                    mysqli_free_result($resultjnsptk);
                    mysqli_close($dbconn);
                    ?>
                </select>
                <label for="cboJenisPTKMutasiE">Jenis PTK</label>
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
                <input type="text" class="form-control form-control-sm" id="txtnosurattugasmutasiE" value="<?php echo $nosurattugas ?>" maxlength="50" placeholder="No. Surat Tugas" autocomplete="off">
                <label for="txtnosurattugasmutasiE">No. Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttglsurattugasmutasiE" value="<?php echo $tglsurattugas ?>" type="text" placeholder="Tanggal surat tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttglsurattugasmutasiE">Tanggal Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control form-control-sm datetimepicker" id="txttmtsurattugasE" value="<?php echo $tmtsurattugas ?>" type="text" placeholder="TMT Surat Tugas" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
                <label for="txttmtsurattugasE">TMT Surat Tugas</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtsekolahsurattugasMutasiE" value="<?php echo $nmsekolahsurattugas ?>" maxlength="100" placeholder="Sekolah" autocomplete="off">
                <label for="txtsekolahsurattugasMutasiE">Nama Sekolah Sesuai Surat Tugas</label>
            </div>

            <div class="form-floating mb-2">
                <input type="text" class="form-control form-control-sm" id="txtnpsnsurattugasmutasiE" value="<?php echo $npsnsurattugas ?>" maxlength="50" placeholder="NPSN" autocomplete="off">
                <label for="txtnpsnsurattugasmutasiE">NPSN Sekolah Sesuai Surat Tugas</label>
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

             <input type="text" id="lblchkijazahMutasiEE" value="<?php echo $ijazahs1 ?>" readonly="readonly" hidden />
            <div class="form-check form-switch mt-2 mb-1 ms-1">
                <input class="form-check-input" id="chkijazahMutasiE" type="checkbox"  <?php echo $chkrekomval ?> />
                <label class="form-check-label" for="chkijazahMutasiE">Ijazah S1 Ke atas</label>
            </div>
            <div id="area-ijazah-mutasi-pendidikE" style="<?php echo $hidrekom ?>">
                <div class="form-floating mt-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnmptijazahmutasiE" value="<?php echo $namapt ?>" maxlength="50" placeholder="Perguruan tinggi" autocomplete="off">
                    <label for="txtnmptijazahmutasiE">Nama Perguruan Tinggi</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtprostudymutasiE" value="<?php echo $progstudy ?>" maxlength="50" placeholder="Program study" autocomplete="off">
                    <label for="txtprostudymutasiE">Program Study</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-sm" id="txtnoijazahmutasiE" value="<?php echo $noijazah ?>" maxlength="50" placeholder="Nomor ijazah" autocomplete="off">
                    <label for="txtnoijazahmutasiE">Nomor Ijazah</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="number" class="form-control form-control-sm" id="txtthnlulusijazahmutasiE" value="<?php echo $thnlulus ?>" maxlength="4" placeholder="Tahun lulus" autocomplete="off">
                    <label for="txtthnlulusijazahmutasiE">Tahun Lulus</label>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanMutasiPendidikE">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">

    $("#chkijazahMutasiE").on("change", function() {
        $("#txtnmptijazahmutasiE").val("");$("#txtprostudymutasiE").val("");
        $("#txtnoijazahmutasiE").val("");$("#txtthnlulusijazahmutasiE").val("");
        if ($(this).is(':checked')) {
            $("#lblchkijazahMutasiEE").val("Y");
            $("#area-ijazah-mutasi-pendidikE").fadeIn();
        } else {
            $("#lblchkijazahMutasiEE").val("N");
            $("#area-ijazah-mutasi-pendidikE").fadeOut("slow");
        }
    });
  
    $("#cmdsimpanMutasiPendidikE").click(function() {
        var QRCodeUrl = $("#lblQRURL").val();
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        
        var idlayanan = $("#txtidlayananmutasiE").val();
        var idtransaksi = $("#txtidTransaksiMutasiE").val();

        var nmpendidik = $("#txtnmpendidikmutasiE").val();
        var idstatuskepegawaian = $("#cboSttsKepegawaianE").val();
        var nik = $("#txtnikmutasiE").val();
        var nip = $("#txtnipmutasiE").val();
        var nuptk = $("#txtnuptkmutasiE").val();
        var tmplahir = $("#txttmplahirMutasiE").val();
        var tgllahir = $("#txttgllahirMutasiE").val();
        var kelamin = $("#cbojkMutasiE").val();
        var nmibukandung = $("#txtnmibukandungmutasiE").val();
        var noWA = $("#txtnowaMutasiE").val();

        var noskpengangkatan = $("#txtnoskpengangkatanmutasiE").val();
        var tmtpengangkatan = $("#txttmtpengangkatanE").val();
        var idlembagapengangkat = $("#cboLembagaPengangkatE").val();

        var nmsekolahtugas = $("#txtsekolahtmptugasMutasiE").val();
        var npsntugas = $("#txtnpsntempattugasmutasiE").val();
        var idstatuspenugasan = $("#cbostatuspenugasanmutasiE").val();
        var idjenisptk = $("#cboJenisPTKMutasiE").val();

        var nosurattugas = $("#txtnosurattugasmutasiE").val();
        var tglsurattugas = $("#txttglsurattugasmutasiE").val();
        var tmtsurattugas = $("#txttmtsurattugasE").val();
        var nmsekolahsurattugas = $("#txtsekolahsurattugasMutasiE").val();
        var npsnsurattugas = $("#txtnpsnsurattugasmutasiE").val();

        var chkijazah = $("#lblchkijazahMutasiEE").val();
        var namapt = $("#txtnmptijazahmutasiE").val();
        var progstudy = $("#txtprostudymutasiE").val();
        var noijazah = $("#txtnoijazahmutasiE").val();
        var thnlulusijazah = $("#txtthnlulusijazahmutasiE").val();
        
        var data = new FormData();
        data.append('QRCodeUrl', QRCodeUrl);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('idlayanan', idlayanan);
        data.append('idtransaksi', idtransaksi);

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

        if (idlayanan.length <= 0 || idtransaksi.length <= 0) {
            alert("Layanan atau instansi tidak terdeteksi")
        } else if (nmpendidik.length <= 0) {
            $("#txtnmpendidikmutasiE").focus();
            alert("Nama pendidik / tenaga pendidik masih kosong")
        } else if (idstatuskepegawaian.length <= 0) {
            $("#cboSttsKepegawaianE").focus();
            alert("Status kepegawaian masih kosong")
        } else if (nik.length <= 0) {
            $("#txtnikmutasiE").focus();
            alert("NIK masih kosong")
        } else if (nip.length <= 0) {
            $("#txtnipmutasiE").focus();
            alert("NIP masih kosong")
        } else if (nuptk.length <= 0) {
            $("#txtnuptkmutasiE").focus();
            alert("NUPTK masih kosong")
        } else if (tmplahir.length <= 0) {
            $("#txttmplahirMutasiE").focus();
            alert("Tempat lahir masih kosong")
        } else if (tgllahir.length <= 0) {
            $("#txttgllahirMutasiE").focus();
            alert("Tanggal lahir masih kosong")
        } else if (kelamin.length <= 0) {
            $("#cbojkMutasiE").focus();
            alert("Jenis kelamin masih kosong")
        } else if (nmibukandung.length <= 0) {
            $("#txtnmibukandungmutasiE").focus();
            alert("Nama ibu kandung masih kosong")
        } else if (noWA.length <= 0) {
            $("#txtnowaMutasiE").focus();
            alert("Nomor HP WhatsApp (WA) Aktif masih kosong")

        } else if (noskpengangkatan.length <= 0) {
            $("#txtnoskpengangkatanmutasiE").focus();
            alert("No. SK pengangkatan masih kosong")
        } else if (tmtpengangkatan.length <= 0) {
            $("#txttmtpengangkatanE").focus();
            alert("TMT pengangkatan masih kosong")
        } else if (idlembagapengangkat.length <= 0) {
            $("#cboLembagaPengangkatE").focus();
            alert("Lembaga pengangkat masih kosong")
        } else if (nmsekolahtugas.length <= 0) {
            $("#txtsekolahtmptugasMutasiE").focus();
            alert("Nama sekolah tempat tugas masih kosong")
        } else if (npsntugas.length <= 0) {
            $("#txtnpsntempattugasmutasiE").focus();
            alert("NPSN sekolah tempat tugas masih kosong")
        } else if (idstatuspenugasan.length <= 0) {
            $("#cbostatuspenugasanmutasiE").focus();
            alert("Status penugasan masih kosong")
        } else if (idjenisptk.length <= 0) {
            $("#cboJenisPTKMutasiE").focus();
            alert("Jenis PTK masih kosong")

        } else if (nosurattugas.length <= 0) {
            $("#txtnosurattugasmutasiE").focus();
            alert("Nomor surat tugas masih kosong")
        } else if (tglsurattugas.length <= 0) {
            $("#txttglsurattugasmutasiE").focus();
            alert("Tanggal surat tugas masih kosong")
        } else if (tmtsurattugas.length <= 0) {
            $("#txttmtsurattugasE").focus();
            alert("TMT surat tugas masih kosong")
        } else if (nmsekolahsurattugas.length <= 0) {
            $("#txtsekolahsurattugasMutasiE").focus();
            alert("Nama sekolah sesuai surat tugas masih kosong")
        } else if (npsnsurattugas.length <= 0) {
            $("#txtnpsnsurattugasmutasiE").focus();
            alert("NPSN sesuai surat tugas masih kosong")

        } else if (chkijazah == "Y" && namapt == "") {
            $("#txtnmptijazahmutasiE").focus();
            alert("Nama perguruan tinggi masih kosong")
        } else if (chkijazah == "Y" && progstudy == "") {
            $("#txtprostudymutasiE").focus();
            alert("Program study masih kosong")
        } else if (chkijazah == "Y" && noijazah == "") {
            $("#txtnoijazahmutasiE").focus();
            alert("Nomor ijazah masih kosong")
        } else if (chkijazah == "Y" && thnlulusijazah == "") {
            $("#txtthnlulusijazahmutasiE").focus();
            alert("Tahun lulus ijazah masih kosong")
        } else {
            var urlnya = "klinik-dapo/trans-layanan/mutasi-pendidik/aksi_edit.php";
            $.ajax({
                type: "POST",
                url: urlnya,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdsimpanMutasiPendidikE").attr("disabled", "disabled");
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
                        $("#cmdsimpanMutasiPendidikE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdsimpanMutasiPendidikE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdsimpanMutasiPendidikE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>