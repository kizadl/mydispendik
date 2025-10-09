<div id="area-dashboard" style="display:none">

    <div class="row mb-3 g-3">
        <div class="col-xxl-6 px-xxl-2">
            <div class="card bg-line-chart-gradient h-lg-100">
                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">

                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <p class="fs--1 fw-semi-bold">Grafik Anak Tidak Sekolah Berdasarkan Bentuk Lembaga <span class="lblkopgrafik1"></span></p>
                        </div>
                        <div class="col-auto d-none d-sm-block me-2">
                            <select class="form-select form-select-sm mb-3" id="cbokecamatanspm" style="width:200px;">
                                <option value="all">Kabupaten Jember</option>
                                <?php
                                $menuutama = mysqli_query($dbconn, "SELECT DISTINCT kd_kecamatan, kecamatan FROM tbl_ats_2025 ORDER BY kd_kecamatan ASC");
                                while ($dm = mysqli_fetch_array($menuutama)) {
                                    $idkec = $dm['kd_kecamatan'];
                                    $nmkecamatan = $dm['kecamatan'];
                                    echo "<option value='$idkec'>$nmkecamatan</option>";
                                }
                                mysqli_free_result($menuutama);
                                ?>
                            </select>
                        </div>
                        <!--div class="col-auto d-none d-sm-block">
                            <select class="form-select form-select-sm mb-3" id="cbodesaspm" style="width:200px;">
                            </select>
                        </!--div-->
                    </div>

                    <div class="chart h-100" id="hitungUmurChart" data-echart-responsive="true">
                        <canvas id="umurChart" height="250px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 g-3">
        <div class="col-xxl-6 px-xxl-2">
            <div class="card bg-line-chart-gradient h-lg-100">
                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                    <div class="col light">
                        <p class="fs--1 fw-semi-bold">Grafik Anak Tidak Sekolah Berdasarkan Status Sekolah <span class="lblkopgrafik1"></span></p>
                    </div>
                    <div class="chart h-100" id="hitungChartContentADMIN" data-echart-responsive="true">
                        <canvas id="hitungChartADMIN" height="250px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 g-3">
        <div class="col-lg-4 ps-lg-2">
            <div class="card bg-line-chart-gradient h-lg-100">
                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                    <div class="col light">
                        <p class="fs--1 fw-semi-bold">Grafik Anak Tidak Sekolah Berdasarkan Status <span class="lblkopgrafik1"></span></p>
                    </div>
                    <div class="chart h-100" id="hitungChartContentAkreditasi" data-echart-responsive="true">
                        <canvas id="hitungChartAkreditasi" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 ps-lg-2">
            <div class="card bg-line-chart-gradient h-lg-100">
                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                    <div class="col light">
                        <p class="fs--1 fw-semi-bold">Grafik Anak Tidak Sekolah Berdasarkan Kelamin <span class="lblkopgrafik1"></span></p>
                    </div>
                    <div class="chart h-100" id="hitungChartKelamin" data-echart-responsive="true">
                        <canvas id="hitungKelamin" height="250px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 ps-lg-2">
            <div class="card bg-line-chart-gradient h-lg-100">
                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                    <div class="col light">
                        <p class="fs--1 fw-semi-bold">Grafik Anak Tidak Sekolah Kelompok Umur <span class="lblkopgrafik1"></span></p>
                    </div>
                    <div class="chart h-100" id="hitungChartKelompokUmur" data-echart-responsive="true">
                        <canvas id="hitungKelompokUmur" height="250px"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>