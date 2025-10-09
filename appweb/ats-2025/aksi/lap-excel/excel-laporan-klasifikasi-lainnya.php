<?php
session_start();
include "../../../services/config.php";
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$idkecamatan = $_GET['idkecamatan'];
$iddesa = $_GET['iddesa'];
$namakecamatan = $_GET['namakecamatan'];
$namadesa = $_GET['namadesa'];

// Query untuk mengambil data siswa dengan klasifikasi selain LTM, DO, BPB (termasuk yang kosong)
$query = "SELECT 
    r.nama_kecamatan as kecamatan,
    s.nama_desa as desa,
    p.nama_sekolah,
    p.nama_siswa,
    p.jenis_kelamin,
    COALESCE(JSON_UNQUOTE(JSON_EXTRACT(q.detail, '$.klasifikasi')), 'BELUM DIKATEGORIKAN') as klasifikasi
FROM tbl_ats_2025 p
LEFT JOIN ats_detail_survei_2025 q ON p.id_siswa = q.id_siswa
LEFT JOIN m_kecamatan r ON p.kd_kecamatan = r.kd_kecamatan
LEFT JOIN m_desa s ON p.kd_desa = s.kd_desa
WHERE p.survei = 'Y' 
    AND (
        LOWER(JSON_UNQUOTE(JSON_EXTRACT(q.detail, '$.klasifikasi'))) NOT IN ('ltm', 'do', 'bpb')
        OR JSON_UNQUOTE(JSON_EXTRACT(q.detail, '$.klasifikasi')) IS NULL
        OR JSON_UNQUOTE(JSON_EXTRACT(q.detail, '$.klasifikasi')) = ''
    )";

// Tambahkan filter jika ada
if ($idkecamatan != "all") {
    $query .= " AND p.kd_kecamatan = '" . mysqli_real_escape_string($dbconn, $idkecamatan) . "'";
}

if ($iddesa != "all") {
    $query .= " AND p.kd_desa = '" . mysqli_real_escape_string($dbconn, $iddesa) . "'";
}

$query .= " ORDER BY r.nama_kecamatan, s.nama_desa, p.nama_siswa";

$result = mysqli_query($dbconn, $query);

// Tentukan judul laporan berdasarkan filter
if ($idkecamatan == "all") {
    $judulWilayah = "Semua Wilayah";
    $judulExcel = "Semua Wilayah";
} else {
    if ($iddesa == "all") {
        $judulWilayah = $namakecamatan;
        $judulExcel = $namakecamatan;
    } else {
        $judulWilayah = $namakecamatan . " - Desa " . $namadesa;
        $judulExcel = $namakecamatan . "-" . $namadesa;
    }
}

// Set header untuk download Excel
$judulExcelSafe = strtolower($judulExcel);
$judulExcelSafe = str_replace(' ', '-', $judulExcelSafe);
$filename = "data-klasifikasi-lainnya-" . $judulExcelSafe . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Siswa Klasifikasi Lainnya - <?php echo $judulWilayah; ?></title>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="center" colspan="7" style="font-size:22px; font-weight:bold;">
                Laporan Data Siswa - Klasifikasi Lainnya
            </td>
        </tr>
        <tr>
            <td align="center" colspan="7" style="font-size:18px; font-weight:bold;">
                Kabupaten Jember - <?php echo $judulWilayah; ?>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="7" style="font-size:18px; font-weight:bold;">
                Tahun 2025
            </td>
        </tr>
    </table>
    <br>

    <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>No.</th>
                <th>Nama Sekolah</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Klasifikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td align='center'>" . $no . "</td>";
                echo "<td>" . (trim($row['nama_sekolah']) != '' ? trim($row['nama_sekolah']) : '-') . "</td>";
                echo "<td>" . (trim($row['kecamatan']) != '' ? trim($row['kecamatan']) : '-') . "</td>";
                echo "<td>" . (trim($row['desa']) != '' ? trim($row['desa']) : '-') . "</td>";
                echo "<td>" . (trim($row['nama_siswa']) != '' ? trim($row['nama_siswa']) : '-') . "</td>";
                echo "<td align='center'>" . (trim($row['jenis_kelamin']) != '' ? trim($row['jenis_kelamin']) : '-') . "</td>";
                echo "<td>" . (trim($row['klasifikasi']) != '' ? trim($row['klasifikasi']) : '-') . "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

    <br>
    <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="right">
                <p>Dicetak pada: <?php echo date('d-m-Y H:i:s'); ?></p>
            </td>
        </tr>
    </table>
</body>

</html>