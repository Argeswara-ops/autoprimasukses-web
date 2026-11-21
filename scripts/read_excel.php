<?php

require __DIR__.'/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Increase memory limit modestly (you can adjust if needed)
ini_set('memory_limit', '1G');

// Absolute path to the uploaded Excel file
$excelPath = 'C:/Users/Argeswara/.gemini/antigravity/brain/ec1c9099-0b44-4541-b139-7fe4b864933b/.user_uploaded/media_1795056383537_52f533a4.xlsx';

if (! file_exists($excelPath)) {
    echo "Excel file not found: $excelPath\n";
    exit(1);
}

// Create a reader in read‑only mode to reduce memory usage
$reader = IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(true); // ignore styling, comments, etc.
$spreadsheet = $reader->load($excelPath);
// Use the sheet named 'Jatim' if it exists, otherwise the first sheet
$sheet = $spreadsheet->getSheetByName('Jatim') ?? $spreadsheet->getSheet(0);

// Collect rows into an array (stop when a row is completely empty)
$data = [];
foreach ($sheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);
    $rowData = [];
    foreach ($cellIterator as $cell) {
        $rowData[$cell->getColumn()] = $cell->getCalculatedValue();
    }
    // Break if the entire row is empty (no values)
    if (empty(array_filter($rowData, fn ($v) => $v !== null && $v !== ''))) {
        break;
    }
    $data[] = $rowData;
}

// Output as pretty‑printed JSON for inspection
echo json_encode($data, JSON_PRETTY_PRINT);
