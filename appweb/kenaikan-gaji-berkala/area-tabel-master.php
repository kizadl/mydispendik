<!---------------- MASTER LAYANAN ------------------>
<div class="col-xxl-12" id="area-master-layanan" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Refresh</strong> untuk merefresh data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data <strong>Layanan Gaji Berkala</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Gaji Berkala</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshLayanan"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tabelMasterLayanan" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Nama Layanan</th>
                            <th class="sort">Nomor Surat</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelMasterLayanan"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!---------------- MASTER PERSYARATAN ------------------>
<div class="col-xxl-12" id="area-master-persyaratan" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Refresh</strong> untuk merefresh data <strong>Persyaratan</strong><br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-tasks"></span> &nbsp;&nbsp;<strong>(Ikon list persyaratan)</strong> untuk menampilkan data <strong>persyaratan</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Persyaratan</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshPersyaratan"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tabelMasterPersyaratan" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Nama Layanan</th>
                            <th class="sort">Persyaratan</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelMasterPersyaratan"></tbody>
                </table>
            </div>

        </div>
    </div>

</div>