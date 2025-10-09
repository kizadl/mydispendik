<!---------------- SURVEI ATS ------------------>
<div id="area-survei-ats" style="display:none">
    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Export Data</strong> untuk export data excel,
                        Tombol <strong>Refresh</strong> untuk menampilkan data<br />
                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data <strong>Siswa</strong>,
                        Tombol &nbsp;&nbsp;<span class="fas fa-sliders-h"></span> &nbsp;&nbsp;<strong>(Ikon survei)</strong> untuk input data <strong>Survei ATS</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Survei - <?php echo ucwords(strtolower($nmkoordinator)); ?></h5>
                    <span class="fs--1"><?php echo ucwords(strtolower($nmcabang)); ?> - <?php echo ucwords(strtolower($nmfakultas)); ?></span>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdExportHasil"><span class="d-none d-sm-inline-block ms-1">Export
                                Data</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshHasil"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar">
                <table id="tableHasilSurveyor" class="table table-sm table-striped mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">No.</th>
                            <th class="sort">Data Siswa</th>
                            <th class="sort">Alamat</th>
                            <th class="sort">Keterangan</th>
                            <th class="sort">ATS</th>
                            <th class="sort">Survei</th>
                            <th class="sort text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableHasilSurveyor"></tbody>
                </table>
            </div>

        </div>
    </div>
</div>