<?php
$nosurat = trim($_POST['nosurat']);
$nmpemohon = trim($_POST['nmpemohon']);
$layanan = trim($_POST['layanan']);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
  <div class="position-relative z-index-1 light">
    <h5 class="mb-0 text-white">File Persyaratan</h5>
      <p class="fs--1 mb-0 text-white">Sorot icon file untuk menghapus atau mengunduh file persyaratan</p>
  </div>
  <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">

  <?php
  error_reporting(0);

  $idsurat = trim($_POST['idsurat']);
  $idlayanan = trim($_POST['idlayanan']);
  $idinstansi = trim($_POST['idinstansi']);

  $dir = "../../../data-persyaratan/".$idinstansi."/".$idsurat."/";
  $dirfile = "../data-persyaratan/".$idinstansi."/".$idsurat."/";
  //////// hapus file ///////////
  $urlhapusfile = $_SERVER['DOCUMENT_ROOT']."/ptsp/data-persyaratan/".$idinstansi."/".$idsurat."/";
  //////// //////////////////////
  $source_files = glob($dir . "*.pdf");

  if (count($source_files) == 0){
    echo "<p class='fs--1 mb-0 text-center'><strong>Terdeteksi tidak ada file yang ditemukan !!</strong></p>";
  } else {
    echo "
    <div class='row mb-5 g-3'>
        <div class='col-xxl-12'>
            <div class='card bg-light h-lg-100'>
                <div class='card-body d-flex align-items-center'>
                    <p class='fs--1 mt-0 mb-0'>
                        <strong>$layanan<br />$nosurat<br />$nmpemohon</strong><br />
                        Sorot bidang file untuk <strong>Download atau Menghapus File Persyaratan</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>";
  }

  for ($i = 0; $i < count($source_files); $i++) {

    $thumbfile = "../data-persyaratan/dokumen-pdf.png";

    echo "
      <div class='d-flex mb-3 hover-actions-trigger align-items-center'>
        <div class='file-thumbnail'><img class='border h-100 w-100 fit-cover rounded-2' src='" . $thumbfile . "' alt='' />
        </div>
        <div class='ms-3 flex-shrink-1 flex-grow-1'>
          <h6 class='mb-1'><a class='stretched-link text-900 fw-semi-bold' href='#!'>" . basename($source_files[$i]) . "</a></h6>
            <div class='hover-actions end-0 top-50 translate-middle-y'>
              <a class='btn btn-light border-300 btn-sm me-1' data-bs-toggle='tooltip' data-bs-placement='top' title='Download' href='" . $dirfile . basename($source_files[$i]) . "' download='". basename($source_files[$i]) ."'><img src='../assets/img/icons/cloud-download.svg' alt='' width='15' /></a>
              <button class='btn btn-light border-300 btn-sm me-1 shadow-none cmdHapusFile' type='button' data-idinstansi='".$idinstansi."' data-idlayanan='".$idlayanan."' data-idsurat='".$idsurat."' data-urlfile='".$urlhapusfile . basename($source_files[$i])."' data-bs-toggle='tooltip' data-bs-placement='top' title='Hapus'><img src='../assets/img/icons/delete.svg' alt='' width='15' /></button>
            </div>
          </div>
        </div>
      <hr class='text-200' />";
  }
  ?>

</div>

<script type="text/javascript" charset="utf-8">
  $(".cmdHapusFile").on("click",function() {

    var idsurat = $(this).data('idsurat');
    var idlayanan = $(this).data('idlayanan');
    var idinstansi = $(this).data('idinstansi');
    var urlfile = $(this).data('urlfile');

    if (idinstansi.length <= 0) {
      alert('Instansi tidak terdeteksi')
    } else if (idlayanan.length <= 0) {
      alert('Data layanan tidak terdeteksi')
    } else if (idsurat.length <= 0 || urlfile.length <= 0) {
      alert('Data surat tidak terdeteksi')
    } else {
      $.ajax({
        type: "POST",
        url: 'aksi/list-file/hapus_file.php',
        data: {urlfile: urlfile},
        beforeSend: function(e) {
          $(".cmdHapusFile").attr("disabled", "disabled");
        },
        success: function(resp) {
          $(".cmdHapusFile").removeAttr("disabled");
          if (resp == "ok"){
            alert("Proses hapus file sukses")
            $('#modBebasData').modal('hide');
          } else if (resp == "err"){
            alert("Gagal menghapus file kesalahan server\nAtau file tidak ditemukan")
            $('#modBebasData').modal('hide');
          }
        },
        error: function() {
          alert('Koneksi bermasalah periksa internet');
          $(".cmdHapusFile").removeAttr("disabled");
        },
      });
    };
  });

</script>