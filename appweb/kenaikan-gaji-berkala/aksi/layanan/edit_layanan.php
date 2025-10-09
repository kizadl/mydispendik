<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idlayanan= trim($_POST['idlayanan']);

$qri = ("SELECT layanan,awal_no_surat,no_urut,akhir_no_surat FROM tte_m_layanan WHERE id_layanan='".$idlayanan."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$nmlayanan =$c['layanan'];$awalan =$c['awal_no_surat'];$urutan =$c['no_urut'];$akhiran =$c['akhir_no_surat'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white fs-0">Edit Data Nomor Surat <?php echo $nmlayanan ?></h5>
        <p class="fs--1 mb-0 text-white">Silahkan edit data nomor surat <?php echo $nmlayanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Nomor Surat <?php echo $nmlayanan ?></strong> dibawah ini<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" class="form-control form-control-sm" id="txtidlayananE" value="<?php echo $idlayanan ?>" style="display:none">

    <div class="form-floating mb-3" hidden >
        <input type="text" class="form-control form-control-sm" id="txtnmlayananE" value="<?php echo $nmlayanan ?>" placeholder="Nama Layanan" maxlength="100" autocomplete="off">
        <label for="txtnmlayananE">Nama Layanan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtawalansuratE" value="<?php echo $awalan ?>" placeholder="Awalan Nomor Surat" maxlength="25" autocomplete="off">
        <label for="txtawalansuratE">Awalan Nomor Surat</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control form-control-sm" id="txtnourutE" value="<?php echo $urutan ?>" placeholder="Nomor Urut" maxlength="10" autocomplete="off">
        <label for="txtnourutE">Nomor Urut</label>
    </div>

    <div class="form-floating mb-0">
        <input type="text" class="form-control form-control-sm" id="txtakhiransuratE" value="<?php echo $akhiran ?>" placeholder="Akhiran Nomor Surat" maxlength="25" autocomplete="off">
        <label for="txtakhiransuratE">Akhiran Nomor Surat</label>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanLayananE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cmdSimpanLayananE").click(function() {
        var idlayanan = $('#txtidlayananE').val();
        var nmlayanan = $('#txtnmlayananE').val();
        var awalan = $('#txtawalansuratE').val();
        var urutan = $('#txtnourutE').val();
        var akhiran = $('#txtakhiransuratE').val();

        if (idlayanan.length <= 0) {
            alert('Layanan tidak terdeteksi')
        } else if (nmlayanan.length <= 0) {
            $('#txtnmlayananE').focus();
            alert('Nama layanan masih kosong')
        } else if (awalan.length <= 0) {
            $('#txtawalansuratE').focus();
            alert('Awalan nomor surat masih kosong')
        } else if (urutan.length <= 0) {
            $('#txtnourutE').focus();
            alert('Nomor urut surat masih kosong')
        } else if (akhiran.length <= 0) {
            $('#txtakhiransuratE').focus();
            alert('Akhiran nomor surat masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/layanan/aksi_edit.php',
                data: {
                    idlayanan: idlayanan,
                    nmlayanan: nmlayanan,
                    awalan: awalan,
                    urutan: urutan,
                    akhiran: akhiran,
                },
                dataType: "json",
                beforeSend: function(e) {
                    $("#cmdSimpanLayananE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanLayananE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanLayananE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanLayananE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>