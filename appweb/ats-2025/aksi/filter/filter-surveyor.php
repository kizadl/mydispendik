<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Filter Data Surveyor</h5>
        <p class="fs--1 mb-0 text-white">Silahkan pilih opsi filter data</p>
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
            <option value="area">Kecamatan - Desa</option>
            <option value="kampus">Universitas - Fakultas</option>
        </select>
        <label for="cboFilterSurveyor">Filter By</label>
    </div>

    <div class="form-floating mb-2 area-filter-kampus" style="display:none">
        <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboFilterUniversitas" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih universitas</option>
            <?php
            $qrikec = ("SELECT id_universitas,nm_universitas FROM ats_universitas_2025 WHERE aktif='Y' ORDER BY nm_universitas ASC");
            $liskec = mysqli_query($dbconn, $qrikec);
            while ($j = mysqli_fetch_array($liskec)) {
                if ($iduniversitas == $j['id_universitas']) {
                    $plhins = "selected";
                } else {
                    $plhins = "";
                }
                echo "<option value=\"" . $j['id_universitas'] . "\" $plhins >" . ucwords(strtolower($j['nm_universitas'])) . "</option>";
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
    $("#cboFilterSurveyor").on("change", function() {
        $("#cboFilterUniversitas").val("");
        $("#cboFilterFakultas").val("all");
        $("#cboFilterKecamatan").val("");
        $("#cboFilterDesa").val("all");
        var filter = $("#cboFilterSurveyor").val();
        if (filter == "all") {
            $(".area-filter-kampus").css("display", "none");
            $(".area-filter-kecamatan").css("display", "none");
        } else if (filter == "area") {
            $(".area-filter-kampus").css("display", "none");
            $(".area-filter-kecamatan").css("display", "block");
        } else if (filter == "kampus") {
            $(".area-filter-kampus").css("display", "block");
            $(".area-filter-kecamatan").css("display", "none");
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
        if (filter == "all") {
            $("#lblkopfiltersurveyor").html("Semua data surveyor"); //****** kop filter ******/
            $("#txtketfilter").val("all");
            $("#txtketfilterdata").val("Semua data surveyor");
            isiMasterSurveyor();
            setTimeout(function() {
                $('#modTambahDataLarge').modal('hide');
            }, 1000);
        } else if (filter == "area") {
            var idkecamatan = $("#cboFilterKecamatan").val();
            var namakecamatan = $("#cboFilterKecamatan :selected").text();
            var iddesa = $("#cboFilterDesa").val();
            var namadesa = $("#cboFilterDesa :selected").text();
            if (idkecamatan == "") {
                $("#cboFilterKecamatan").focus();
                alert("Area kecamatan belum ditentukan")
            } else if (idkecamatan != "" && iddesa == "all") {
                $("#txtketfilter").val("kecamatan");
                $("#txtfilteridkecamatan").val(idkecamatan);
                $("#txtfilteriddesa").val("all");
                $("#lblkopfiltersurveyor").html("Filter data surveyor by " + namakecamatan); //****** kop filter ******/
                $("#txtketfilterdata").val("Data Surveyor " + namakecamatan);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiMasterSurveyor();
            } else if (idkecamatan != "" && iddesa != "all") {
                $("#txtketfilter").val("desa");
                $("#txtfilteridkecamatan").val(idkecamatan);
                $("#txtfilteriddesa").val(iddesa);
                $("#lblkopfiltersurveyor").html("Filter data surveyor by " + namakecamatan + " - " + namadesa); //****** kop filter ******/
                $("#txtketfilterdata").val("Data Surveyor " + namakecamatan + " - " + namadesa);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiMasterSurveyor();
            }
        } else if (filter == "kampus") {
            var iduniversitas = $("#cboFilterUniversitas").val();
            var namauniversitas = $("#cboFilterUniversitas :selected").text();
            var idfakultas = $("#cboFilterFakultas").val();
            var namafakultas = $("#cboFilterFakultas :selected").text();
            if (iduniversitas == "") {
                $("#cboFilterUniversitas").focus();
                alert("Universitas belum ditentukan")
            } else if (iduniversitas != "" && idfakultas == "all") {
                $("#txtketfilter").val("universitas");
                $("#txtfilteriduniversitas").val(iduniversitas);
                $("#txtfilteridfakultas").val("all");
                $("#lblkopfiltersurveyor").html("Filter data surveyor by " + namauniversitas); //****** kop filter ******/
                $("#txtketfilterdata").val("Data Surveyor " + namauniversitas);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiMasterSurveyor();
            } else if (iduniversitas != "" && idfakultas != "all") {
                $("#txtketfilter").val("fakultas");
                $("#txtfilteriduniversitas").val(iduniversitas);
                $("#txtfilteridfakultas").val(idfakultas);
                $("#lblkopfiltersurveyor").html("Filter data surveyor by " + namauniversitas + " - " + namafakultas); //****** kop filter ******/
                $("#txtketfilterdata").val("Data Surveyor " + namauniversitas + " - " + namafakultas);
                setTimeout(function() {
                    $('#modTambahDataLarge').modal('hide');
                }, 1000);
                isiMasterSurveyor();
            }
        }
    });
</script>