<!---------------- MASTER LEVEL VERIFIKATOR ------------------>
<div class="col-xxl-12" id="area-master-verifikator" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data <strong>Operator</strong><br />
                        Tombol <strong>Ikon Blokir &nbsp;&nbsp;<span class="fas fa-ban"></span>&nbsp;&nbsp; , &nbsp;&nbsp;<span class="fas fa-edit"></span>&nbsp;&nbsp; Ikon Edit, &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp; Ikon Hapus</strong> untuk <strong>(memblokir, edit data dan hapus)</strong> data <strong>Verifikator</strong>
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
                            <h6 class="fs-0 mb-0">Master Data Operator</h6>
                        </div>

                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                            <div id="table-purchases-replace-element">
                                <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahOperator"><span class="d-none d-sm-inline-block ms-1">Tambah
                                        Data</span></button>
                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshOperator"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light px-3 py-3">
                    <div class="table-responsive scrollbar">
                        <table id="tabelOperatorAdm" class="table table-sm table-striped mb-0 fs--1 w-100">
                            <thead class="bg-200">
                                <tr>
                                    <th class="sort text-center">No.</th>
                                    <th class="sort text-center">Username</th>
                                    <th class="sort text-center">Bidang</th>
                                    <th class="sort text-center">Akses</th>
                                    <th class="sort text-center">Status</th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                    <th class="sort text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white" id="isitabelOperatorAdm" />
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!---------------- MASTER LAYANAN ------------------>
<div class="col-xxl-12" id="area-master-layanan" style="display:none">
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
                            <th class="sort">Keterangan</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabelMasterLayanan"></tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<div class="col-xxl-12" id="area-master-bidang" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                        Tombol <strong>Refresh</strong> untuk menampilkan data<br/>
                        Tombol &nbsp;&nbsp;<span class="fas fa-check"></span> &nbsp;&nbsp;<strong>(Ikon aktivasi)</strong> untuk aktivasi handphone,
                        Tombol &nbsp;&nbsp;<span class="fas fa-ban"></span> &nbsp;&nbsp;<strong>(Ikon non aktivasi)</strong> untuk non aktifkan handphone <strong>Kepala Bidang</strong><br/>
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Bidang</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Bidang</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahBidang"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshBidang"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tableMBidang" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Kepala Bagian</th>
                            <th class="sort">Bidang</th>
                            <th class="sort">Username</th>
                            <th class="sort">Status</th>
                            <th class="sort text-center"></th>
                            <th class="sort text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableMBidang"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="col-xxl-12" id="area-master-seksi" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                        Tombol <strong>Refresh</strong> untuk menampilkan data<br/>
                        Tombol &nbsp;&nbsp;<span class="fas fa-check"></span> &nbsp;&nbsp;<strong>(Ikon aktivasi)</strong> untuk aktivasi handphone,
                        Tombol &nbsp;&nbsp;<span class="fas fa-ban"></span> &nbsp;&nbsp;<strong>(Ikon non aktivasi)</strong> untuk non aktifkan handphone <strong>Kepala Seksi</strong><br/>
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Seksi</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master Data Seksi</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" id="cmdTambahSeksi"><span class="d-none d-sm-inline-block ms-1">Tambah
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshSeksi"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tableSeksi" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Seksi / Kasi</th>
                            <th class="sort">Bidang</th>
                            <th class="sort">Username</th>
                            <th class="sort">Status</th>
                            <th class="sort text-center"></th>
                            <th class="sort text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableSeksi"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>









