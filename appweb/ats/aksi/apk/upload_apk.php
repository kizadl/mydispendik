<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Distribusi APK</h5>
        <p class="fs--1 mb-0 text-white">Silahkan upload apk untuk distribusi</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        Isi dan lengkapi form isian data <strong>Distribusi APK</strong> dibawah ini<br />
                        Tekan tombol <strong>Simpan Data</strong> untuk menyimpan data
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtversi" value=""
            placeholder="Versi rilis" maxlength="100" autocomplete="off" >
        <label for="txtversi">Versi Rilis</label>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control form-control-sm datetimepicker" id="txttglrilis" value="" type="text" placeholder="Tanggal rilis" data-options='{"dateFormat":"d-m-Y","disableMobile":true}' />
        <label for="txttglrilis">Tanggal Rilis</label>
    </div>

    <div class="card bg-light">
        <div class="card-body px-3 py-2 mb-3">
            <p class="fs--1 mb-2 text-600"><b>Upload APK</b><br>File distribusi harus file
                apk berextensi .rar</p>
            <input class="form-control form-control-sm" id="btnUploadAPK" type="file" accept=".rar" />
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600"><b>Upload Tutorial</b><br>File tutorial harus file
                dokumen berextensi .pdf</p>
            <input class="form-control form-control-sm" id="btnUploadTutorial" type="file" accept=".pdf" />
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanUploadAPK">Simpan data</button>
</div>

<script src="../assets/js/flatpickr.js"></script>
<script type="text/javascript" charset="utf-8">

$(document).ready(function() {

        var tglserver = $("#lbltglserver").val();
        arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
            "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
        ];
        mydate = new Date(tglserver);

        tanggal = mydate.getDate();
        bulan = mydate.getMonth();
        tahun = mydate.getFullYear();

        $("#txttglrilis").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
    });

function gantiFile() {
    $("#btnUploadAPK").val('');
}

$('#btnUploadAPK').bind('change', function() {
    var extensinya = $('#btnUploadAPK').val().toLowerCase();
    var regex = new RegExp("(.*?)\.(rar)$");
    if (!(regex.test(extensinya))) {
        alert("File upload harus file berextensi .rar");
        $('#btnUploadAPK').val(null);
    }
});

$('#btnUploadTutorial').bind('change', function() {
    var extensinya = $('#btnUploadTutorial').val().toLowerCase();
    var regex = new RegExp("(.*?)\.(pdf)$");
    if (!(regex.test(extensinya))) {
        alert("File upload tutorial harus file berextensi .pdf");
        $('#btnUploadTutorial').val(null);
    }
});

$("#cmdSimpanUploadAPK").click(function() {
    var versiapk = $('#txtversi').val();
    var tglrilis = $('#txttglrilis').val();
    var nmfile = $('#btnUploadAPK').val();

    var data = new FormData();
    data.append('upDistribusiAPK', $("#btnUploadAPK")[0].files[0]);
    data.append('upTutorial', $("#btnUploadTutorial")[0].files[0]);
    data.append('versiapk', versiapk);
    data.append('tglrilis', tglrilis);

    if (versiapk.length <= 0) {
        $('#txtversi').focus();
        alert('Versi rilis apk tidak terdeteksi')
    } else if (tglrilis.length <= 0) {
        $('#txttglrilis').focus();
        alert('Tanggal rilis apk tidak terdeteksi')
    } else if (nmfile.length <= 0) {
        alert('File upload apk tidak terdeteksi')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/apk/aksi_upload_apk.php',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
                $("#cmdSimpanUploadAPK").attr("disabled", "disabled");
            },
            success: function(resp) {
                document.body.style.cursor = "default";
                if (resp.msg2 == 'ok') {
                    $("#loading").fadeOut("slow");
                    $("#cmdSimpanUploadAPK").removeAttr("disabled");
                    $("#ToastSukses").toast("show");
                    setTimeout(function() {
                        $('#modEditData').modal('hide');
                    }, 1000);
                } else {
                    $("#loading").fadeOut("slow");
                    $("#ToastGagal").toast("show");
                    $("#cmdSimpanUploadAPK").removeAttr("disabled");
                }
            },
            error: function() {
                document.body.style.cursor = "default";
                $("#loading").fadeOut("slow");
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanUploadAPK").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>