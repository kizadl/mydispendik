<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Filter Data Survei</h5>
        <p class="fs--1 mb-0 text-white">Silahkan pilih opsi filter data survei</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Pilih opsi <strong>Filter By</strong> untuk mode tampilan data,
                        Tekan tombol <strong>Terapkan filter</strong> untuk menampilkan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterSurveyor" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="all">Semua data</option>
            <option value="umur">Kelompok Umur</option>
            <option value="bentuk pendidikan">Bentuk Pendidikan</option>
            <option value="area">Kecamatan - Desa</option>
            <option value="kampus">Universitas - Fakultas</option>
            <option value="kategori">Kategori Survei</option>
            <option value="catatan">Catatan Survei</option>
        </select>
        <label for="cboFilterSurveyor">Filter By</label>
    </div>

    <div class="form-floating mb-0 area-filter-umur" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterumur" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Kelompok umur..</option>
            <option value="7-12">7 s/d 12 Tahun</option>
            <option value="13-15">13 s/d 15 Tahun</option>
            <option value="16-18">16 s/d 18 Tahun</option>
        </select>
        <label for="cboFilterumur">Kelompok Umur</label>
    </div>
    
    <div class="form-floating mb-0 area-filter-bentuk-pendidikan" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterPendidikan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Bentuk pendidikan..</option>
            <?php
            $qribp = ("SELECT DISTINCT bentuk_pendidikan FROM tbl_ats WHERE bentuk_pendidikan IS NOT NULL ORDER BY bentuk_pendidikan DESC");
            $lisbentukpend = mysqli_query($dbconn, $qribp);
            while ($bp = mysqli_fetch_array($lisbentukpend)) {
                echo "<option value=\"" . $bp['bentuk_pendidikan'] . "\">" .$bp['bentuk_pendidikan']. "</option>";
            }
            mysqli_free_result($lisbentukpend);
            ?>
        </select>
        <label for="cboFilterPendidikan">Bentuk Pendidikan</label>
    </div>

    <div class="form-floating mb-0 area-filter-kategori-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterKategori" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Kategori..</option>
            <option value="LM">Lulus Melanjutkan</option>
            <option value="PS">Pindah Sekolah</option>
            <option value="MLN">Melanjutkan Luar Negeri</option>
            <option value="MP">Melanjutkan Pesantren</option>
            <option value="LTM">Lulus Tidak Melanjutkan</option>
            <option value="DO">Drop Out</option>
            <option value="MD">Mengundurkan Diri</option>
            <option value="PTS">Putus Sekolah</option>
            <option value="HL">Hilang</option>
            <option value="WFT">Meninggal Dunia</option>
            <option value="AK">Aktif Kembali</option>
        </select>
        <label for="cboFilterKategori">Kategori Survei</label>
    </div>

    <div class="form-floating mb-0 area-filter-catatan-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterCatatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Catatan survei..</option>
            <?php
            $qrict = ("SELECT * FROM ats_catatan_survei");
            $listcatatan = mysqli_query($dbconn, $qrict);
            while ($ct = mysqli_fetch_array($listcatatan)) {
                echo "<option value=\"" . $ct['id_catatan'] . "\">" .$ct['catatan']. "</option>";
            }
            mysqli_free_result($listcatatan);
            ?>
        </select>
        <label for="cboFilterCatatan">Catatan Survei</label>
    </div>

    <div class="form-floating mb-2 area-filter-kampus" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterUniversitas" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            $qrikec = ("SELECT id_universitas,nm_universitas FROM ats_universitas WHERE aktif='Y' ORDER BY nm_universitas ASC");
            $liskec = mysqli_query($dbconn, $qrikec);
            while ($j = mysqli_fetch_array($liskec)) {
                echo "<option value=\"" . $j['id_universitas'] . "\">" . ucwords(strtolower($j['nm_universitas'])) . "</option>";
            }
            mysqli_free_result($liskec);
            ?>
        </select>
        <label for="cboFilterUniversitas">Filter Universitas</label>
    </div>

    <div class="form-floating mb-0 area-filter-kampus" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterFakultas" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="all">Pilih fakultas</option>
        </select>
        <label for="cboFilterFakultas">Filter Fakultas</label>
    </div>
    
    <div class="form-floating mb-2 area-filter-kecamatan" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterKecamatan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih kecamatan</option>
            <?php
            $sqlkc = ("SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan ASC");
            $resultkc = mysqli_query($dbconn, $sqlkc);
            while ($kc = mysqli_fetch_array($resultkc)) {
                $kdkecamatan = $kc['kd_kecamatan'];
                $namakecamatan = ucwords(strtolower($kc['nama_kecamatan']));
                echo "
                        <option value='$kdkecamatan'>$namakecamatan</option>";
            }
            mysqli_free_result($resultkc);
            mysqli_close($dbconn);
            ?>
        </select>
        <label for="cboFilterKecamatan">Filter Area Kecamatan</label>
    </div>

    <div class="form-floating mb-0 area-filter-kecamatan" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterDesa" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="all">Pilih desa</option>
        </select>
        <label for="cboFilterDesa">Filter Area Desa</label>
    </div>


