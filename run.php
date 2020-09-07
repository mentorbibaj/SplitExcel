<?php 

require "vendor/autoload.php";
require "config.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$excel = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y', 'Z', 
		  'AA','AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY', 'AZ',
		  'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY', 'BZ'
		];//if u need more columns feel free to add them here
$num_rows  = 3;
$extension = "xlsx";
$start_row = 1; 

$reader = Asan\PHPExcel\Excel::load($filename.".".$extension, function(Asan\PHPExcel\Reader\Xlsx $reader) {
    $reader->setRowLimit($num_rows);
    $reader->setColumnLimit($num_cols);
    $reader->ignoreEmptyRow(false);
    $reader->setSheetIndex($sheet);
});
$reader->seek($start_row);
$current      = $reader->current();
$count 	      = $reader->count();
$sheets       = $reader->sheets();

$counter      = 1;
$file_number  = 1;
$full_counter = 1;
foreach ($reader as $value) {
	if($full_counter != 1){
		if($counter == 1){
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
		}

		for($i = 1; $i <= $num_cols; $i++){
			if($counter == 1)
				$sheet->setCellValue($excel[$i-1].$counter, $current[$i-1]);
			$sheet->setCellValue($excel[$i-1].($counter+1), $value[$i-1]);
		}

		if($counter == $seperate_after_rows || $full_counter == $count){//
			$writer = new Xlsx($spreadsheet);
			$writer->save($filename."_".$file_number.'.'.$extension);
			$file_number = $file_number + 1;
			$counter = 0;
		}
		$counter++;
	}
	$full_counter++;
}