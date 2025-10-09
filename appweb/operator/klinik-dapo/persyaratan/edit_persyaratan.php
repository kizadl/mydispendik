<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idpersyaratan= trim($_POST['idpersyaratan']);
$nmlayanan= trim($_POST['nmlayanan']);

$qri = ("SELECT persyaratan,nama_file,mode_upload FROM tte_m_persyaratan WHERE id_persyaratan='".$idpersyaratan."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$persyaratan =$c['persyaratan'];$nmfile =$c['nama_file'];$modeupload =$c['mode_upload'];
mysqli_free_result($dbquery);mysqli_close($dbconn);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Edit Data Persyaratan</h5>
        <p class="fs--1 mb-0 text-white">Silahkan merubah data persyaratan</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong>Persyaratan <?php echo $nmlayanan ?></strong><br/>
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txttransidpersyaratanE" value="<?php echo $idpersyaratan ?>" readonly="readonly" style="display:none" />

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmpersyaratanE" value="<?php echo $persyaratan ?>" placeholder="Nama Layanan" maxlength="100" autocomplete="off">
        <label for="txtnmpersyaratanE">Persyaratan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmfilesyaratE" value="<?php echo $nmfile ?>" placeholder="Nama Layanan" maxlength="50" autocomplete="off">
        <label for="txtnmfilesyaratE">Nama File</label>
    </div>

    <div class="form-floating mb-0">
        <select class="form-select form-select-sm js-choice px-3" size="1" name="cbokriteriasyaratE" id="cbokriteriasyaratE" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Mode upload persyaratan</option>
            <?php
            if($modeupload == "wajib"){$plhmodwjb = "selected";}
            else if($modeupload == "opsional"){$plhmodops = "selected";}
            echo "
            <option value='wajib' $plhmodwjb >Wajib</option>
            <option value='opsional' $plhmodops >Opsional (Tidak wajib)</option>";
            ?>
        </select>
        <label for="cbokriteriasyaratE">Mode Upload Persyaratan</label>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanPersyaratanE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cmdSimpanPersyaratanE").click(function() {
        var idsyarat = $('#txttransidpersyaratanE').val();
        var nmpersyaratan = $('#txtnmpersyaratanE').val();
        var nmfile = $('#txtnmfilesyaratE').val();
        var kriteria = $('#cbokriteriasyaratE').val();

        if (idsyarat.length <= 0) {
            alert('Persyaratan tidak terdeteksi')
        } else if (nmpersyaratan.length <= 0) {
            $('#txtnmpersyaratanE').focus();
            alert('Persyaratan masih kosong')
        } else if (nmfile.length <= 0) {
            $('#txtnmfilesyaratE').focus();
            alert('Nama file persyaratan masih kosong')
        } else if (kriteria.length <= 0) {
            $('#cbokriteriasyaratE').focus();
            alert('Mode upload persyaratan masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/persyaratan/aksi_edit.php',
                data: {
                    idsyarat: idsyarat,
                    nmpersyaratan: nmpersyaratan,
                    nmfile: nmfile,
                    kriteria: kriteria,
                },
                dataType: "json",
                beforeSend: function(e) {
                    $("#cmdSimpanPersyaratanE").attr("disabled", "disabled");
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
                        $("#cmdSimpanPersyaratanE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanPersyaratanE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanPersyaratanE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>