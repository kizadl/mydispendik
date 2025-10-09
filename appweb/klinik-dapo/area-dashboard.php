<div class="col-xxl-12" id="area-dashboard" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tentukan <strong>Range Tanggal</strong> terlebih dahulu, kemudian
                        tekan tombol <strong>Refresh</strong> untuk menampilkan data <strong>Grafik</strong><br />
                        Tombol <strong>Rekapitulasi</strong> untuk export data excel <strong>Layanan</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-0">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Dashboard Layanan</h5>
                    <span class="fs--1" id="lblkopperiode">Periode <?php echo $tglpicindo; ?> s/d <?php echo $tglpic2indo; ?></span>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <table>
                        <tr>
                            <td width="240px">
                                <div class="input-group input-group-sm">
                                    <input class="form-control form-control-sm datetimepicker ps-4" id="txttanggaldashboard" type="text" data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;d-m-Y&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;<?php echo $awalbulan; ?>&quot;, &quot;<?php echo $akhirbulan; ?>&quot;] }" />
                                    <span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-1">
                                    </span>
                                </div>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshDashboard"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                            </td>
                            <!--
                            <td>&nbsp;</td>
                            <td>
                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRekapDashboard"><span class="d-none d-sm-inline-block ms-1">Export Excel</span></button>
                            </td>
                            -->
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">
            <div class="row mb-3 g-3">
                <div class="col-xxl-6 px-xxl-2">
                    <div class="card bg-line-chart-gradient h-lg-100">
                        <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                            <div class="col light">
                                <p class="fs--1 fw-semi-bold">Grafik Layanan</p>
                            </div>
                            <div class="chart h-100" id="hitungChartGrafik" data-echart-responsive="true">
                                <canvas id="ChartGrafik" height="300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3" id="area-dashboard-pengaduan" style="display:none">
    <div class="col-xxl-9">
        <div class="card rounded-3 overflow-hidden h-100">
            <div class="card-body bg-line-chart-gradient d-flex flex-column justify-content-between">
                <div class="row align-items-center g-0">
                    <div class="col light">
                        <h6 class="fs-0 text-white mb-0">Grafik Pengaduan</h6>
                        <p class="fs--1 fw-semi-bold text-white"><span class="fs--1" id="lblkopperiode">Periode <?php echo $tglpicindo; ?> s/d <?php echo $tglpic2indo; ?></span></p>
                    </div>
                    <div class="col-md-auto position-relative mb-4 me-2">
                        <input class="form-control form-control-sm datetimepicker ps-4" id="txttanggaldashboarddapo" type="text" data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;d-m-Y&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;<?php echo $awalbulan; ?>&quot;, &quot;<?php echo $akhirbulan; ?>&quot;] }" />
                        <span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2">
                        </span>
                    </div>
                    <div class="col-md-auto position-relative mb-4">
                        <button class="btn btn-falcon-default btn-sm" type="button" onclick="isiGrafikPengaduan();isiArsipPengaduanDapodik();"><span class="d-none d-sm-inline-block">Refresh</span></button>
                    </div>
                </div>
                <div class="echart-line-payment" id="hitungChartPengaduan" style="height:260px" data-echart-responsive="true">
                    <canvas id="ChartPengaduan" height="300px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row g-3">
            <div class="col-md-3 col-xxl-12">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="row flex-between-center">
                            <div class="col d-md-flex d-lg-block flex-between-center">
                                <h6 class="mb-md-0 mb-lg-2 text-white">Belum Ditindak Lanjuti</h6><span class="badge rounded-pill badge-soft-danger lblpersenbelum"><span class="fas fa-caret-up"></span> </span>
                            </div>
                            <div class="col-auto">
                                <h4 class="fs-3 fw-normal text-white lblcardbelum"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xxl-12">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="row flex-between-center">
                            <div class="col d-md-flex d-lg-block flex-between-center">
                                <h6 class="mb-md-0 mb-lg-2 text-white">Ditolak </h6><span class="badge rounded-pill badge-soft-warning lblpersendistribusi"><span class="fas fa-caret-up"></span></span>
                            </div>
                            <div class="col-auto">
                                <h4 class="fs-3 fw-normal text-white lblcarddistribusi"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xxl-12">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="row flex-between-center">
                            <div class="col d-md-flex d-lg-block flex-between-center">
                                <h6 class="mb-md-0 mb-lg-2 text-white">Ditindak Lanjuti</h6><span class="badge rounded-pill badge-soft-success lblpersentindaklanjut"><span class="fas fa-caret-up"></span></span>
                            </div>
                            <div class="col-auto">
                                <h4 class="fs-3 fw-normal text-white lblcardjawab"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xxl-12">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="row flex-between-center">
                            <div class="col d-md-flex d-lg-block flex-between-center">
                                <h6 class="mb-md-0 mb-lg-2 text-white">Selesai</h6><span class="badge rounded-pill badge-soft-primary lblpersenselesai"><span class="fas fa-caret-up"></span></span>
                            </div>
                            <div class="col-auto">
                                <h4 class="fs-3 fw-normal text-white lblcardselesai"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-12">

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Arsip Pengaduan Klinik Dapodik </h5>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelArsipPengaduan" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Identitas</th>
                                <th class="sort">Keterangan</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelArsipPengaduan"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>