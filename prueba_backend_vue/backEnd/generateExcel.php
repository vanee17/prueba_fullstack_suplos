<?php
include '../config/db.php';
require '../../vendor/autoload.php'; // Ruta al archivo autoload.php de PhpSpreadsheet

$data = json_decode(file_get_contents("php://input"), true);
// Permitir los métodos GET, POST y OPTIONS
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Permitir las cabeceras Content-Type y Authorization
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
 // Crear un nuevo objeto Spreadsheet
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
// Obtener la hoja activa del archivo
$sheet = $spreadsheet->getActiveSheet();
// Establecer los encabezados de las columnas
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Objeto');
$sheet->setCellValue('C1', 'Descripción');
$sheet->setCellValue('D1', 'Fecha inicio');
$sheet->setCellValue('E1', 'Fecha cierre');
$sheet->setCellValue('F1', 'Estado');

$row = 2;
foreach ($data as $item) {
    $sheet->setCellValue('A' . $row, $item['id']);
    $sheet->setCellValue('B' . $row, $item['objeto']);
    $sheet->setCellValue('C' . $row, $item['descripcion']);
    $sheet->setCellValue('D' . $row, $item['fecha_inicio']);
    $sheet->setCellValue('E' . $row, $item['fecha_cierre']);
    $sheet->setCellValue('F' . $row, $item['estado']);
    $row++;
}
// Crear un objeto Writer para guardar el archivo Excel
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
// Establecer las cabeceras para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="resultados.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');