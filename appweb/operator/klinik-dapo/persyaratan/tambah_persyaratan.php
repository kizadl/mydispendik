<?php
error_reporting(0);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['nmlayanan']);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Tambah Data Persyaratan</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data persyaratan</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong>Persyaratan <?php echo $nmlayanan ?></strong><br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidlayananPsTmb" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmpersyaratan" value="" placeholder="Nama Layanan" maxlength="100" autocomplete="off">
        <label for="txtnmpersyaratan">Persyaratan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmfilesyarat" value="" placeholder="Nama Layanan" maxlength="50" autocomplete="off">
        <label for="txtnmfilesyarat">Nama File</label>
    </div>

    <div class="form-floating mb-0">
        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokriteriasyarat" id="cbokriteriasyarat" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Mode upload persyaratan</option>
            <option value="wajib">Wajib</option>
            <option value="opsional">Opsional (Tidak wajib)</option>
        </select>
        <label for="cbokriteriasyarat">Mode Upload Persyaratan</label>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanPersyaratan">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnmpersyaratan").val("");
        $("#txtnmfilesyarat").val("");
        $("#cbokriteriasyarat").val("");
    });

    $("#cmdSimpanPersyaratan").click(function() {
        var idlayanan = $('#txttransidlayananPsTmb').val();
        var nmpersyaratan = $('#txtnmpersyaratan').val();
        var nmfile = $('#txtnmfilesyarat').val();
        var kriteria = $('#cbokriteriasyarat').val();

        if (idlayanan.length <= 0) {
            alert('Layanan tidak terdeteksi')
        } else if (nmpersyaratan.length <= 0) {
            $('#txtnmpersyaratan').focus();
            alert('Persyaratan masih kosong')
        } else if (nmfile.length <= 0) {
            $('#txtnmfilesyarat').focus();
            alert('Nama file persyaratan masih kosong')
        } else if (kriteria.length <= 0) {
            $('#cbokriteriasyarat').focus();
            alert('Mode upload persyaratan masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/persyaratan/aksi_tambah.php',
                data: {
                    idlayanan: idlayanan,
                    nmpersyaratan: nmpersyaratan,
                    nmfile: nmfile,
                    kriteria: kriteria,
                },
                dataType: "json",
                beforeSend: function(e) {
                    $("#cmdSimpanPersyaratan").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLargeBebas').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterPersyaratan();isiMasterLayanan();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanPersyaratan").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanPersyaratan").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanPersyaratan").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>