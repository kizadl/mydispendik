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
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Surveyor</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahSurveyor"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdExportSurveyor"><span class="d-none d-sm-inline-block ms-1">Export
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshSurveyor"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
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
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshAturKoordinator"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                        <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdExportAturKoordinator"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
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
                        Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pengaturan Surveyor - ATS</strong><br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-map-signs"></span> &nbsp;&nbsp;<strong>(Ikon list ATS)</strong> untuk menampilkan data <strong>ATS</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pengaturan Surveyor - ATS</h5>
                </div>
                <div class="col-6 col-sm-auto d-flex text-end ps-0">
                    
                    <select class="form-select form-select-sm me-2" id="cbowilayahATS" style="width:250px;">
                        <option value="all">Semua Wilayah</option>
                        <?php
                        $dbkopsurkec = mysqli_query($dbconn, "SELECT kd_kecamatan,nama_kecamatan FROM m_kecamatan ORDER BY nama_kecamatan ASC");
                        while ($k = mysqli_fetch_array($dbkopsurkec)) {
                            $kdkecamatan = $k['kd_kecamatan'];
                            $namakecamatan = ucwords(strtolower($k['nama_kecamatan']));
                            echo "<option value='$kdkecamatan'>$namakecamatan</option>";
                        }
                        mysqli_free_result($dbkopsurkec);
                        mysqli_close($dbconn);
                        ?>
                    </select>
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshAturATS"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                        <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdExportAturATS"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
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