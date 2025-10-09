<div class="row mb-3 g-3" id="area-mutasi-siswa" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Tombol <strong>Filter Arsip</strong> untuk menampilkan data arsip,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Mutasi Siswa</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk mengirim atau menolak surat,
                            Tombol &nbsp;&nbsp;<span class="fas fa-envelope"></span> &nbsp;&nbsp;<strong>(Ikon surat)</strong> untuk menampilkan surat<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Mutasi Siswa</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Permohonan Kenaikan Gaji Berkala</h5>
                        <small class="fs--1" id="lblkoparsipMutasiSiswa"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdArsipMutasiSiswa"><span class="d-none d-sm-inline-block">Filter Arsip</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshMutasiSiswa"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabeMutasiSiswa" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Pegawai</th>
                                <th class="sort">Keterangan Gaji Berkala</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabeMutasiSiswa"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
