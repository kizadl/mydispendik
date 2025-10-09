<?php
error_reporting(0);
$idinstansi = trim($_POST['idinstansi']);
$idpersyaratan = trim($_POST['idpersyaratan']);
$idtransaksi = trim($_POST['idtransaksi']);
$idlayanan = trim($_POST['idlayanan']);
$nmlayanan = trim($_POST['nmlayanan']);
$nmpemohon = trim($_POST['nmpemohon']);
$nosurat = trim($_POST['nosurat']);
$persyaratan = trim($_POST['persyaratan']);
$nmfile = trim($_POST['nmfile']);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Proses Upload Persyaratan</h5>
        <p class="fs--1 mb-0 text-white">Upload <?php echo $persyaratan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $nmpemohon ?><br />NO. <?php echo $nosurat ?><br /><?php echo $nmlayanan ?></strong><br /><?php echo $persyaratan ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="text" id="txtnmfilesipsyarat" value="<?php echo $nmfile ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txtidpersyaratansipsyarat" value="<?php echo $idpersyaratan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txtidsuratsipsyarat" value="<?php echo $idtransaksi ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txtidlayanansipsyarat" value="<?php echo $idlayanan ?>" readonly="readonly" style="display:none" />
    <input type="text" id="txttidinstansisipsyarat" value="<?php echo $idinstansi ?>" readonly="readonly" style="display:none" />

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0 fs--1">Upload File Dokumen Persyaratan</h5>
        </div>
        <div class="card-body bg-light">
            <div id="dropzoneuploadsyarat" class="dropzone"></div>
            <center>
                <button class="btn btn-falcon-default btn-sm" id="cmdUploadSyarat">Upload Dokumen</button>
            </center>
        </div>
    </div>

</div>
<script>
    $('#modUploadSyarat').on('shown.bs.modal', function(e) {

        $("#modTampilSyarat").modal("hide");

        var nmfile = $('#txtnmfilesipsyarat').val();
        var idtransaksi = $('#txtidsuratsipsyarat').val();
        var idlayanan = $('#txtidlayanansipsyarat').val();
        var idpersyaratan = $('#txtidpersyaratansipsyarat').val();
        var idsekolah = $('#txttidinstansisipsyarat').val();

        var myUploadDokumen = new Dropzone("#dropzoneuploadsyarat", {
            url: "klinik-dapo/trans-layanan/aksi-upload-persyaratan.php?idsekolah=" + idsekolah + "&ketfile=pdf&idtransaksi=" + idtransaksi + "&nmfile=" + nmfile + "&idpersyaratan=" + idpersyaratan + "&idlayanan=" + idlayanan,
            method: "POST",
            paramName: "file",
            autoProcessQueue: false,
            acceptedFiles: "application/pdf",
            maxFiles: 1,

            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
            createImageThumbnails: true,
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            addRemoveLinks: true,
            timeout: 180000,
            dictRemoveFileConfirmation: "Hapus file ini?", // ask before removing file
            // Language Strings
            dictFileTooBig: "File terlalu besar ({{filesize}}mb). Max ukuran file {{maxFilesize}}mb",
            dictInvalidFileType: "Type file tidak valid",
            dictCancelUpload: "Cancel",
            dictRemoveFile: "Remove",
            dictMaxFilesExceeded: "Hanya {{maxFiles}} files yang diperkenankan",
            dictDefaultMessage: "Drop file dokumen di area ini",
        });

        myUploadDokumen.on("complete", function(file) {
            setTimeout(function() {
                myUploadDokumen.removeFile(file);
            }, 3000);
        });
        myUploadDokumen.on("addedfile", function(file) {});
        myUploadDokumen.on("removedfile", function(file) {});

        myUploadDokumen.on("sending", function(file, xhr, formData) {
            formData.append("dropzoneuploadsyarat", "1");
        });

        myUploadDokumen.on("error", function(file, response) {
            console.log(response);
        });
        myUploadDokumen.on("successmultiple", function(file, response) {
            console.log(response);
            setTimeout(function() {
                $("#modUploadSyarat").modal("hide");
                isiMasterPersyaratanAfterUpload();
            }, 3000);
        });

        /**
         *  Add existing images to the dropzone
         *  @var images
         */

        var images = [];

        for (let i = 0; i < images.length; i++) {

            let img = images[i];
            var mockFile = {
                name: img.name,
                size: img.size,
                url: img.url
            };
            myUploadDokumen.emit("addedfile", mockFile);
            myUploadDokumen.emit("thumbnail", mockFile, img.url);
            myUploadDokumen.emit("complete", mockFile);
            var existingFileCount = 1;
            myUploadDokumen.options.maxFiles = myUploadDokumen.options.maxFiles - existingFileCount;
        }

        var submitDropzoneFotoWCg = document.getElementById("cmdUploadSyarat");
        submitDropzoneFotoWCg.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (myUploadDokumen.files != "") {
                myUploadDokumen.processQueue();
            } else {
                document.getElementById("dropzone-form").submit();
            }
        });
    });

    $("#modUploadSyarat").on("hide.bs.modal", function() {
        $("#modTampilSyarat").modal("show");
    })
</script>