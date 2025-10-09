<!---------------- MASTER KOORDINATOR ------------------>
<div class="col-xxl-12" id="area-master-koordinator" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data, Tombol <strong>Export Data</strong> untuk export data excel, Tombol <strong>Refresh</strong> untuk menampilkan data<br />
                        Tombol <strong>Ikon Blokir &nbsp;&nbsp;<span class="fas fa-ban"></span>&nbsp;&nbsp; , &nbsp;&nbsp;<span class="fas fa-edit"></span>&nbsp;&nbsp; Ikon Edit, &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp; Ikon Hapus</strong> untuk <strong>(memblokir, edit data dan hapus)</strong> data <strong>Koordinator</strong></br>
                        <strong>Catatan : </strong> Username terisi otomatis, Password standart <strong>koordinator</strong>
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
                            <h6 class="fs-0 mb-0">Master Data Koordinator</h6>
                        </div>

                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                            <div id="table-purchases-replace-element">
                                <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahKoordinator"><span class="d-none d-sm-inline-block ms-1">Tambah
                                        Data</span></button>
                                <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdExportKoordinator"><span class="d-none d-sm-inline-block ms-1">Export
                                        Data</span></button>
                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshKoordinator"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabelKoordinator" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No.</th>
                                    <th class="sort">Koordinator</th>
                                    <th class="sort">Universitas - Fakultas</th>
                                    <th class="sort">Username</th>
                                    <th class="sort text-center">Status</th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabelKoordinator" />
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!---------------- MASTER SURVEYOR ------------------>
<div class="col-xxl-12" id="area-master-surveyor" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                        Tombol <strong>Export Data</strong> untuk export data excel,
                        Tombol <strong>Refresh</strong> untuk menampilkan data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-check"></span> &nbsp;&nbsp;<strong>(Ikon aktivasi)</strong> untuk aktivasi handphone,
                        Tombol &nbsp;&nbsp;<span class="fas fa-ban"></span> &nbsp;&nbsp;<strong>(Ikon non aktivasi)</strong> untuk non aktifkan handphone <strong>Surveyor</strong><br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Surveyor</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Surveyor</h5>
                    <div class="d-flex align-items-center"><span class="dot bg-primary"></span><span class="fs--1" id="lblkopfiltersurveyor">Semua data surveyor</span></div>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdTambahSurveyor"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Tambah</span></button>
                        <button class="btn btn-falcon-default btn-sm mx-1" type="button" id="cmdFilterSurveyor"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExportSurveyor"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tableSurveyor" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Surveyor</th>
                            <th class="sort">Universitas - Fakultas</th>
                            <th class="sort">Username</th>
                            <th class="sort">Status</th>
                            <th class="sort text-center"></th>
                            <th class="sort text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableSurveyor"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!---------------- MASTER DESK ------------------>
<div class="col-xxl-12" id="area-master-desk" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data, Tombol <strong>Export Data</strong> untuk export data excel, Tombol <strong>Refresh</strong> untuk menampilkan data<br />
                        Tombol <strong>Ikon Blokir &nbsp;&nbsp;<span class="fas fa-ban"></span>&nbsp;&nbsp; , &nbsp;&nbsp;<span class="fas fa-edit"></span>&nbsp;&nbsp; Ikon Edit, &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp; Ikon Hapus</strong> untuk <strong>(memblokir, edit data dan hapus)</strong> data <strong>Operator Desk</strong></br>
                        <strong>Catatan : </strong> Username terisi otomatis, Password standart <strong>operator</strong>
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
                            <h6 class="fs-0 mb-0">Master Data Operator Desk</h6>
                        </div>

                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                            <div id="table-purchases-replace-element">
                                <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahDesk"><span class="d-none d-sm-inline-block ms-1">Tambah
                                        Data</span></button>
                                <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdExportDesk"><span class="d-none d-sm-inline-block ms-1">Export
                                        Data</span></button>
                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshDesk"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabelOperatorDesk" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No.</th>
                                    <th class="sort">Operator Desk</th>
                                    <th class="sort">Username</th>
                                    <th class="sort text-center">Status</th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabelOperatorDesk" />
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!---------------- MASTER UNIVERSITAS ------------------>
<div class="col-xxl-12" id="area-master-universitas" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                        Tombol <strong>Refresh</strong> untuk menampilkan data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Universitas</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Universitas</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahUniversitas"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshUniversitas"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tableUniversitas" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Universitas</th>
                            <th class="sort text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableUniversitas"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!---------------- MASTER FAKULTAS ------------------>
