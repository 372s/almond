<?php
require_once dirname(__DIR__) . '/../vendor/autoload.php';

$filename = "example.xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$rows = array(
    array('姓名', '性别', '时间', '工号'),
    array('wangqiang', '男', '2010-01-01 23:00:00', 'ad9999999999999999999999999'),
);

$writer = new XLSXWriter();
$writer->setAuthor('Some Author'); 
foreach($rows as $row) {
	$writer->writeSheetRow('Sheet1', $row);
}
$writer->writeToStdOut();
//$writer->writeToFile('example.xlsx');
//echo $writer->writeToString();
exit(0);

// $header = array(
//     '时间'=>'datetime',
//     'product_id'=>'integer',
//     'quantity'=>'#,##0',
//     'amount'=>'price',
//     'description'=>'string',
//     'tax'=>'[$$-1009]#,##0.00;[RED]-[$$-1009]#,##0.00',
// );
// $data = array(
//     array('2015-01-01 12:00:00',873,1,'44.00','misc','=D2*0.05'),
//     array('2015-01-12 12:00:00',324,2,'88.00','none','=D3*0.05'),
// );

// $writer = new XLSXWriter();
// $writer->writeSheetHeader('Sheet1', $header );
// foreach($data as $row) {
//     $writer->writeSheetRow('Sheet1', $row );
// }
// $writer->writeToStdOut();exit();
// $writer->writeToFile('example.xlsx');



// $data = array(
//     array('year','month','amount'),
//     array('2003','1','220'),
//     array('2003','2','153.5'),
// );

// $writer = new XLSXWriter();
// $writer->writeSheet($data);
// $writer->writeToFile('output.xlsx');

// if (file_exists('output.xlsx')) {
//     // header('location:http://php-study.test/output.xlsx');
// } else {
//     // header('HTTP/1.1 404 Not Found');
// }
