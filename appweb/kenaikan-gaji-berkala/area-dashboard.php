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
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Dashboard Gaji Berkala</h5>
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
                                <p class="fs--1 fw-semi-bold">Grafik Gaji Berkala</p>
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
