<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 for debugging
header('Content-Type: application/json');
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

// Ambil parameter filter
$idkecamatan = isset($_POST['idkecamatan']) ? trim($_POST['idkecamatan']) : 'all';
$iddesa = isset($_POST['iddesa']) ? trim($_POST['iddesa']) : 'all';

// Base query untuk mengambil data siswa dengan klasifikasi selain LTM, DO, BPB (termasuk yang kosong)
$sql = "SELECT 
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
if ($idkecamatan != "all" && !empty($idkecamatan)) {
    $sql .= " AND p.kd_kecamatan = '" . mysqli_real_escape_string($dbconn, $idkecamatan) . "'";
}

if ($iddesa != "all" && !empty($iddesa)) {
    $sql .= " AND p.kd_desa = '" . mysqli_real_escape_string($dbconn, $iddesa) . "'";
}

$sql .= " ORDER BY r.nama_kecamatan, s.nama_desa, p.nama_siswa";

$result = mysqli_query($dbconn, $sql);

$data = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'nama_sekolah' => trim($row['nama_sekolah']) !== '' ? trim($row['nama_sekolah']) : '-',
            'kecamatan' => trim($row['kecamatan']) !== '' ? trim($row['kecamatan']) : '-',
            'desa' => trim($row['desa']) !== '' ? trim($row['desa']) : '-',
            'nama_siswa' => trim($row['nama_siswa']) !== '' ? trim($row['nama_siswa']) : '-',
            'jenis_kelamin' => trim($row['jenis_kelamin']) !== '' ? trim($row['jenis_kelamin']) : '-',
            'klasifikasi' => trim($row['klasifikasi']) !== '' ? trim($row['klasifikasi']) : '-'
        );
    }
}

echo json_encode($data);
