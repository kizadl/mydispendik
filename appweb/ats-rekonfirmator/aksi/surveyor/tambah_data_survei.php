<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
$idsiswa = trim($_POST['idsiswa']);
$idsurveyor = trim($_POST['idsurveyor']);

$qri = ("SELECT p.id_siswa,p.nama_siswa,p.jenis_kelamin,p.tmp_lahir,p.tgl_lahir,p.umur,
		p.alamat,p.rt,p.rw,p.desa,p.kecamatan,p.kd_kecamatan,
		p.nama_sekolah,p.bentuk_pendidikan,p.tingkat_pendidikan,p.tahun,p.semester,p.status_ats
		 FROM tbl_ats_2025 p WHERE p.id_siswa='" . $idsiswa . "'");
$dbquery = mysqli_query($dbconn, $qri);
$t = mysqli_fetch_assoc($dbquery);

$namasiswa = ucwords(strtolower($t['nama_siswa']));
$kelamin = $t['jenis_kelamin'];
$tmplahir = ucwords(strtolower($t['tmp_lahir']));
$tgllahir = date("d-m-Y", strtotime($t['tgl_lahir']));
$umur = $t['umur'];

$alamat = ucwords(strtolower($t['alamat']));
$rt = $t['rt'];
$rw = $t['rw'];
$desa = ucwords(strtolower($t['desa']));
$kecamatan = ucwords(strtolower($t['kecamatan']));
$kdkecamatan = $t['kd_kecamatan'];

$namasekolah = strtoupper($t['nama_sekolah']);
$bentukpendidikan = $t['bentuk_pendidikan'];
$tingkatpendidikan = $t['tingkat_pendidikan'];
$tahun = $t['tahun'];
$semester = $t['semester'];
$statusats = $t['status_ats'];

$qrids = ("SELECT detail FROM ats_detail_survei_2025 WHERE id_siswa='" . $idsiswa . "'");
$dbquery = mysqli_query($dbconn, $qrids);
$row = mysqli_fetch_assoc($dbquery);

if($row) {
    $detail = json_decode($row['detail'], true);
} else {
    $detail = array(
        'klasifikasi' => '',
        'faktorEkonomi' => '',
        'faktorKesehatan' => '',
        'faktorSosial' => '',
        'faktorGeografis' => '',
        'faktorPendidikan' => '',
        'faktorKeluarga' => '',
        'statusGizi' => '',
        'riwayatPindahSekolah' => '',
        'pencapaianAkademis' => '',
        'keterlibatanEkskul' => '',
        'hasilRekomendasi' => ''
    );
}


mysqli_free_result($dbquery);
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Data Rekonfirmasi ATS</h5>
        <p class="fs--1 mb-0 text-white">Silahkan input data rekonfirmasi ATS</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $namasiswa; ?></strong><br>
                        <?php echo $alamat; ?> RT <?php echo $rt; ?> RW <?php echo $rw; ?> - <?php echo $desa; ?> - <?php echo $kecamatan; ?>
                        <br>Kelahiran : <?php echo $tmplahir; ?>, <?php echo $tgllahir; ?> (<?php echo $umur; ?> Tahun)
                        <br><br>
                        <strong><?php echo $namasekolah; ?></strong><br>
                        <?php echo $statusats; ?> Tahun <?php echo $tahun; ?> - Kelas <?php echo $tingkatpendidikan; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control" type="text" id="txtidsiswasurveiAts" value="<?php echo $idsiswa; ?>" style="display:none;" />
    <input class="form-control" type="text" id="txtidsurveyorsurveiAts" value="<?php echo $idsurveyor; ?>" style="display:none;" />

    <div class="">
        <div class="">
            <div>
                <label>1.Klasifikasi Anak Tidak Sekolah</label>
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cboklasifikasi" id="cboklasifikasi" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="DO" <?php echo ($detail['klasifikasi'] == 'DO') ? 'selected' : ''?>>Putus Sekolah (Drop Out)</option>
                        <option value="LTM" <?php echo ($detail['klasifikasi'] == 'LTM') ? 'selected' : ''?>>Lulus Tidak Melanjutkan (LTM)</option>
                        <option value="BPB" <?php echo ($detail['klasifikasi'] == 'BPB') ? 'selected' : ''?>>Belum Pernah Bersekolah (BPB)</option>
                        <option value="Lainnya" <?php echo ($detail['klasifikasi'] != null && $detail['klasifikasi'] != 'DO' 
                        && $detail['klasifikasi'] != 'LTM' && $detail['klasifikasi'] != 'BPB') ? 'selected' : ''?>>Lainnya</option>
                    </select>
                    <input type="text" class="form-control form-control-sm mt-2" id="txtKlasifikasiLainnya" 
                    style="display:none;"
                    value="<?php echo ($detail['klasifikasi'] != 'DO' && $detail['klasifikasi'] != 'LTM' && $detail['klasifikasi'] != 'BPB') ? $detail['klasifikasi'] : ''; ?>">
                </div>
            </div>
            <div>
                <label>2.Faktor Penyebab Anak Tidak Sekolah</label>
                <div>
                    <div>
                        <label>a.Faktor Ekonomi</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbofaktorekonomi" id="cbofaktorekonomi" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Tidak mampu biaya sekolah" <?php echo ($detail['faktorEkonomi'] == 'Tidak mampu biaya sekolah') ? 'selected' : ''?>>
                                    Tidak mampu biaya sekolah</option>
                                <option value="Anak harus bekerja untuk membantu ekonomi keluarga" <?php echo ($detail['faktorEkonomi'] == 'Anak harus bekerja untuk membantu ekonomi keluarga') ? 'selected' : ''?>>
                                    Anak harus bekerja untuk membantu ekonomi keluarga</option>
                                <option value="Kurangnya fasilitas atau peralatan sekolah" <?php echo ($detail['faktorEkonomi'] == 'Kurangnya fasilitas atau peralatan sekolah') ? 'selected' : ''?>>
                                    Kurangnya fasilitas atau peralatan sekolah</option>
                                <option value="Lainnya" <?php echo ($detail['faktorEkonomi'] == 'Lainnya') ? 'selected' : ''?>>
                                    Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>b.Faktor Kesehatan</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbofaktorkesehatan" id="cbofaktorkesehatan" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Memiliki kondisi kesehatan yang manghalangi pendidikan <?php echo ($detail['faktorKesehatan'] == 'Memiliki kondisi kesehatan yang manghalangi pendidikan') ? 'selected' : ''?>">
                                    Memiliki kondisi kesehatan yang manghalangi pendidikan</option>
                                <option value="Keterbatasan akses ke layanan kesehatan" <?php echo ($detail['faktorKesehatan'] == 'Keterbatasan akses ke layanan kesehatan') ? 'selected' : ''?>>Keterbatasan akses ke layanan kesehatan</option>
                                <option value="Inklusi/gangguan mental/emosional" <?php echo ($detail['faktorKesehatan'] == 'Inklusi/gangguan mental/emosional') ? 'selected' : ''?>>
                                    Inklusi/gangguan mental/emosional</option>
                                <option value="Lainnya" <?php echo ($detail['faktorKesehatan'] == 'Lainnya') ? 'selected' : ''?>>
                                    Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>c.Faktor Sosial</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbofaktorsosial" id="cbofaktorsosial" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Tidak ada dukungan dari keluarga" <?php echo ($detail['faktorSosial'] == 'Tidak ada dukungan dari keluarga') ? 'selected' : ''?>>Tidak ada dukungan dari keluarga</option>
                                <option value="Pergaulan yang buruk/pernikahan dini" <?php echo ($detail['faktorSosial'] == 'Pergaulan yang buruk/pernikahan dini') ? 'selected' : ''?>>Pergaulan yang buruk/pernikahan dini</option>
                                <option value="Terlibat dalam kegiatan kriminal" <?php echo ($detail['faktorSosial'] == 'Terlibat dalam kegiatan kriminal') ? 'selected' : ''?>>Terlibat dalam kegiatan kriminal</option>
                                <option value="Lainnya" <?php echo ($detail['faktorSosial'] == 'Lainnya') ? 'selected' : ''?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>d.Faktor Geografis</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbofaktorgeografis" id="cbofaktorgeografis" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Jarak sekolah yang terlalu jauh" <?php echo ($detail['faktorGeografis'] == 'Jarak sekolah yang terlalu jauh') ? 'selected' : ''?>>Jarak sekolah yang terlalu jauh</option>
                                <option value="Transportasi yang tidak memadai" <?php echo ($detail['faktorGeografis'] == 'Transportasi yang tidak memadai') ? 'selected' : ''?>>Transportasi yang tidak memadai</option>
                                <option value="Transportasi yang tidak memadai" <?php echo ($detail['faktorGeografis'] == 'Terlibat dalam kegiatan kriminal') ? 'selected' : ''?>>Terlibat dalam kegiatan kriminal</option>
                                <option value="Lainnya" <?php echo ($detail['faktorGeografis'] == 'Lainnya') ? 'selected' : ''?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>e.Faktor Pendidikan</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbofaktorpendidikan" id="cbofaktorpendidikan" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Kurangnya kualitas pengajaran di sekolah" <?php echo ($detail['faktorPendidikan'] == 'Kurangnya kualitas pengajaran di sekolah') ? 'selected' : ''?>>Kurangnya kualitas pengajaran di sekolah</option>
                                <option value="Ketidaksesuaian kurikulum dengan kebutuhan anak" <?php echo ($detail['faktorPendidikan'] == 'Ketidaksesuaian kurikulum dengan kebutuhan anak') ? 'selected' : ''?>>Ketidaksesuaian kurikulum dengan kebutuhan anak</option>
                                <option value="Kurangnya satuan pendidikan di daerah" <?php echo ($detail['faktorPendidikan'] == 'Kurangnya satuan pendidikan di daerah') ? 'selected' : ''?>>Kurangnya satuan pendidikan di daerah</option>
                                <option value="Lainnya" <?php echo ($detail['faktorPendidikan'] == 'Lainnya') ? 'selected' : ''?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>f.Faktor Keluarga</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbofaktorkeluarga" id="cbofaktorkeluarga" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Perceraian atau perpisahan orang tua" <?php echo ($detail['faktorKeluarga'] == 'Perceraian atau perpisahan orang tua') ? 'selected' : ''?>>Perceraian atau perpisahan orang tua</option>
                                <option value="Kekerasan dalam rumah tangga" <?php echo ($detail['faktorKeluarga'] == 'Kekerasan dalam rumah tangga') ? 'selected' : ''?>>Kekerasan dalam rumah tangga</option>
                                <option value="Tanggung jawab rumah tangga yang besar" <?php echo ($detail['faktorKeluarga'] == 'Tanggung jawab rumah tangga yang besar') ? 'selected' : ''?>>Tanggung jawab rumah tangga yang besar</option>
                                <option value="Lainnya" <?php echo ($detail['faktorKeluarga'] == 'Lainnya') ? 'selected' : ''?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label>3.Indikator lainnya yang relevan</label>
                <div>
                    <label>a.Status Gizi</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbostatusgizi" id="cbostatusgizi" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Baik" <?php echo ($detail['statusGizi'] == 'Baik') ? 'selected' : ''?>>Baik</option>
                                <option value="Kurang" <?php echo ($detail['statusGizi'] == 'Kurang') ? 'selected' : ''?>>Kurang</option>
                                <option value="Buruk" <?php echo ($detail['statusGizi'] == 'Cukup') ? 'selected' : ''?>>Buruk</option>
                            </select>
                        </div>
                </div>
                <div>
                    <label>b.Riwayat Pindah Sekolah</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cboriwayatpindahsekolah" id="cboriwayatpindahsekolah" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Sering" <?php echo ($detail['riwayatPindahSekolah'] == 'Sering') ? 'selected' : ''?>>Sering</option>
                                <option value="Jarang" <?php echo ($detail['riwayatPindahSekolah'] == 'Jarang') ? 'selected' : ''?>>Jarang</option>
                                <option value="Tidak Pernah" <?php echo ($detail['riwayatPindahSekolah'] == 'Tidak Pernah') ? 'selected' : ''?>>Tidak Pernah</option>
                            </select>
                        </div>
                </div>
                <div>
                    <label>c.Pencapaian Akademis Terakhir</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cbopencapaianakademis" id="cbopencapaianakademis" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Baik" <?php echo ($detail['pencapaianAkademis'] == 'Baik') ? 'selected' : ''?>>Baik</option>
                                <option value="Cukup" <?php echo ($detail['pencapaianAkademis'] == 'Cukup') ? 'selected' : ''?>>Cukup</option>
                                <option value="Kurang" <?php echo ($detail['pencapaianAkademis'] == 'Kurang') ? 'selected' : ''?>>Kurang</option>
                            </select>
                        </div>
                </div>
                <div>
                    <label>d.Keterlibatan dalam kegiatan ekstrakulikuler</label>
                        <div class="form-floating mb-3">
                            <select class="form-select form-select-sm js-choice px-3" size="1" name="cboekskul" id="cboekskul" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="Baik" <?php echo ($detail['keterlibatanEkskul'] == 'Baik') ? 'selected' : ''?>>Baik</option>
                                <option value="Cukup" <?php echo ($detail['keterlibatanEkskul'] == 'Cukup') ? 'selected' : ''?>>Cukup</option>
                                <option value="Kurang" <?php echo ($detail['keterlibatanEkskul'] == 'Kurang') ? 'selected' : ''?>>Kurang</option>
                            </select>
                        </div>
                </div>
            </div>
            <div>
                <label>4.Hasil Rekomendasi</label>
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm js-choice px-3" size="1" name="cbohasilrekom" id="cbohasilrekom" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="Intervensi Pendidikan" <?php echo ($detail['hasilRekomendasi'] == 'Intervensi Pendidikan') ? 'selected' : ''?>>Intervensi Pendidikan</option>
                        <option value="Bantuan Ekonomi"<?php echo ($detail['hasilRekomendasi'] == 'Bantuan Ekonomi') ? 'selected' : ''?>>Bantuan Ekonomi</option>
                        <option value="Konseling Kesehatan" <?php echo ($detail['hasilRekomendasi'] == 'Konseling Kesehatan') ? 'selected' : ''?>>Konseling Kesehatan</option>
                        <option value="Intervensi Sosial" <?php echo ($detail['hasilRekomendasi'] == 'Intervensi Sosial') ? 'selected' : ''?>>Intervensi Sosial</option>
                        <option value="Lainnya" <?php echo ($detail['hasilRekomendasi'] != null &&  $detail['hasilRekomendasi'] != 'Intervensi Pendidikan' && $detail['hasilRekomendasi'] != 'Bantuan Ekonomi' 
                        && $detail['hasilRekomendasi'] != 'Konseling Kesehatan' && $detail['hasilRekomendasi'] != 'Intervensi Sosial') ? 'selected' : ''?>>Lainnya</option>
                    </select>
                    <input type="text" class="form-control form-control-sm mt-2" id="txtHasilRekomLainnya" 
                    style="display:none;"
                    value="<?php echo ($detail['hasilRekomendasi'] != 'Intervensi Pendidikan' && $detail['hasilRekomendasi'] != 'Bantuan Ekonomi' 
                    && $detail['hasilRekomendasi'] != 'Konseling Kesehatan' && $detail['hasilRekomendasi'] != 'Intervensi Sosial') ? $detail['hasilRekomendasi'] : ''; ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600"><b>Upload Foto Survei</b><br>File foto harus file
                gambar berextensi .jpg</p>
            <input class="form-control form-control-sm" id="btnUploadTutorial" type="file" accept=".jpg" />
        </div>
    </div>

