<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idseksi = trim($_POST['idseksi']);

$qri = ("SELECT nm_seksi,id_bidang,nm_pejabat,jabatan,pangkat,nip,nik FROM tte_m_seksi WHERE id_seksi='" . $idseksi . "'");
$dbquery = mysqli_query($dbconn, $qri);
$c = mysqli_fetch_assoc($dbquery);
$nmseksi = $c['nm_seksi'];
$idbidang = $c['id_bidang'];
$nmpejabat = $c['nm_pejabat'];
$jabatan = $c['jabatan'];
$pangkat = $c['pangkat'];
$nip = $c['nip'];
$nik = $c['nik'];
mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Edit Data Seksi</h5>
        <p class="fs--1 mb-0 text-white">Silahkan edit data seksi</p>
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

    <input class="form-control" type="text" id="txtidSeksiE" value="<?php echo $idseksi; ?>" style="display:none;" />

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmseksiE" value="<?php echo $nmseksi; ?>" placeholder="Nama OPD" maxlength="100" autocomplete="off">
        <label for="txtnmseksiE">Nama Seksi</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <div class="form-floating mb-1" style="display:block">
                <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbobagianE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                <option value="">Pilih bidang</option>
                    <?php
							$qrikec = ("SELECT id_bidang,nm_bidang FROM tte_m_bidang WHERE aktif='Y'");								
							$liskec = mysqli_query($dbconn,$qrikec);									
							while($j=mysqli_fetch_array($liskec)){
								if ($idbidang == $j['id_bidang']){$plhins = "selected";} else {$plhins = "";}
								echo "<option value=\"".$j['id_bidang']."\" $plhins >".$j['nm_bidang']."</option>";
							}mysqli_free_result($liskec);mysqli_close($dbconn);
					?>
                </select>
                <label for="cbobagianE">Pilihan Bidang</label>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmpejabatseksiE" value="<?php echo $nmpejabat; ?>" placeholder="Nama Kepala Dinas" maxlength="100" autocomplete="off">
        <label for="txtnmpejabatseksiE">Nama Kepala Seksi</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtjabatanseksiE" value="<?php echo $jabatan; ?>" placeholder="Jabatan" maxlength="100" autocomplete="off">
        <label for="txtjabatanseksiE">Jabatan</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtpangkatseksiE" value="<?php echo $pangkat; ?>" placeholder="Pangkat" maxlength="25" autocomplete="off">
        <label for="txtpangkatseksiE">Pangkat</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnipseksiE" value="<?php echo $nip; ?>" placeholder="NIP" maxlength="25" autocomplete="off">
        <label for="txtnipseksiE">NIP</label>
    </div>

    <div class="form-floating mb-0">
        <input type="text" class="form-control form-control-sm" id="txtnikseksiE" value="<?php echo $nik; ?>" placeholder="NIK" maxlength="25" autocomplete="off">
        <label for="txtnikseksiE">NIK</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanSeksiE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">

    $("#cmdSimpanSeksiE").click(function() {
        var idseksi = $('#txtidSeksiE').val();
        var nmseksi = $('#txtnmseksiE').val();
        var idbidang = $('#cbobagianE').val();
        var nmpejabat = $('#txtnmpejabatseksiE').val();
        var jabatan = $('#txtjabatanseksiE').val();
        var pangkat = $('#txtpangkatseksiE').val();
        var nip = $('#txtnipseksiE').val();
        var nik = $('#txtnikseksiE').val();

        var data = new FormData();
        data.append('idseksi', idseksi);
        data.append('nmseksi', nmseksi);
        data.append('idbidang', idbidang);
        data.append('nmpejabat', nmpejabat);
        data.append('jabatan', jabatan);
        data.append('pangkat', pangkat);
        data.append('nip', nip);
        data.append('nik', nik);

        if (idseksi.length <= 0) {
            alert('Data Seksi tidak terdeteksi')
        } else if (nmseksi.length <= 0) {
            $('#txtnmseksiE').focus();
            alert('Nama Seksi masih kosong')
        } else if (idbidang.length <= 0) {
            $('#cbobagianE').focus();
            alert('Bidang masih kosong')
        } else if (nmpejabat.length <= 0) {
            $('#txtnmpejabatseksiE').focus();
            alert('Nama kepala seksi masih kosong')
        } else if (jabatan.length <= 0) {
            $('#txtjabatanseksiE').focus();
            alert('Jabatan masih kosong')
        } else if (pangkat.length <= 0) {
            $('#txtpangkatseksiE').focus();
            alert('Pangkat masih kosong')
        } else if (nip.length <= 0) {
            $('#txtnipseksiE').focus();
            alert('NIP masih kosong')
        } else if (nik.length <= 0) {
            $('#txtnikseksiE').focus();
            alert('NIK masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/seksi/aksi_edit.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanSeksiE").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterSeksi();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanSeksiE").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanSeksiE").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanSeksiE").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>