</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdTerapkanFilter">Terapkan Filter</button>
</div>

<script type="text/javascript" charset="utf-8">

    $("#cboFilterSurveyor").on("change",function() {
        $("#cboFilterumur").val("");
        $("#cboFilterPendidikan").val("");
        $("#cboFilterUniversitas").val("");$("#cboFilterFakultas").val("all");
        $("#cboFilterKecamatan").val("");$("#cboFilterDesa").val("all");
        $("#cboFilterKategori").val("");
        $("#cboFilterCatatan").val("");
        var filter = $("#cboFilterSurveyor").val();
        if (filter == "all"){
            $(".area-filter-umur").css("display","none");
            $(".area-filter-bentuk-pendidikan").css("display","none");
            $(".area-filter-kampus").css("display","none");
            $(".area-filter-kecamatan").css("display","none");
            $(".area-filter-kategori-survei").css("display","none");
            $(".area-filter-catatan-survei").css("display","none");
        } else if (filter == "area"){
            $(".area-filter-umur").css("display","none");
            $(".area-filter-bentuk-pendidikan").css("display","none");
            $(".area-filter-kampus").css("display","none");
            $(".area-filter-kecamatan").css("display","block");
            $(".area-filter-kategori-survei").css("display","none");
            $(".area-filter-catatan-survei").css("display","none");
        } else if (filter == "kampus"){
            $(".area-filter-umur").css("display","none");
            $(".area-filter-bentuk-pendidikan").css("display","none");
            $(".area-filter-kampus").css("display","block");
            $(".area-filter-kecamatan").css("display","none");
            $(".area-filter-kategori-survei").css("display","none");
            $(".area-filter-catatan-survei").css("display","none");
        } else if (filter == "umur"){
            $(".area-filter-umur").css("display","block");
            $(".area-filter-bentuk-pendidikan").css("display","none");
            $(".area-filter-kampus").css("display","none");
            $(".area-filter-kecamatan").css("display","none");
            $(".area-filter-kategori-survei").css("display","none");
            $(".area-filter-catatan-survei").css("display","none");
        } else if (filter == "bentuk pendidikan"){
            $(".area-filter-umur").css("display","none");
            $(".area-filter-bentuk-pendidikan").css("display","block");
            $(".area-filter-kampus").css("display","none");
            $(".area-filter-kecamatan").css("display","none");
            $(".area-filter-kategori-survei").css("display","none");
            $(".area-filter-catatan-survei").css("display","none");
        } else if (filter == "kategori"){
            $(".area-filter-umur").css("display","none");
            $(".area-filter-bentuk-pendidikan").css("display","none");
            $(".area-filter-kampus").css("display","none");
            $(".area-filter-kecamatan").css("display","none");
            $(".area-filter-kategori-survei").css("display","block");
            $(".area-filter-catatan-survei").css("display","none");
        } else if (filter == "catatan"){
            $(".area-filter-umur").css("display","none");
            $(".area-filter-bentuk-pendidikan").css("display","none");
            $(".area-filter-kampus").css("display","none");
            $(".area-filter-kecamatan").css("display","none");
            $(".area-filter-kategori-survei").css("display","none");
            $(".area-filter-catatan-survei").css("display","block");
        }
    });

    $("#cboFilterUniversitas").on("change", function() {
        var iduniversitas = $('#cboFilterUniversitas').val();
        $.ajax({
            type: "POST",
            url: "aksi/filter/ambil_data_fakultas.php",
            data: {
                iduniversitas: iduniversitas
            },
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";
                $("#cboFilterFakultas").empty()
                $("#cboFilterFakultas").append('<option value="all">Pilih fakultas</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cboFilterFakultas").append('<option value="' + data[i].idfakultas + '">' + data[i].nmfakultas + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cboFilterKecamatan").on("change", function() {
        var idkecamatan = $("#cboFilterKecamatan").val()
        $.ajax({
            type: "POST",
            url: "aksi/filter/ambil_data_desa.php",
            data: {
                idkecamatan: idkecamatan
            },
            dataType: 'json',
            beforeSend: function(e) {
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";

                $("#cboFilterDesa").empty()
                $("#cboFilterDesa").append('<option value="all">Pilih desa</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cboFilterDesa").append('<option value="' + data[i].iddesa + '">' + data[i].nmdesa + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cmdTerapkanFilter").click(function() {
        bersihkanFilter();
        var filter = $("#cboFilterSurveyor").val();
        if (filter == "all"){
            $("#lblkopfiltersurvei").html("Semua data survei");//****** kop filter ******/
            $("#txtfilterdata").val("all");
            $("#txtketfilterexport").val("Semua data survei");
            isiHasilSurvei();
            setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
        } else if (filter == "area"){
            var idkecamatan = $("#cboFilterKecamatan").val();var namakecamatan = $("#cboFilterKecamatan :selected").text();
            var iddesa = $("#cboFilterDesa").val();var namadesa = $("#cboFilterDesa :selected").text();
            if (idkecamatan == ""){
                $("#cboFilterKecamatan").focus();
                alert("Area kecamatan belum ditentukan")
            } else if (idkecamatan != "" && iddesa == "all") {
                $("#txtfilterdata").val("kecamatan");
                $("#txtfilteridkecamatan").val(idkecamatan);
	            $("#txtfilteriddesa").val("all");
                $("#lblkopfiltersurvei").html("Filter data survei by " + namakecamatan);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Survei "+namakecamatan);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            } else if (idkecamatan != "" && iddesa != "all") {
                $("#txtfilterdata").val("desa");
                $("#txtfilteridkecamatan").val(idkecamatan);
	            $("#txtfilteriddesa").val(iddesa);
                $("#lblkopfiltersurvei").html("Filter data survei by " + namakecamatan + " - " + namadesa);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Survei "+namakecamatan + " - " + namadesa);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "kampus"){
            var iduniversitas = $("#cboFilterUniversitas").val();var namauniversitas = $("#cboFilterUniversitas :selected").text();
            var idfakultas = $("#cboFilterFakultas").val();var namafakultas = $("#cboFilterFakultas :selected").text();
            if (iduniversitas == ""){
                $("#cboFilterUniversitas").focus();
                alert("Universitas belum ditentukan")
            } else if (iduniversitas != "" && idfakultas == "all") {
                $("#txtfilterdata").val("universitas");
                $("#txtfilteriduniversitas").val(iduniversitas);
	            $("#txtfilteridfakultas").val("all");
                $("#lblkopfiltersurvei").html("Filter data survei by " + namauniversitas);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Survei "+namauniversitas);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            } else if (iduniversitas != "" && idfakultas != "all") {
                $("#txtfilterdata").val("fakultas");
                $("#txtfilteriduniversitas").val(iduniversitas);
	            $("#txtfilteridfakultas").val(idfakultas);
                $("#lblkopfiltersurvei").html("Filter data survei by " + namauniversitas + " - " + namafakultas);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Survei "+namauniversitas + " - " + namafakultas);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "umur"){
            var umur = $("#cboFilterumur").val();var namaumur = $("#cboFilterumur :selected").text();
            if (umur == ""){
                $("#cboFilterumur").focus();
                alert("Kelompok umur belum ditentukan")
            } else {
                $("#txtfilterdata").val("umur");
                $("#txtfilterumur").val(umur);
                $("#lblkopfiltersurvei").html("Filter data survei by kelompok umur " + namaumur);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Survei Kelompok Umur "+namaumur);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "bentuk pendidikan"){
            var bentukpendidikan = $("#cboFilterPendidikan").val();var namabentukpendidikan = $("#cboFilterPendidikan :selected").text();
            if (bentukpendidikan == ""){
                $("#cboFilterPendidikan").focus();
                alert("Bentuk pendidikan belum ditentukan")
            } else {
                $("#txtfilterdata").val("bentuk pendidikan");
                $("#txtfilterbentukpendidikan").val(bentukpendidikan);
                $("#lblkopfiltersurvei").html("Filter data survei by bentuk pendidikan " + namabentukpendidikan);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Survei Bentuk Pendidikan "+namabentukpendidikan);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "kategori"){
            var kategori = $("#cboFilterKategori").val();var namakategori = $("#cboFilterKategori :selected").text();
            if (kategori == ""){
                $("#cboFilterKategori").focus();
                alert("Kategori survei belum ditentukan")
            } else {
                $("#txtfilterdata").val("kategori");
                $("#txtfilterkategorisurvei").val(kategori);
                $("#lblkopfiltersurvei").html("Filter data survei by kategori survei " + namakategori);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Kategori Survei "+namakategori);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "catatan"){
            var idcatatan = $("#cboFilterCatatan").val();var namacatatan = $("#cboFilterCatatan :selected").text();
            if (idcatatan == ""){
                $("#cboFilterCatatan").focus();
                alert("Catatan survei belum ditentukan")
            } else {
                $("#txtfilterdata").val("catatan");
                $("#txtfilteridcatatansurvei").val(idcatatan);
                $("#lblkopfiltersurvei").html("Filter data survei by catatan survei " + namacatatan);//****** kop filter ******/
                $("#txtketfilterexport").val("Data Catatan Survei "+namacatatan);
                setTimeout(function() {$('#modTambahDataLarge').modal('hide');}, 1000);
                isiHasilSurvei();
            }
        }
    });
</script>