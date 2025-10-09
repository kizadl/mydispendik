<?php
//error_reporting(0);
require_once '../../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idtransaksi = trim($_POST['idtransaksi']);
$idsekolah = trim($_POST['idsekolah']);

$sqlx = ("SELECT * FROM trans_pengaduan_dapodik p WHERE p.id_transaksi='" . $idtransaksi . "'");
$restps = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($restps);

$noorder = $sm['no_order'];
$waktucreate = $sm['waktu_create'];$waktucreate = date('d-m-Y', strtotime($waktucreate));

$nik = $sm['nik'];
$nama = strtoupper($sm['nama']);
$alamat = $sm['alamat'];
$noorder = strtoupper($sm['no_order']);
$nowa = $sm['no_wa'];

$bentukpendidikan = strtoupper($sm['bentuk_pendidikan']);
$uraianmasalah = $sm['uraian_masalah'];

$statusakhir = strtoupper($sm['ket_status_akhir']);

mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-1 text-white">Edit Data Pengaduan Dapodik</h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi data pengaduan dapodik</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-2 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        📢 Isi dan lengkapi data isian <strong>Pengaduan Dapodik</strong> <i>NIK, Nama Lengkap, Alamat, No. HP/WA, Bentuk Pendidikan, Uraian Masalah dan Upload File (*.pdf)</i><br>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" class="form-control form-control-sm" id="txtidtransaksipengaduanE" value="<?php echo $idtransaksi ?>" hidden >

    <div class="card mb-2">
        <div class="card-body px-3 py-3 mb-0">

            <div class="form-floating mb-3 mt-2">
                <input type="text" class="form-control form-control-sm" id="txtnikdapoE" value="<?php echo $nik ?>" maxlength="16" placeholder="NIK" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <label for="txtnikdapoE">NIK</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnamalengkapdapoE" value="<?php echo $nama ?>" maxlength="50" placeholder="Nama Lengkap" autocomplete="off">
                <label for="txtnamalengkapdapoE">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtalamatdapoE" value="<?php echo $alamat ?>" maxlength="200" placeholder="Alamat" autocomplete="off">
                <label for="txtalamatdapoE">Alamat</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnowadapoE" value="<?php echo $nowa ?>" maxlength="20" placeholder="No. WA" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <label for="txtnowadapoE">No. HP WhatsApp (Aktif)</label>
            </div>

            <div class="form-floating mb-0">
                <select class="form-select form-select-sm js-choice px-3" id="cbobentukpendidikandapoE" size="1" required="required"
                    data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Bentuk Pendidikan</option>
                    <?php
                    if ($bentukpendidikan == "PAUD"){$pilihpaud = "selected";} else {$pilihpaud = "";}
                    if ($bentukpendidikan == "SD"){$pilihSD = "selected";} else {$pilihSD = "";}
                    if ($bentukpendidikan == "SMP"){$pilihSMP = "selected";} else {$pilihSMP = "";}
                    if ($bentukpendidikan == "PNF"){$pilihPNF = "selected";} else {$pilihPNF = "";}
                        
                    echo "<option value='PAUD' $pilihpaud >PAUD</option>";
                    echo "<option value='SD' $pilihSD >Sekolah Dasar</option>";
                    echo "<option value='SMP' $pilihSMP >Sekolah Menengah Pertama</option>";
                    echo "<option value='PNF' $pilihPNF >Pendidikan Non Formal</option>";
                    ?>
                </select>
                <label for="cbobentukpendidikandapoE">Bentuk Pendidikan</label>
            </div>

        </div>
    </div>

    <div class="row mb-2">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body align-items-center">
                    <div class="mb-0 mt-0">
                        <label for="txtmasalahdapoE">Uraian Masalah</label>
                        <textarea class="form-control form-control-sm fs--1" id="txtmasalahdapoE" placeholder="Uraian Masalah" style="height: 80px"><?php echo $uraianmasalah ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header">
            <h5 class="mb-0 fs--1">Upload File</h5>
        </div>
        <div class="card-body bg-light">
            <input class="form-control form-control-sm mb-0 mt-0" type="file" id="btnUploadDapoE" accept=".pdf" required />
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPengaduanDapoE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $('#btnUploadDapoE').on('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                showError('🔴 Hanya PDF yang diperbolehkan');
                this.value = '';
            } else if (file.size > 30 * 1024 * 1024) { // misal batas 5MB
                showError('🔴 Ukuran file maksimum 30 MB');
                this.value = '';
            }
        }
    });

    $("#cmdsimpanPengaduanDapoE").click(function() {
        var idoperator = $("#lbleditor").val();
        var idinstansi = $("#lblidsekolah").val();
        var namasekolah = $("#lblnminstansi").val();
        var npsn = $("#llnpsnsekolah").val();

        var idtransaksi = $("#txtidtransaksipengaduanE").val();
        var nik = $("#txtnikdapoE").val();
        var nama = $("#txtnamalengkapdapoE").val();
        var alamat = $("#txtalamatdapoE").val();
        var noWA = $("#txtnowadapoE").val();
        var bentukpendidikan = $("#cbobentukpendidikandapoE").val();
        var masalah = $("#txtmasalahdapoE").val();

        if (idtransaksi.length <= 0) {
            return showError("🔴 Data pengaduan tidak terdeteksi");
        } else if (nik.length <= 15) {
            $("#txtnikdapoE").focus();
            return showError("🔴 Data NIK tidak valid !!");
        } else if (nama.length <= 0) {
            $("#txtnamalengkapdapoE").focus();
            return showError("🔴 Data nama masih kosong !!");
        } else if (alamat.length <= 0) {
            $("#txtalamatdapoE").focus();
            return showError("🔴 Data alamat masih kosong !!");
        } else if (noWA.length <= 8) {
            $("#txtnowadapoE").focus();
            return showError("🔴 Data No. WA tidak valid !!");
        } else if (bentukpendidikan.length <= 0) {
            $("#cbobentukpendidikandapoE").focus();
            return showError("🔴 Bentuk pendidikan masih kosong");
        } else if (masalah.length <= 0) {
            $("#txtmasalahdapoE").focus();
            return showError("🔴 Uraian masalah masih kosong");
        }

        var fileInput = $("#btnUploadDapoE")[0];
        if (!fileInput.files.length) {
            return showError("🔴 Pilih file PDF terlebih dahulu");
        }
        var file = fileInput.files[0];
        if (file.type !== "application/pdf") {
            return showError("🔴 Format yang diizinkan hanya PDF");
        }
        if (file.size > 30 * 1024 * 1024) {
            return showError("🔴 Maksimum ukuran file 30 MB");
        }

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var data = new FormData();
        data.append("csrfToken", csrfToken);

        data.append("upPengaduanE", file);
        data.append('idoperator', idoperator);
        data.append('idinstansi', idinstansi);
        data.append('namasekolah', namasekolah);
        data.append('npsn', npsn);

        data.append('idtransaksi', idtransaksi);

        data.append('nik', nik);
        data.append('nama', nama);
        data.append('alamat', alamat);
        data.append('noWA', noWA);
        data.append('bentukpendidikan', bentukpendidikan);
        data.append('masalah', masalah);

        var urlnya = "klinik-dapo/trans-layanan/pengaduan-dapodik/aksi_edit.php";
        $.ajax({
            type: "POST",
            url: urlnya,
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#cmdsimpanPengaduanDapoE").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.new_token) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', resp.new_token);
                }
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modEditDataLarge').modal('hide');
                    }, 1000);
                    showSuccess("🟢 Proses penyimpanan data berhasil");
                    isiPengaduanDapodik();
                } else if (resp.msg2 == 'err_val') {
                    showError("🔴 Tidak lengkap! Proses simpan tidak berhasil\n" + resp.msg1);
                    $("#cmdsimpanPengaduanDapoE").removeAttr("disabled");
                } else {
                    showError("🔴 Gagal !! Proses simpan tidak berhasil");
                    $("#cmdsimpanPengaduanDapoE").removeAttr("disabled");
                }
            },
            error: function() {
                showError('❌ Koneksi bermasalah periksa internet');
                $("#cmdsimpanPengaduanDapoE").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    });
</script>