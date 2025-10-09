<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');	
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
} 

$idsurat = trim($_POST['idsurat']);

$sqlx = ("SELECT p.id_surat,p.no_surat,p.tgl_surat,p.nik,p.nama,p.alamat,p.file_surat,
		p.ket_level,p.stts_level_1,p.stts_level_2,p.stts_level_3,p.stts_level_4,p.stts_level_5,p.stts_level_6,p.stts_level_7,p.ket_status,
		p.waktu_level_1,p.waktu_level_2,p.waktu_level_3,p.waktu_level_4,p.waktu_level_5,p.waktu_level_6,p.waktu_level_7,
		p.id_layanan,p.id_instansi,
    r.layanan,s.nm_instansi
		FROM trans_surat p 
		LEFT JOIN m_layanan r ON p.id_layanan=r.id_layanan
		LEFT JOIN m_instansi s ON p.id_instansi=s.id_instansi
		WHERE p.id_surat='".$idsurat."'");

$restps = mysqli_query($dbconn,$sqlx);$sm= mysqli_fetch_assoc($restps);

$nosurat = $sm['no_surat'];
$tglsurat = tgl_indo($sm['tgl_surat']);
$layanan = ucwords(strtolower($sm['layanan']));
$nminstansi = $sm['nm_instansi'];
$nik = $sm['nik'];$nmpemohon = $sm['nama'];$alamat = $sm['alamat'];

/////// DETAIL TOLAK ///////////
$sqltolak = ("SELECT catatan_tolak,ket_level,waktu_tolak,status_akhir
		FROM detail_tolak WHERE id_surat='".$idsurat."'");
$resulttolak = mysqli_query($dbconn,$sqltolak);
$catatantolak2="";$catatantolak3="";$catatantolak4="";$catatantolak5="";$catatantolak6="";$catatantolak7="";
$tgltolak2="";$tgltolak3="";$tgltolak4="";$tgltolak5="";$tgltolak6="";$tgltolak7="";
$jamtolak2="";$jamtolak3="";$jamtolak4="";$jamtolak5="";$jamtolak6="";$jamtolak7="";

$hidtolak2 = "display:none !important";$hidtolak3 = "display:none !important";$hidtolak4 = "display:none !important";
$hidtolak5 = "display:none !important";$hidtolak6 = "display:none !important";$hidtolak7 = "display:none !important";
while($t=mysqli_fetch_array($resulttolak)){
	$ketleveltolak = $t['ket_level'];
  if ($ketleveltolak == "level 2"){$catatantolak2 = $t['catatan_tolak'];$hidtolak2 = "";
    $tgltolak2 = tgl_indo($t['waktu_tolak']);$jamtolak2 = date("H:i",strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "level 3"){$catatantolak3 = $t['catatan_tolak'];$hidtolak3 = "";
    $tgltolak3 = tgl_indo($t['waktu_tolak']);$jamtolak3 = date("H:i",strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "level 4"){$catatantolak4 = $t['catatan_tolak'];$hidtolak4 = "";
    $tgltolak4 = tgl_indo($t['waktu_tolak']);$jamtolak4 = date("H:i",strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "level 5"){$catatantolak5 = $t['catatan_tolak'];$hidtolak5 = "";
    $tgltolak5 = tgl_indo($t['waktu_tolak']);$jamtolak5 = date("H:i",strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "level 6"){$catatantolak6 = $t['catatan_tolak'];$hidtolak6 = "";
    $tgltolak5 = tgl_indo($t['waktu_tolak']);$jamtolak6 = date("H:i",strtotime($t['waktu_tolak']));
  }
  if ($ketleveltolak == "level akhir"){$catatantolak7 = $t['catatan_tolak'];$hidtolak7 = "";
    $tgltolak6 = tgl_indo($t['waktu_tolak']);$jamtolak7 = date("H:i",strtotime($t['waktu_tolak']));
  }
}
////////////////////////////////////////

$sttslevel1 = ucwords(strtolower($sm['stts_level_1']));
if ($sttslevel1 == "terkirim"){$dislevel1 = "";} else if ($sttslevel1 == "Belum"){$dislevel1 = "display:none !important";}
$tgllevel1 = tgl_indo($sm['waktu_level_1']);$jamlevel1 = date("H:i",strtotime($sm['waktu_level_1']));

$sttslevel2 = ucwords(strtolower($sm['stts_level_2']));
if ($sttslevel2 =="Terima"){$dislevel2 = "";} 
else if ($sttslevel2 == "Belum"){$dislevel2 = "display:none !important";}
$tgllevel2 = tgl_indo($sm['waktu_level_2']);$jamlevel2 = date("H:i",strtotime($sm['waktu_level_2']));

$sttslevel3 = ucwords(strtolower($sm['stts_level_3']));
if ($sttslevel3 =="Terima"){$dislevel3 = "";} 
else if ($sttslevel3 == "Belum"){$dislevel3 = "display:none !important";}
$tgllevel3 = tgl_indo($sm['waktu_level_3']);$jamlevel3 = date("H:i",strtotime($sm['waktu_level_3']));

$sttslevel4 = ucwords(strtolower($sm['stts_level_4']));
if ($sttslevel4 =="Terima"){$dislevel4 = "";} 
else if ($sttslevel4 == "Belum"){$dislevel4 = "display:none !important";}
$tgllevel4 = tgl_indo($sm['waktu_level_4']);$jamlevel4 = date("H:i",strtotime($sm['waktu_level_4']));

$sttslevel5 = ucwords(strtolower($sm['stts_level_5']));
if ($sttslevel5 =="Terima"){$dislevel5 = "";} 
else if ($sttslevel5 == "Belum"){$dislevel5 = "display:none !important";}
$tgllevel5 = tgl_indo($sm['waktu_level_5']);$jamlevel5 = date("H:i",strtotime($sm['waktu_level_5']));

$sttslevel6 = ucwords(strtolower($sm['stts_level_6']));
if ($sttslevel6 =="Terima"){$dislevel6 = "";} 
else if ($sttslevel6 == "Belum"){$dislevel6 = "display:none !important";}
$tgllevel6 = tgl_indo($sm['waktu_level_6']);$jamlevel6 = date("H:i",strtotime($sm['waktu_level_5']));

$sttslevel7 = ucwords(strtolower($sm['ket_status']));
if ($sttslevel7 =="Terima"){$dislevel7 = "";} 
else if ($sttslevel7 == "Belum"){$dislevel7 = "display:none !important";}
$tgllevel7 = tgl_indo($sm['waktu_validasi']);$jamlevel7 = date("H:i",strtotime($sm['waktu_validasi']));

if ($sm['ket_level']==1){
  $tandalevel1 = "timeline-success timeline-current";
  $tandalevel2 = "timeline-primary";
  $tandalevel3 = "timeline-primary";
  $tandalevel4 = "timeline-primary";
  $tandalevel5 = "timeline-primary";
  $tandalevel6 = "timeline-primary";
  $tandalevel7 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
} else if ($sm['ket_level']==2){
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-success timeline-current";
  $tandalevel3 = "timeline-primary";
  $tandalevel4 = "timeline-primary";
  $tandalevel5 = "timeline-primary";
  $tandalevel6 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
} else if ($sm['ket_level']==3){
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-success timeline-current";
  $tandalevel4 = "timeline-primary";
  $tandalevel5 = "timeline-primary";
  $tandalevel6 = "timeline-primary";
  $tandalevel7 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
} else if ($sm['ket_level']==4){
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-success timeline-current";
  $tandalevel5 = "timeline-primary";
  $tandalevel6 = "timeline-primary";
  $tandalevel7 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
} else if ($sm['ket_level']==5){
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-primary timeline-current";
  $tandalevel5 = "timeline-success timeline-current";
  $tandalevel6 = "timeline-primary";
  $tandalevel7 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
} else if ($sm['ket_level']==6){
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-primary timeline-current";
  $tandalevel5 = "timeline-primary timeline-current";
  $tandalevel6 = "timeline-success timeline-current";
  $tandalevel7 = "timeline-primary";
  $tandalevelakhir = "timeline-primary";
} else if ($sm['ket_level']==7){
  $tandalevel1 = "timeline-primary timeline-current";
  $tandalevel2 = "timeline-primary timeline-current";
  $tandalevel3 = "timeline-primary timeline-current";
  $tandalevel4 = "timeline-primary timeline-current";
  $tandalevel5 = "timeline-primary timeline-current";
  $tandalevel6 = "timeline-primary timeline-current";
  $tandalevel7 = "timeline-primary timeline-current";
  $tandalevelakhir = "timeline-success timeline-current";
}

mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Timeline Status Arsip Surat</h5>
        <p class="fs--1 mb-0 text-white">Timeline Status Arsip <?php echo $layanan ?></p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body bg-light py-3 px-4">

	<div class="row mb-3 mt-2 g-3">
      <div class="col-md-12 bg-light"> 
                  <div class="row g-3 timeline timeline-primary timeline-past pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-graduate"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1"><?php echo $nmpemohon ?></h6>
                          <p class="fs--1 text-600 mb-0">NIK. <?php echo $nik ?></p>
						  <p class="fs--1 text-600 mb-0"><?php echo $alamat ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row g-3 timeline timeline-primary timeline-past pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-envelope"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1"><?php echo $nosurat ?></h6>
                          <p class="fs--1 text-600 mb-0"><?php echo $layanan ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row g-3 timeline <?php echo $tandalevel1 ?> pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-chalkboard-teacher"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1">Operator</h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel1 ?>"><?php echo $tgllevel1 ?>  Jam <?php echo $jamlevel1 ?></p>
						  <p class="fs--1 text-600 mb-0">Status <?php echo $sttslevel1 ?></p>
                        </div>
                        
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 timeline <?php echo $tandalevel2 ?> pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-friends"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1">Kasi Pelayanan</h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel2 ?>"><?php echo $tgllevel2 ?>  Jam <?php echo $jamlevel2 ?></p>
						  <p class="fs--1 text-600 mb-0">Status <?php echo $sttslevel2 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak2 ?>"><?php echo $catatantolak2 ?></p>
                        </div>
                        
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 timeline <?php echo $tandalevel3 ?> pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-friends"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1">Operator <?php echo ucwords(strtolower($nminstansi)) ?></h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel3 ?>"><?php echo $tgllevel3 ?>  Jam <?php echo $jamlevel3 ?></p>
						  <p class="fs--1 text-600 mb-0">Status <?php echo $sttslevel3 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak3 ?>"><?php echo $catatantolak3 ?></p>
                        </div>
                        
                      </div>
                    </div>
                  </div>

				  <div class="row g-3 timeline <?php echo $tandalevel4 ?> pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-friends"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1">Kepala Bidang <?php echo ucwords(strtolower($nminstansi)) ?></h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel4 ?>"><?php echo $tgllevel4 ?>  Jam <?php echo $jamlevel4 ?></p>
						  <p class="fs--1 text-600 mb-0">Status <?php echo $sttslevel4 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak4 ?>"><?php echo $catatantolak4 ?></p>
                        </div>
                        
                      </div>
                    </div>
                  </div>

				  <div class="row g-3 timeline <?php echo $tandalevel5 ?> pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-tie"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1">Kepala <?php echo ucwords(strtolower($nminstansi)) ?></h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel5 ?>"><?php echo $tgllevel5 ?>  Jam <?php echo $jamlevel5 ?></p>
						  <p class="fs--1 text-600 mb-0">Status <?php echo $sttslevel5 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak5 ?>"><?php echo $catatantolak5 ?></p>
                        </div>
                        
                      </div>
                    </div>
                  </div>

				  <div class="row g-3 timeline <?php echo $tandalevel6 ?> pb-card">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-friends"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0 border-bottom pb-card">
                        <div class="col">
                          <h6 class="text-800 mb-1">Kasi Persetujuan</h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel6 ?>"><?php echo $tgllevel6 ?>  Jam <?php echo $jamlevel6 ?></p>
						  <p class="fs--1 text-600 mb-0">Status <?php echo $sttslevel6 ?></p>
              <p class="fs--1 mt-2 mb-0" style="<?php echo $hidtolak6 ?>"><?php echo $catatantolak6 ?></p>
                        </div>
                        
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 timeline <?php echo $tandalevelakhir ?>">
                    <div class="col-auto ps-4 ms-2">
                      <div class="ps-2">
                        <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-user-tie"></span></div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row gx-0">
                        <div class="col">
                          <h6 class="text-800 mb-1">Kepala Dinas PTSP</h6>
                          <p class="fs--1 text-600 mb-0" style="<?php echo $dislevel7 ?>"><?php echo $tgllevel7 ?>  Jam <?php echo $jamlevelt ?></p>
						  <p class="fs--1 text-600 mb-0">Status Akhir <?php echo $sttslevel7 ?></p>
                        </div>
                    
                      </div>
                    </div>
                  </div>

      </div>
    </div>

</div>
<div class="modal-footer float-right">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Close</button>
</div>
