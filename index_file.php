<?php
require_once "vendor/autoload.php";

use lib\ExportDataExcel;

function genRandomString($length = 100)
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz _";
    $string = "";
    for ($p = 0; $p < $length; $p++)
    {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
}

$excel = new ExportDataExcel('file','/Users/Mike/Downloads/');

$excel->filename = "test_big_excel.xls";

$excel->initialize();
for($i = 1; $i<10000; $i++)
{
    $row = array($i, genRandomString(), genRandomString(), genRandomString(), genRandomString(), genRandomString());
    $excel->addRow($row);
}
$excel->finalize();


print "memory used: " . number_format(memory_get_peak_usage());
