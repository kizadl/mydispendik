<!---------------- MUTASI SISWA ------------------>
<div class="row mb-3 g-3" id="area-mutasi-siswa" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Mutasi Siswa</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk mengirim atau menolak surat,
                            Tombol &nbsp;&nbsp;<span class="fas fa-envelope"></span> &nbsp;&nbsp;<strong>(Ikon surat)</strong> untuk menampilkan surat,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk menghapus surat
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
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Permohonan Mutasi Siswa</h5>
                        <small class="fs--1" id="lblkoparsipMutasiSiswa"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahMutasiSiswa"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
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
                                <th class="sort">Data Siswa</th>
                                <th class="sort">Keterangan Mutasi</th>
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

<!---------------- VERIFIKASI PDB ------------------>
<div class="row mb-3 g-3" id="area-verifikasi-pdb-mi" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Verifikasi PDB MI</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Verifikasi PDB MI</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Verifikasi Peserta Didik Baru MI </h5>
                        <small class="fs--1" id="lblkoparsipPDBMI"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahPDBMI"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshPDBMI"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelVerPDBMI" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Pemohon</th>
                                <th class="sort">Data Sekolah</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelVerPDBMI"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- MUTASI PENDIDIK ------------------>
<div class="row mb-3 g-3" id="area-mutasi-pendidik" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Mutasi Pendidik</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Mutasi Pendidik</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Mutasi Pendidik & Tenaga Pendidik </h5>
                        <small class="fs--1" id="lblkoparsipMutasiPendidik"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahMutasiPendidik"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshMutasiPendidik"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelMutasiPendidik" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Pendidik / Tenaga Pendidik</th>
                                <th class="sort">Data Pengangkatan - Penugasan</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelMutasiPendidik"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- PERGANTIAN KEPSEK ------------------>
<div class="row mb-3 g-3" id="area-ganti-kepsek" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                            Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pergantian Kepala Sekolah</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Pergantian Kepala Sekolah</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pergantian Kepala Sekolah </h5>
                        <small class="fs--1" id="lblkoparsipGantiKepsek"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahGantiKepsek"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshGantiKepsek"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelPergantianKepsek" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Kepala Sekolah</th>
                                <th class="sort">Sekolah Tempat Tugas</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelPergantianKepsek"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- PERUBAHAN PTK ------------------>
<div class="row mb-3 g-3" id="area-perubahan-ptk" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Perubahan Jenis PTK</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Perubahan Jenis PTK</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Perubahan Jenis PTK </h5>
                        <small class="fs--1" id="lblkoparsipUbahPTK"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahUbahPTK"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshUbahPTK"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelPerubahanPTK" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Pemohon</th>
                                <th class="sort">Data Sekolah</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelPerubahanPTK"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- PENGAJUAN NPSN ------------------>
<div class="row mb-3 g-3" id="area-pengajuan-npsn" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pengajuan NPSN</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Pengajuan NPSN</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pengajuan NPSN </h5>
                        <small class="fs--1" id="lblkoparsipNPSN"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahNPSN"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshNPSN"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelPengajuanNPSN" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Sekolah</th>
                                <th class="sort">Keterangan</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelPengajuanNPSN"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- PENGAJUAN OPERATOR ------------------>
<div class="row mb-3 g-3" id="area-pengajuan-akun-operator" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pengajuan Akun Operator</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Pengajuan Akun Operator</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pengajuan Akun Operator </h5>
                        <small class="fs--1" id="lblkoparsipAkunOpt"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahAkunOperator"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshAkunOperator"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelPengajuanOperator" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Operator</th>
                                <th class="sort">Keterangan</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelPengajuanOperator"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- PENGAJUAN NPYP ------------------>
<div class="row mb-3 g-3" id="area-pengajuan-npyp" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pengajuan NPYP</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-paperclip"></span> &nbsp;&nbsp;<strong>(Ikon lampiran persyaratan)</strong> untuk melihat lampiran persyaratan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-share-alt"></span> &nbsp;&nbsp;<strong>(Ikon kirim)</strong> untuk menerima atau menolak permohonan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-folder-open"></span> &nbsp;&nbsp;<strong>(Ikon arsip)</strong> untuk mengarsipkan data <strong>Pengajuan NPYP</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pengajuan NPYP </h5>
                        <small class="fs--1" id="lblkoparsipNPYP"></small>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahNPYP"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshNPYP"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelPengajuanNPYP" class="table table-sm table-striped mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">No</th>
                                <th class="sort">Tanggal</th>
                                <th class="sort">Data Yayasan</th>
                                <th class="sort">Keterangan</th>
                                <th class="sort text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                           </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelPengajuanNPYP"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!---------------- PENGADUAN DAPODIK ------------------>
<div class="row mb-3 g-3" id="area-pengaduan-dapodik" style="display:none">
    <div class="col-xxl-12">

        <div class="row mb-3 g-3">
            <div class="col-xxl-12">
                <div class="card bg-primary text-white h-lg-100">
                    <div class="card-body d-flex align-items-center">
                        <p class="fs--1 mt-0 mb-0">
                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                            Tombol <strong>Refresh</strong> untuk merefresh data <strong>Pengaduan Klinik Dapodik</strong><br />
                            Tombol &nbsp;&nbsp;<span class="fas fa-file"></span> &nbsp;&nbsp;<strong>(Ikon file)</strong> untuk melihat file pengaduan,
                            Tombol &nbsp;&nbsp;<span class="fas fa-comment-alt"></span> &nbsp;&nbsp;<strong>(Ikon pesan)</strong> untuk menampilkan pesan verifikator,<br/>
                            Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                            Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk menghapus data <strong>Pengaduan Klinik Dapodik</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Pengaduan Klinik Dapodik </h5>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahPengaduan"><span class="d-none d-sm-inline-block">Tambah Data</span></button>
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshPengaduan"><span class="d-none d-sm-inline-block">Refresh</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelPengaduan" class="table table-sm table-striped mb-0 fs--1 w-100">
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
                        <tbody class="bg-white" id="isitabeltabelPengaduan"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>








