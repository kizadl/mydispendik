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
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterSurveyorSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="all">Semua data</option>
            <option value="umur">Kelompok Umur</option>
            <option value="bentuk pendidikan">Bentuk Pendidikan</option>
            <option value="area">Kecamatan - Desa</option>
            <!-- <option value="kampus">Universitas - Fakultas</option> -->
            <!-- <option value="kategori">Kategori Survei</option> -->
        </select>
        <label for="cboFilterSurveyorSurvei">Filter By</label>
    </div>

    <div class="form-floating mb-0 area-filter-umur-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterumurSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Kelompok umur..</option>
            <option value="7-12">7 s/d 12 Tahun</option>
            <option value="13-15">13 s/d 15 Tahun</option>
            <option value="16-18">16 s/d 18 Tahun</option>
        </select>
        <label for="cboFilterumurSurvei">Kelompok Umur</label>
    </div>

    <div class="form-floating mb-0 area-filter-bentuk-pendidikan-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterPendidikanSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Bentuk pendidikan..</option>
            <?php
            $qribp = ("SELECT DISTINCT bentuk_pendidikan FROM tbl_ats_2025 WHERE bentuk_pendidikan IS NOT NULL ORDER BY bentuk_pendidikan DESC");
            $lisbentukpend = mysqli_query($dbconn, $qribp);
            while ($bp = mysqli_fetch_array($lisbentukpend)) {
                echo "<option value=\"" . $bp['bentuk_pendidikan'] . "\">" . $bp['bentuk_pendidikan'] . "</option>";
            }
            mysqli_free_result($lisbentukpend);
            ?>
        </select>
        <label for="cboFilterPendidikanSurvei">Bentuk Pendidikan</label>
    </div>

    <!-- <div class="form-floating mb-0 area-filter-kategori-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterKategoriSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Kategori..</option>
            <option value="LTM">Lulus Tidak Melanjutkan</option>
            <option value="DO">Drop Out</option>
            <option value="BPB">Belum Pernah Bersekolah</option>
        </select>
        <label for="cboFilterKategoriSurvei">Kategori Survei</label>
    </div>

    <div class="form-floating mb-2 area-filter-kampus-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterUniversitasSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            // $qrikec = ("SELECT id_universitas,nm_universitas FROM ats_universitas_2025 WHERE aktif='Y' ORDER BY nm_universitas ASC");
            // $liskec = mysqli_query($dbconn, $qrikec);
            // while ($j = mysqli_fetch_array($liskec)) {
            //     echo "<option value=\"" . $j['id_universitas'] . "\">" . ucwords(strtolower($j['nm_universitas'])) . "</option>";
            // }
            // mysqli_free_result($liskec);
            ?>
        </select>
        <label for="cboFilterUniversitasSurvei">Filter Universitas</label>
    </div> -->

    <!-- <div class="form-floating mb-0 area-filter-kampus-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterFakultasSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="all">Pilih fakultas</option>
        </select>
        <label for="cboFilterFakultasSurvei">Filter Fakultas</label>
    </div> -->

    <div class="form-floating mb-2 area-filter-kecamatan-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterKecamatanSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
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
        <label for="cboFilterKecamatanSurvei">Filter Area Kecamatan</label>
    </div>

    <div class="form-floating mb-0 area-filter-kecamatan-survei" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterDesaSurvei" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="all">Pilih desa</option>
        </select>
        <label for="cboFilterDesaSurvei">Filter Area Desa</label>
    </div>


</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdTerapkanFilterSurvei">Terapkan Filter</button>
</div>

