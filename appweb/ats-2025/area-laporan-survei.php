<div id="area-laporan-survei" style="display:none">

    <div class="row mb-3 g-3">
        <div class="col-md-12 col-xxl-12">
            <div class="card h-100">
                <div class="card-header mt-0 mb-0 g-0 bg-line-chart-gradient">
                    <div class="row flex-between-center">
                        <div class="col-4 col-sm-auto align-items-center pe-0">
                            <h5 class="fs-0 text-white mb-0">Laporan <span class="lblsubkoplaporan"></span></h5>
                        </div>
                        <div class="col-8 col-sm-auto align-items-center text-end ps-0">
                            <table>
                                <tr>
                                    <td>
                                        <select class="form-select form-select-sm mb-3" id="cbokecamatanhasilsurvei" style="width:200px;">
                                            <option value="all">Kabupaten Jember</option>
                                            <?php
                                            $menuutama = mysqli_query($dbconn, "SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan ASC");
                                            while ($dm = mysqli_fetch_array($menuutama)) {
                                                $idkec = $dm['kd_kecamatan'];
                                                $nmkecamatan = $dm['nama_kecamatan'];
                                                echo "<option value='$idkec'>$nmkecamatan</option>";
                                            }
                                            mysqli_free_result($menuutama);
                                            ?>
                                        </select>
                                    </td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>
                                        <select class="form-select form-select-sm mb-3" id="cbodesahasilsurvei" style="width:200px;">
                                            <option value="all">-</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <h6 class="text-primary fs--1 mb-2">Klik Angka-angka Untuk Export Laporan <span class="lblsubkoplaporan"></span></h6>
                    <div class="row flex-between-center mt-2 g-2">
                        <div class="col-12 col-sm-auto">
                            <div class="mb-1 pe-4" role="button" id="cmdExportLapSurveyor">
                                <h6 class="fs--2 text-800 mb-1">Jumlah Surveyor</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="lbljumlahSurveyor">0</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto">
                            <div class="mb-1 pe-0" role="button" id="cmdExportLapSurveyorSudah">
                                <h6 class="fs--2 text-800 mb-1">Surveyor Sudah Survei</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="lblJumlahSurveyorSudah">0</h5><span class="badge rounded-pill badge-soft-primary" id="lblpersenSurveyorSudah"><span class="fas fa-caret-up"></span> 0%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto">
                            <div class="mb-1 pe-4" role="button" id="cmdExportLapSurveyorBelum">
                                <h6 class="fs--2 text-800 mb-1">Surveyor Belum Survei</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="lblJumlahSurveyorBelum">0</h5><span class="badge rounded-pill badge-soft-danger" id="lblpersenSurveyorBelum"><span class="fas fa-caret-up"></span> 0%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row flex-between-center mt-2 g-2 bg-200">
                        <div class="col-12 col-sm-auto">
                            <div class="mb-1 pe-4" role="button" id="cmdExportLapATS">
                                <h6 class="fs--2 text-800 mb-1">Jumlah ATS</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="lbljumlahATS">0</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto">
                            <div class="mb-1 pe-0" role="button" id="cmdExportLapTarget">
                                <h6 class="fs--2 text-800 mb-1">Pencapaian Target</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="lbljumlahSurvei">0</h5><span class="badge rounded-pill badge-soft-success" id="lblpersensurvei"><span class="fas fa-caret-up"></span> 0%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto">
                            <div class="mb-1 pe-4" role="button" id="cmdExportLapTargetBelum">
                                <h6 class="fs--2 text-800 mb-1">ATS Belum Survei</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="lbljumlahBelumSurvei">0</h5><span class="badge rounded-pill badge-soft-danger" id="lblpersenbelumsurvei"><span class="fas fa-caret-up"></span> 0%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Tabel Data Hasil Survei</h5>
                    <div class="d-flex align-items-center"><span class="dot bg-primary"></span><span class="fs--1 lblsubkoplaporan"></span></div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-0">
            <div class="table-responsive scrollbar">
                <table id="tableLapArea" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th rowspan="2" class="sort align-middle text-center bg-300">Wilayah Survei</th>
                            <th colspan="5" class="sort text-center">Surveyor</th>
                            <th colspan="5" class="sort text-center bg-300">ATS</th>
                        </tr>
                        <tr>
                            <th class="sort text-center">Belum</th>
                            <th class="sort text-center">%</th>
                            <th class="sort text-center">Sudah</th>
                            <th class="sort text-center">%</th>
                            <th class="sort text-center">Jumlah</th>
                            
                            <th class="sort text-center bg-300">Belum</th>
                            <th class="sort text-center bg-300">%</th>
                            <th class="sort text-center bg-300">Sudah</th>
                            <th class="sort text-center bg-300">%</th>
                            <th class="sort text-center bg-300">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableLapArea"></tbody>
                </table>
            </div>

        </div>
    </div>
                                        -->
    <div class="row mb-3 g-3">
        <div class="col-xxl-6 px-xxl-2">
            <div class="card bg-line-chart-gradient h-lg-100">
                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <p class="fs--1 fw-semi-bold">Grafik Hasil Survei Berdasarkan Kategori ATS <span class="lblkoplaporan"></span>
                                <br><span class="dot bg-info"></span><span class="fs--1 lblsubkoplaporan"></span>
                            </p>
                        </div>
                    </div>
                    <div id="chart-container-hasil"></div>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Tabel Data Persentase Kategori Survei</h5>
                    <div class="d-flex align-items-center"><span class="dot bg-primary"></span><span class="fs--1 lblsubkoplaporan"></span></div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-0">
            <div class="table-responsive scrollbar">
                <table id="tableLapHasilSurvei" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Kategori</th>
                            <th class="sort text-center">L</th>
                            <th class="sort text-center">P</th>
                            <th class="sort text-center">Jumlah</th>
                            <th class="sort text-center">%</th>
                            <th class="sort text-center">Export</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableLapHasilSurvei"></tbody>
                </table>
            </div>

        </div>
    </div>
                                        -->
</div>