<div class="col-xxl-12" id="area-master-fakultas" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                        Tombol <strong>Refresh</strong> untuk menampilkan data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Fakultas</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Fakultas</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahFakultas"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshFakultas"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tableFakultas" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Fakultas</th>
                            <th class="sort">Universitas</th>
                            <th class="sort text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableFakultas"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!---------------- KOORDINATOR-SURVEYOR ------------------>
<div class="col-xxl-12" id="area-koordinator-surveyor" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pengaturan Koordinator - Surveyor</strong><br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-chalkboard-teacher"></span> &nbsp;&nbsp;<strong>(Ikon list surveyor)</strong> untuk menampilkan data <strong>Surveyor</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pengaturan Koordinator - Surveyor</h5>
                </div>
                <div class="col-6 col-sm-auto d-flex text-end ps-0">

                    <select class="form-select form-select-sm me-2" id="cbouniversitasAturKoordinator" style="width:250px;">
                        <option value="all">Semua Universitas</option>
                        <?php
                        $dbkopkoordsurveyor = mysqli_query($dbconn, "SELECT id_universitas,nm_universitas FROM ats_universitas ORDER BY nm_universitas ASC");
                        while ($un = mysqli_fetch_array($dbkopkoordsurveyor)) {
                            $iduniversitaskor = $un['id_universitas'];
                            $nmuniversitaskor = ucwords(strtolower($un['nm_universitas']));
                            echo "<option value='$iduniversitaskor'>$nmuniversitaskor</option>";
                        }
                        mysqli_free_result($dbkopkoordsurveyor);
                        ?>
                    </select>
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshAturKoordinator"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExportAturKoordinator"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tabelPengaturanKoordinator" class="table table-hover table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Koordinator</th>
                            <th class="sort">Pengaturan Surveyor</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelPengaturanKoordinator"></tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!---------------- SURVEYOR-ATS ------------------>
<div class="col-xxl-12" id="area-surveyor-ats" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        
                        Tombol &nbsp;&nbsp;<span class="fas fa-filter"></span> &nbsp;&nbsp;<strong>(Ikon Filter)</strong> untuk memfilter dan menampilkan data <strong>Pengaturan Surveyor - ATS</strong><br>
                        Tombol &nbsp;&nbsp;<span class="fas fa-external-link-alt"></span> &nbsp;&nbsp;<strong>(Ikon Export)</strong> untuk export ke excel<br>
                        Tombol &nbsp;&nbsp;<span class="fas fa-map-signs"></span> &nbsp;&nbsp;<strong>(Ikon list ATS)</strong> untuk menampilkan data <strong>ATS</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pengaturan Surveyor - ATS</h5>
                    <div class="d-flex align-items-center"><span class="dot bg-primary"></span><span class="fs--1" id="lblkopfiltersurveyorATS">Data Belum Ditampilkan</span></div>
                </div>
                <div class="col-6 col-sm-auto d-flex text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-1" type="button" id="cmdFilterAturAts"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filter</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExportAturAts"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tabelPengaturanATS" class="table table-hover table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Surveyor</th>
                            <th class="sort">Pengaturan Data ATS</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelPengaturanATS"></tbody>
                </table>
            </div>

        </div>
    </div>

</div>