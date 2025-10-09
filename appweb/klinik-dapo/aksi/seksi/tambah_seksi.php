<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Tambah Data Seksi</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data seksi</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Kepala Seksi</strong> dibawah ini.<br />
                        Isi data <strong>NIK</strong> dengan benar. Data NIK akan ditetapkan sebagai <strong>Username dan Password</strong>.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmseksi" value="" placeholder="Nama OPD" maxlength="100" autocomplete="off">
        <label for="txtnmseksi">Nama Seksi</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <div class="form-floating mb-1" style="display:block">
                <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbobagian" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                <option value="">Pilih bidang</option>
                    <?php
							$qrikec = ("SELECT id_bidang,nm_bidang FROM tte_m_bidang WHERE aktif='Y'");								
							$liskec = mysqli_query($dbconn,$qrikec);									
							while($j=mysqli_fetch_array($liskec)){
								echo "<option value=\"".$j['id_bidang']."\">".$j['nm_bidang']."</option>";
							}mysqli_free_result($liskec);mysqli_close($dbconn);
					?>
                </select>
                <label for="cbobagian">Pilihan Bidang</label>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmkasi" value="" placeholder="Nama Kepala Dinas" maxlength="100" autocomplete="off">
        <label for="txtnmkasi">Nama Kepala Seksi</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtjabatankasi" value="" placeholder="Jabatan" maxlength="100" autocomplete="off">
        <label for="txtjabatankasi">Jabatan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtpangkatkasi" value="" placeholder="Pangkat" maxlength="25" autocomplete="off">
        <label for="txtpangkatkasi">Pangkat</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnipkasi" value="" placeholder="NIP" maxlength="25" autocomplete="off">
        <label for="txtnipkasi">NIP</label>
    </div>

    <div class="form-floating mb-0">
        <input type="text" class="form-control form-control-sm" id="txtnikkasi" value="" placeholder="NIK" maxlength="25" autocomplete="off">
        <label for="txtnikkasi">NIK</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanKasi">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnmseksi").val("");
        $("#cbobagian").val("");
        $("#txtnmkasi").val("");
        $("#txtjabatankasi").val("");
        $("#txtpangkatkasi").val("");
        $("#txtnipkasi").val("");
        $("#txtnikkasi").val("");
    });

    $("#cmdSimpanKasi").click(function() {
        var nmseksi = $('#txtnmseksi').val();
        var idbidang = $('#cbobagian').val();
        var nmpejabat = $('#txtnmkasi').val();
        var jabatan = $('#txtjabatankasi').val();
        var pangkat = $('#txtpangkatkasi').val();
        var nip = $('#txtnipkasi').val();
        var nik = $('#txtnikkasi').val();

        var data = new FormData();
        data.append('nmseksi', nmseksi);
        data.append('idbidang', idbidang);
        data.append('nmpejabat', nmpejabat);
        data.append('jabatan', jabatan);
        data.append('pangkat', pangkat);
        data.append('nip', nip);
        data.append('nik', nik);

        if (nmseksi.length <= 0) {
            $('#txtnmseksi').focus();
            alert('Nama Seksi masih kosong')
        } else if (idbidang.length <= 0) {
            $('#cbobagian').focus();
            alert('Bidang masih kosong')
        } else if (nmpejabat.length <= 0) {
            $('#txtnmkasi').focus();
            alert('Nama kepala seksi masih kosong')
        } else if (jabatan.length <= 0) {
            $('#txtjabatankasi').focus();
            alert('Jabatan masih kosong')
        } else if (pangkat.length <= 0) {
            $('#txtpangkatkasi').focus();
            alert('Pangkat masih kosong')
        } else if (nip.length <= 0) {
            $('#txtnipkasi').focus();
            alert('NIP masih kosong')
        } else if (nik.length <= 0) {
            $('#txtnikkasi').focus();
            alert('NIK masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/seksi/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanKasi").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterSeksi();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanKasi").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanKasi").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanKasi").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>