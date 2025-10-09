<!---------------- area dashboard ------------------>
<div class="row g-3 mb-3" id="area-dashboard-kunjungan" style="display:none">
    <div class="col-xxl-9">
        <div class="card rounded-3 overflow-hidden h-100">
            <div class="card-body bg-line-chart-gradient d-flex flex-column justify-content-between">
                <div class="row align-items-center g-0">
                    <div class="col light">
                        <h6 class="fs-0 text-white mb-0">Grafik Kunjungan</h6>
                        <p class="fs--1 fw-semi-bold text-white"><span class="fs--1" id="lblkopperiode">Periode <?php echo $tglpicindo; ?> s/d <?php echo $tglpic2indo; ?></span></p>
                    </div>
                    <div class="col-md-auto position-relative mb-4 me-2">
                        <input class="form-control form-control-sm datetimepicker ps-4" id="txttanggaldashboard" type="text" data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;d-m-Y&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;<?php echo $awalbulan; ?>&quot;, &quot;<?php echo $akhirbulan; ?>&quot;] }" />
                        <span class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2">
                        </span>
                    </div>
                    <div class="col-md-auto position-relative mb-4">
                        <button class="btn btn-falcon-default btn-sm" type="button" onclick="isiGrafikKunjungan();isiDashboardKunjungan();"><span class="d-none d-sm-inline-block">Refresh</span></button>
                    </div>
                </div>
                <div class="echart-line-payment" id="hitungChartKunjungan" style="height:260px" data-echart-responsive="true">
                    <canvas id="ChartKunjungan" height="300px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-12">
        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center g-0">
                    <div class="col-auto">
                        <h6 class="mb-0">Detail Kunjungan</h6>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabeldashboardkunjungan" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Beranda</th>
                                <th class="sort">Informasi</th>
                                <th class="sort">Sarpras</th>
                                <th class="sort">SPM</th>
                                <th class="sort">Podcast</th>
                                <th class="sort">Pengaduan</th>
                                <th class="sort">Kegiatan</th>
                                <th class="sort">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabeldashboardkunjungan" />
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!---------------- tabel informasi ------------------>
<div class="col-xxl-12" id="area-halaman-informasi" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Refresh</strong> untuk menampilkan data, &nbsp;
                        Tombol <strong>Tambah Data</strong> untuk input data baru, &nbsp;
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon Edit)</strong> untuk merubah data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon Hapus)</strong> untuk menghapus data <strong>Informasi</strong>
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
                            <h6 class="fs-0 mb-0">Media Informasi Pendidikan</h6>
                        </div>

                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                            <div id="table-purchases-replace-element">
                                <table>
                                    <tr>
                                        <td width="180px">
                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterinformasi" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="Y">Aktif</option>
                                                <option value="N">Tidak Aktif</option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshInformasi"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdTambahInformasi"><span class="d-none d-sm-inline-block ms-1">Tambah Data</span></button>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabelInformasi" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No</th>
                                    <th class="sort">Tanggal</th>
                                    <th class="sort">Judul</th>
                                    <th class="sort">Isi Informasi</th>
                                    <th class="sort">Headline</th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabelInformasi" />
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!---------------- tabel podcast ------------------>
<div class="col-xxl-12" id="area-halaman-podcast" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-light h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Refresh</strong> untuk menampilkan data, &nbsp;
                        Tombol <strong>Tambah Data</strong> untuk input data baru, &nbsp;
                        Tombol &nbsp;&nbsp;<span class="fas fa-video"></span> &nbsp;&nbsp;<strong>(Ikon Video)</strong> untuk menampilkan video<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon Edit)</strong> untuk merubah data, &nbsp;
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon Hapus)</strong> untuk menghapus data <strong>Podcast</strong>
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
                            <h6 class="fs-0 mb-0">Media Podcast</h6>
                        </div>

                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                            <div id="table-purchases-replace-element">
                                <table>
                                    <tr>
                                        <td width="180px">
                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterPodcast" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                <option value="Y">Aktif</option>
                                                <option value="N">Tidak Aktif</option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshPodcast"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdTambahPodcast"><span class="d-none d-sm-inline-block ms-1">Tambah Data</span></button>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabelPodcast" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No</th>
                                    <th class="sort">Tanggal</th>
                                    <th class="sort">Judul</th>
                                    <th class="sort">Isi Keterangan Podcast</th>
                                    <th class="sort">Headline</th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabelPodcast" />
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>