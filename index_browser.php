<?php
require_once "vendor/autoload.php";

use lib\ExportDataExcel;

$excel = new ExportDataExcel('browser','/Users/Mike/Downloads/');
$excel->filename = rand(1,100) . ".xls";

$excel->initialize();

for($i = 1; $i<50000; $i++)
{
    $row = array($i, genRandomString(), genRandomString());
    $excel->addRow($row);
}

/*foreach($data as $row)
{
    $excel->addRow($row);
}*/
$excel->finalize();


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
