<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Data Sekolah</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data dengan memilih data sekolah</p>
    </div>
</div>
<div class="modal-body py-3">

    <div class="card z-index-1 mb-1">
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h6 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Sekolah Kabupaten Jember</h6>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshTambahDistribusiAts"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light px-3 py-3">

            <div class="table-responsive scrollbar mb-0">
                <table id="tableSiswaSelect" class="table table-hover table-sm mb-0 fs--1 overflow-hidden">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center"></th>
                            <th class="sort">Nama Sekolah</th>
                            <th class="sort">NPSN</th>
                            <th class="sort">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitableSiswaSelect">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal" id="cmdBatalDesk">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdTerapkanSekolah">Terapkan Pilihan</button>
</div>

<script>
    $(document).ready(function() {
        isiPilihDataSiswa();
    });

    function isiPilihDataSiswa() {
        $.ajax({
            type: "POST",
            url: "aksi/hasil-survei/isi_tabel_list_sekolah.php",
            data: {},
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                $('#tableSiswaSelect').dataTable().fnDestroy();
                document.body.style.cursor = "default";
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    html +=
                        '<tr id="' + data[i].idsekolah + '">' +
                        '<td class="align-middle text-center" width="4%"></td>' +
                        '<td class="align-middle text-truncate" width="24%" style="max-width:100px;">' + data[i].namasekolah + '</td>' +
                        '<td class="align-middle text-truncate" width="10%" style="max-width:200px;">' + data[i].npsn + '</td>' +
                        '<td class="align-middle text-truncate" width="62%" style="max-width:120px;">' + data[i].alamat + ' - ' + data[i].desa + ' - ' + data[i].kecamatan + '</td>' +
                        '</tr>';
                }

                $('#isitableSiswaSelect').html(html);
                var tabeleAts;
                tabeleAts = $("#tableSiswaSelect").dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "pageLength": 15,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": false,
                    "scrollX": false,
                    columnDefs: [{
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }],
                    select: {
                        style: 'single',
                        //selector: 'td:not(:last-child)'
                    },
                    order: [
                        [1, 'asc']
                    ],
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
                    },
                    "searching": true,
                });

                $("#loading").fadeOut("slow");
            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
    }

    $("#cmdRefreshTambahDistribusiAts").click(function() {
        isiPilihDataSiswa();
    });

    $("#cmdBatalDesk").click(function() {
        $("#cbosekolahlagi").val("");
        $("#txttransidsekolahdesk").val("");
        $("#txtnamasekolahdesk").val("");
        $("#txtnpsndesk").val("");
        $(".area-sekolah-lagi").css("display", "none")
    });

    $("#cmdTerapkanSekolah").click(function() {
        var arridats = [];
        var tabeleAts = $('#tableSiswaSelect').DataTable();
        $.each(tabeleAts.rows('.selected').nodes(), function(i, item) {
            var idbarang = item.id;
            var namasekolah = tabeleAts.row(this).data();
            $("#txtnamasekolahdesk").val(namasekolah[1]);
            $("#txtnpsndesk").val(namasekolah[2]);
            $("#txttransidsekolahdesk").val(idbarang);
            arridats.push(idbarang);
        });

        if (arridats.length <= 0) {
            alert('Data sekolah belum dipilih')
        } else {
            setTimeout(function() {
                $('#modTambahDataLarge').modal('hide');
            }, 1000);
        };
    });
</script>