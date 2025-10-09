<?php
error_reporting(0);
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
        <h5 class="mb-0 fs-1 text-white">Tindak Lanjut Pengaduan Dapodik</h5>
        <p class="fs--1 mb-0 text-white">Silahkan isi dan lengkapi data tindak lanjut pengaduan dapodik</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-2 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        📢 Isi dan lengkapi data isian <strong>Tindak Lanjut Pengaduan Dapodik</strong><br>
                        <i>Penetapan Status dan Uraian Catatan Tindak Lanjut</i><br>
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
                <input type="text" class="form-control form-control-sm" id="txtnikdapoE" value="<?php echo $nik ?>" maxlength="16" placeholder="NIK" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled >
                <label for="txtnikdapoE">NIK</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtnamalengkapdapoE" value="<?php echo $nama ?>" maxlength="50" placeholder="Nama Lengkap" autocomplete="off" disabled >
                <label for="txtnamalengkapdapoE">Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-sm" id="txtalamatdapoE" value="<?php echo $alamat ?>" maxlength="200" placeholder="Alamat" autocomplete="off" disabled >
                <label for="txtalamatdapoE">Alamat</label>
            </div>

            <div class="form-floating mb-0">
                <input type="text" class="form-control form-control-sm" id="txtnowadapoE" value="<?php echo $nowa ?>" maxlength="20" placeholder="No. WA" autocomplete="off" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled >
                <label for="txtnowadapoE">No. HP WhatsApp (Aktif)</label>
            </div>
        </div>
    </div>

    <div class="card mb-2">
        <div class="card-body px-3 py-3 mb-0">

            <div class="form-floating mb-0">
                <select class="form-select form-select-sm js-choice px-3" id="cbostatusdapo" size="1" required="required"
                    data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="">Penetapan Status</option>
                    <option value="terima">Diterima</option>
                    <option value="tolak">Ditolak</option>
                </select>
                <label for="cbostatusdapo">Penetapan Status</label>
            </div>

        </div>
    </div>

    <div class="row mb-2">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body align-items-center">
                    <div class="mb-0 mt-0">
                        <label for="txtcatatandapo">Uraian Catatan Tindak Lanjut</label>
                        <textarea class="form-control form-control-sm fs--1" id="txtcatatandapo" placeholder="Uraian Catatan Tindak Lanjut" style="height: 80px"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanPengaduanKirim">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cmdsimpanPengaduanKirim").click(function() {
        var idoperator = $("#lbleditor").val();;

        var idtransaksi = $("#txtidtransaksipengaduanE").val();
        var statuspengaduan = $("#cbostatusdapo").val();
        var tindakan = $("#txtcatatandapo").val();

        if (idtransaksi.length <= 0) {
            return showError("🔴 Data pengaduan tidak terdeteksi");
        } else if (statuspengaduan.length <= 0) {
            $("#cbostatusdapo").focus();
            return showError("🔴 Penetapan Status masih kosong");
        } else if (tindakan.length <= 0) {
            $("#txtcatatandapo").focus();
            return showError("🔴 Uraian lanjutan masih kosong");
        }

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var data = new FormData();
        data.append("csrfToken", csrfToken);

        data.append('idoperator', idoperator);
        data.append('idtransaksi', idtransaksi);
        data.append('statuspengaduan', statuspengaduan);
        data.append('tindakan', tindakan);

        var urlnya = "aksi/trans-layanan/pengaduan-dapodik/aksi_edit.php";
        $.ajax({
            type: "POST",
            url: urlnya,
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#cmdsimpanPengaduanKirim").attr("disabled", "disabled");
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
                    $("#cmdsimpanPengaduanKirim").removeAttr("disabled");
                } else {
                    showError("🔴 Gagal !! Proses simpan tidak berhasil");
                    $("#cmdsimpanPengaduanKirim").removeAttr("disabled");
                }
            },
            error: function() {
                showError('❌ Koneksi bermasalah periksa internet');
                $("#cmdsimpanPengaduanKirim").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    });
</script>