<script type="text/javascript" charset="utf-8">
    $("#cboFilterSurveyorSurvei").on("change", function() {
        $("#cboFilterumurSurvei").val("");
        $("#cboFilterPendidikanSurvei").val("");
        $("#cboFilterUniversitasSurvei").val("");
        $("#cboFilterFakultasSurvei").val("all");
        $("#cboFilterKecamatanSurvei").val("");
        $("#cboFilterDesaSurvei").val("all");
        $("#cboFilterKategoriSurvei").val("");
        var filter = $("#cboFilterSurveyorSurvei").val();
        if (filter == "all") {
            $(".area-filter-umur-survei").css("display", "none");
            $(".area-filter-bentuk-pendidikan-survei").css("display", "none");
            $(".area-filter-kampus-survei").css("display", "none");
            $(".area-filter-kecamatan-survei").css("display", "none");
            $(".area-filter-kategori-survei").css("display", "none");
        } else if (filter == "area") {
            $(".area-filter-umur-survei").css("display", "none");
            $(".area-filter-bentuk-pendidikan-survei").css("display", "none");
            $(".area-filter-kampus-survei").css("display", "none");
            $(".area-filter-kecamatan-survei").css("display", "block");
            $(".area-filter-kategori-survei").css("display", "none");
        } else if (filter == "kampus") {
            $(".area-filter-umur-survei").css("display", "none");
            $(".area-filter-bentuk-pendidikan-survei").css("display", "none");
            $(".area-filter-kampus-survei").css("display", "block");
            $(".area-filter-kecamatan-survei").css("display", "none");
            $(".area-filter-kategori-survei").css("display", "none");
        } else if (filter == "umur") {
            $(".area-filter-umur-survei").css("display", "block");
            $(".area-filter-bentuk-pendidikan-survei").css("display", "none");
            $(".area-filter-kampus-survei").css("display", "none");
            $(".area-filter-kecamatan-survei").css("display", "none");
            $(".area-filter-kategori-survei").css("display", "none");
        } else if (filter == "bentuk pendidikan") {
            $(".area-filter-umur-survei").css("display", "none");
            $(".area-filter-bentuk-pendidikan-survei").css("display", "block");
            $(".area-filter-kampus-survei").css("display", "none");
            $(".area-filter-kecamatan-survei").css("display", "none");
            $(".area-filter-kategori-survei").css("display", "none");
        } else if (filter == "kategori") {
            $(".area-filter-umur-survei").css("display", "none");
            $(".area-filter-bentuk-pendidikan-survei").css("display", "none");
            $(".area-filter-kampus-survei").css("display", "none");
            $(".area-filter-kecamatan-survei").css("display", "none");
            $(".area-filter-kategori-survei").css("display", "block");
        }
    });

    $("#cboFilterUniversitasSurvei").on("change", function() {
        var iduniversitas = $('#cboFilterUniversitasSurvei').val();
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
                $("#cboFilterFakultasSurvei").empty()
                $("#cboFilterFakultasSurvei").append('<option value="all">Pilih fakultas</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cboFilterFakultasSurvei").append('<option value="' + data[i].idfakultas + '">' + data[i].nmfakultas + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cboFilterKecamatanSurvei").on("change", function() {
        var idkecamatan = $("#cboFilterKecamatanSurvei").val()
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

                $("#cboFilterDesaSurvei").empty()
                $("#cboFilterDesaSurvei").append('<option value="all">Pilih desa</option>')
                var i;
                for (i = 0; i < data.length; i++) {
                    $("#cboFilterDesaSurvei").append('<option value="' + data[i].iddesa + '">' + data[i].nmdesa + '</option>')
                }
            },
            error: function() {
                console.log("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    });

    $("#cmdTerapkanFilterSurvei").click(function() {
        bersihkanFilter();
        var filter = $("#cboFilterSurveyorSurvei").val();
        if (filter == "all") {
            $("#lblkopfiltersurvei").html("Semua data survei"); //****** kop filter ******/
            $("#txtfilterdataSurvei").val("all");
            $("#txtketfilterexportSurvei").val("Semua data survei");
            isiHasilSurvei();
            setTimeout(function() {
                $('#modTambahDataLarge').modal('hide');
            }, 1000);
        } else if (filter == "area") {
            var idkecamatan = $("#cboFilterKecamatanSurvei").val();
            var namakecamatan = $("#cboFilterKecamatanSurvei :selected").text();
            var iddesa = $("#cboFilterDesaSurvei").val();
            var namadesa = $("#cboFilterDesaSurvei :selected").text();
            if (idkecamatan == "") {
                $("#cboFilterKecamatanSurvei").focus();
                alert("Area kecamatan belum ditentukan")
            } else if (idkecamatan != "" && iddesa == "all") {
                $("#txtfilterdataSurvei").val("kecamatan");
                $("#txtfilteridkecamatanSurvei").val(idkecamatan);
                $("#txtfilteriddesaSurvei").val("all");
                $("#lblkopfiltersurvei").html("Filter data survei by " + namakecamatan); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Survei " + namakecamatan);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            } else if (idkecamatan != "" && iddesa != "all") {
                $("#txtfilterdataSurvei").val("desa");
                $("#txtfilteridkecamatanSurvei").val(idkecamatan);
                $("#txtfilteriddesaSurvei").val(iddesa);
                $("#lblkopfiltersurvei").html("Filter data survei by " + namakecamatan + " - " + namadesa); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Survei " + namakecamatan + " - " + namadesa);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "kampus") {
            var iduniversitas = $("#cboFilterUniversitasSurvei").val();
            var namauniversitas = $("#cboFilterUniversitasSurvei :selected").text();
            var idfakultas = $("#cboFilterFakultasSurvei").val();
            var namafakultas = $("#cboFilterFakultasSurvei :selected").text();
            if (iduniversitas == "") {
                $("#cboFilterUniversitasSurvei").focus();
                alert("Universitas belum ditentukan")
            } else if (iduniversitas != "" && idfakultas == "all") {
                $("#txtfilterdataSurvei").val("universitas");
                $("#txtfilteriduniversitasSurvei").val(iduniversitas);
                $("#txtfilteridfakultasSurvei").val("all");
                $("#lblkopfiltersurvei").html("Filter data survei by " + namauniversitas); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Survei " + namauniversitas);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            } else if (iduniversitas != "" && idfakultas != "all") {
                $("#txtfilterdataSurvei").val("fakultas");
                $("#txtfilteriduniversitasSurvei").val(iduniversitas);
                $("#txtfilteridfakultasSurvei").val(idfakultas);
                $("#lblkopfiltersurvei").html("Filter data survei by " + namauniversitas + " - " + namafakultas); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Survei " + namauniversitas + " - " + namafakultas);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "umur") {
            var umur = $("#cboFilterumurSurvei").val();
            var namaumur = $("#cboFilterumurSurvei :selected").text();
            if (umur == "") {
                $("#cboFilterumurSurvei").focus();
                alert("Kelompok umur belum ditentukan")
            } else {
                $("#txtfilterdataSurvei").val("umur");
                $("#txtfilterumurSurvei").val(umur);
                $("#lblkopfiltersurvei").html("Filter data survei by kelompok umur " + namaumur); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Survei Kelompok Umur " + namaumur);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "bentuk pendidikan") {
            var bentukpendidikan = $("#cboFilterPendidikanSurvei").val();
            var namabentukpendidikan = $("#cboFilterPendidikanSurvei :selected").text();
            if (bentukpendidikan == "") {
                $("#cboFilterPendidikanSurvei").focus();
                alert("Bentuk pendidikan belum ditentukan")
            } else {
                $("#txtfilterdataSurvei").val("bentuk pendidikan");
                $("#txtfilterbentukpendidikanSurvei").val(bentukpendidikan);
                $("#lblkopfiltersurvei").html("Filter data survei by bentuk pendidikan " + namabentukpendidikan); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Survei Bentuk Pendidikan " + namabentukpendidikan);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            }
        } else if (filter == "kategori") {
            var kategori = $("#cboFilterKategoriSurvei").val();
            var namakategori = $("#cboFilterKategoriSurvei :selected").text();
            if (kategori == "") {
                $("#cboFilterKategoriSurvei").focus();
                alert("Kategori survei belum ditentukan")
            } else {
                $("#txtfilterdataSurvei").val("kategori");
                $("#txtfilterkategorisurvei").val(kategori);
                $("#lblkopfiltersurvei").html("Filter data survei by kategori survei " + namakategori); //****** kop filter ******/
                $("#txtketfilterexportSurvei").val("Data Kategori Survei " + namakategori);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiHasilSurvei();
            }
        }
    });
</script>