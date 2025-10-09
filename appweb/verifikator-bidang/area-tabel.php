<!---------------- area dashboard ------------------>
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
                        <input class="form-control form-control-sm datetimepicker ps-4" id="txttanggaldashboard" type="text" data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;d-m-Y&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;<?php echo $awalbulan; ?>&quot;, &quot;<?php echo $akhirbulan; ?>&quot;] }" />
                        <span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2">
                        </span>
                    </div>
                    <div class="col-md-auto position-relative mb-4">
                        <button class="btn btn-falcon-default btn-sm" type="button" onclick = "isiGrafikPengaduan();isiDshboardPengaduan();"><span class="d-none d-sm-inline-block">Refresh</span></button>
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
                                <h6 class="mb-md-0 mb-lg-2 text-white">Distribusi Ke Bidang</h6><span class="badge rounded-pill badge-soft-warning lblpersendistribusi"><span class="fas fa-caret-up"></span></span>
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
                    <div class="row flex-between-center g-0">
                        <div class="col-auto">
                            <h6 class="mb-0">Detail Pengaduan</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabeldashboardpengaduan" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No</th>
                                    <th class="sort">Tanggal</th>
                                    <th class="sort">Nama Pelapor</th>
                                    <th class="sort">Uraian Masalah</th>
                                    <th class="sort">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabeldashboardpengaduan" />
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>

<!---------------- tabel pengaduan ------------------>
<div class="col-xxl-12" id="area-halaman-pengaduan" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Refresh</strong> untuk menampilkan data, &nbsp;
                        Tombol &nbsp;&nbsp;<span class="fas fa-project-diagram"></span> &nbsp;&nbsp;<strong>(Ikon Distribusi)</strong> untuk meneruskan jawaban ke <strong>Pelapor</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card z-index-1 mb-3">
                <div class="card-header">
                    <div class="row flex-between-center g-0">
                        <div class="col-auto">
                            <h6 class="fs-0 mb-0">Pengaduan Masyarakat</h6>
                        </div>

                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                            <div id="table-purchases-replace-element">
                                <table>
                                    <tr>
                                        <td width="280px">
                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterpengaduan" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="distribusi">Sudah Diserahkan Ke Bidang</option>
                                                <option value="jawaban">Sudah Ditindak Lanjuti</option>
                                                <option value="selesai">Pengaduan Selesai</option>
                                                <option value="semua">Semua Pengaduan</option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshPengaduan"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabelpengaduan" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No</th>
                                    <th class="sort">Tanggal</th>
                                    <th class="sort">Nama Pelapor</th>
                                    <th class="sort">Uraian Masalah</th>
                                    <th class="sort">Status</th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabelpengaduan" />
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
