
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 fs-0 text-white">Tambah Data Universitas</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data universitas</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Universitas</strong> dibawah ini.<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-0">
        <input type="text" class="form-control form-control-sm" id="txtnmuniversitas" value="" placeholder="Nama Universitas" maxlength="100" autocomplete="off">
        <label for="txtnmuniversitas">Nama Universitas</label>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanUniversitas">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#txtnmuniversitas").val("");$("#txtnmuniversitas").focus();
    });

    $("#cmdSimpanUniversitas").click(function() {
        var nmuniversitas = $('#txtnmuniversitas').val();
  
        var data = new FormData();
        data.append('nmuniversitas', nmuniversitas);

        if (nmuniversitas.length <= 0) {
            $('#txtnmuniversitas').focus();
            alert('Nama universitas masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/universitas/aksi_tambah.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanUniversitas").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modTambahDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterUniversitas();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanUniversitas").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanUniversitas").removeAttr("disabled");
                    }
                },
                error: function() {
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanUniversitas").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    });
</script>