</div>

<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanSurvei">Simpan data</button>
</div>

<script>
    $(document).ready(function() {
    $('#cboklasifikasi').change(function() {
        if($(this).val() == 'Lainnya') {
            $('#txtKlasifikasiLainnya').show();
        } else {
            $('#txtKlasifikasiLainnya').hide();
        }
    });

    if($('#cboklasifikasi').val() == 'Lainnya') {
        $('#txtKlasifikasiLainnya').show();
    }

    $('#cbohasilrekom').change(function() {
        if($(this).val() == 'Lainnya') {
            $('#txtHasilRekomLainnya').show();
        } else {
            $('#txtHasilRekomLainnya').hide();
        }
    });

    if($('#cbohasilrekom').val() == 'Lainnya') {
        $('#txtHasilRekomLainnya').show();
    }
});
</script>

<script type="text/javascript" charset="utf-8">

$('#btnUploadTutorial').bind('change', function() {
    var extensinya = $('#btnUploadTutorial').val().toLowerCase();
    var regex = new RegExp("(.*?)\.(jpg)$");
    if (!(regex.test(extensinya))) {
        alert("File upload foto survei harus file berextensi .jpg");
        $('#btnUploadTutorial').val(null);
    }
});

    $("#cmdSimpanSurvei").click(function() {
        let idsiswa = $('#txtidsiswasurveiAts').val();
        let idsurveyor = $('#txtidsurveyorsurveiAts').val();
        
        let klasifikasi = $('#cboklasifikasi').val();

        if(klasifikasi == 'Lainnya') {
            klasifikasi = $('#txtKlasifikasiLainnya').val();
        }
        let faktorEkonomi = $('#cbofaktorekonomi').val();
        let faktorKesehatan = $('#cbofaktorkesehatan').val();
        let faktorSosial = $('#cbofaktorsosial').val();
        let faktorGeografis = $('#cbofaktorgeografis').val();
        let faktorPendidikan = $('#cbofaktorpendidikan').val();
        let faktorKeluarga = $('#cbofaktorkeluarga').val();
        let statusGizi = $('#cbostatusgizi').val();
        let riwayatPindahSekolah = $('#cboriwayatpindahsekolah').val();
        let pencapaianAkademis = $('#cbopencapaianakademis').val();
        let keterlibatanEkskul = $('#cboekskul').val();
        let hasilRekomendasi = $('#cbohasilrekom').val();

        if(hasilRekomendasi == 'Lainnya') {
            hasilRekomendasi = $('#txtHasilRekomLainnya').val();
        }

        let nmfile = $('#btnUploadTutorial').val();

        let data = new FormData();
        data.append('upTutorial', $("#btnUploadTutorial")[0].files[0]);
        data.append('idsiswa', idsiswa);
        data.append('idsurveyor', idsurveyor);
        data.append('klasifikasi', klasifikasi);
        data.append('faktorEkonomi', faktorEkonomi);    
        data.append('faktorKesehatan', faktorKesehatan);
        data.append('faktorSosial', faktorSosial);
        data.append('faktorGeografis', faktorGeografis);
        data.append('faktorPendidikan', faktorPendidikan);
        data.append('faktorKeluarga', faktorKeluarga);
        data.append('statusGizi', statusGizi);
        data.append('riwayatPindahSekolah', riwayatPindahSekolah);
        data.append('pencapaianAkademis', pencapaianAkademis);  
        data.append('keterlibatanEkskul', keterlibatanEkskul);
        data.append('hasilRekomendasi', hasilRekomendasi);

        if (idsurveyor.length <= 0) {
            alert('Data surveyor tidak terdeteksi')
        } else if (idsiswa.length <= 0) {
            alert('Data siswa tidak terdeteksi')
        } else if (nmfile.length <= 0) {
            alert('File upload foto survei masih kosong')
        } else {
            $.ajax({
                type: "POST",
                url: 'aksi/surveyor/aksi_tambah_survei.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#cmdSimpanSurvei").attr("disabled", "disabled");
                },
                success: function(resp) {
                    if (resp.msg2 == 'ok') {
                        setTimeout(function() {
                            $('#modEditDataLarge').modal('hide');
                        }, 1000);
                        $("#ToastSukses").toast("show");
                        isiMasterSurveyor();
                    } else if (resp.msg2 == 'err_val') {
                        alert(resp.msg1);
                        $("#cmdSimpanSurvei").removeAttr("disabled");
                    } else {
                        alert('Ada sedikit masalah, silakan coba lagi.');
                        $("#cmdSimpanSurvei").removeAttr("disabled");
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error Details:', {
            status: status,
            error: error,
            responseText: xhr.responseText
        });
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanSurvei").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
        
    });
</script>