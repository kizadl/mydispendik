<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

require_once '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$styleJudul = [
	'font' => [
		'bold' => true,
		'size' => 11,
	],
	'alignment' => [
		'horizontal' => Alignment::HORIZONTAL_CENTER,
		'vertical' => Alignment::VERTICAL_CENTER,
	],
	'borders' => [
		'top' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
		'right' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
		'bottom' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
		'left' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
	],
];

$styleBorderTable = [
	'borders' => [
		'right' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
		],
		'bottom' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
		],
		'left' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
		],
	],
];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

//Set Default Teks
$spreadsheet->getDefaultStyle()
	->getFont()
	->setName('Calibri')
	->setSize(11);

$spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(18);
$spreadsheet->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$spreadsheet->getActiveSheet()->getRowDimension(3)->setRowHeight(18);

//Style Judul table
$spreadsheet->getActiveSheet()
	->setCellValue('A1', "DATA SISWA ATS")
	->setCellValue('A2', "JUMLAH SEKOLAH DI KABUPATEN JEMBER")
	->mergeCells('A1:C1')
	->mergeCells('A2:C2');

$spreadsheet->getActiveSheet()
->getStyle('A1:A2')
->getFont()
->setSize(11)
->setBold(true);

$spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

// style lebar kolom
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);

// SET judul table
$spreadsheet->getActiveSheet()
	->setCellValue('A3', "NO")
	->setCellValue('B3', "BENTUK SEKOLAH")
	->setCellValue('C3', "JUMLAH");

// STYLE judul table
$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleJudul);
$spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($styleJudul);
$spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($styleJudul);

$sqlx = ("SELECT DISTINCT (bentuk_pendidikan) AS nmbentuksekolah FROM tbl_api_dispendik");
$result = mysqli_query($dbconn, $sqlx);
$i = 4;
$no = 1;
$totaldetail = 0;
while ($t = mysqli_fetch_array($result)) {

	$sqlcount = ("SELECT COUNT(id) as jumDetSekolah FROM tbl_api_dispendik WHERE bentuk_pendidikan = '".$t['nmbentuksekolah']."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);
	$totaldetail = $totaldetail + $s['jumDetSekolah'];

	$sheet->setCellValue('A' . $i, $no++);
	$sheet->setCellValue('B' . $i, strtoupper($t['nmbentuksekolah']));
	$sheet->setCellValue('C' . $i, number_format($totaldetail,0,".",","));

	$spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(17);
	$spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleBorderTable);
	$spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleBorderTable);
	$spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleBorderTable);
	$i++;
} 


header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream');
header('Content-Type: application/download');
header('Content-Disposition: attachment;filename="dispendik-bentuk-sekolah.xlsx"');
header('Content-Transfer-Encoding: binary');

ob_end_clean();
ob_start();

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('hasil/dispendik-bentuk-sekolah.xlsx'); 
echo "<script>window.location = 'aksi/lap-excel/hasil/dispendik-bentuk-sekolah.xlsx'</script>";

?>