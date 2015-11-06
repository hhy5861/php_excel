<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 11/6/15
 * Time: 11:18 PM
 */

namespace lib;

class ExportDataTSV extends ExportData
{
    public function generateRow($row)
    {
        foreach ($row as $key => $value)
        {
            $row[$key] = '"'. str_replace('"', '\"', $value) .'"';
        }

        return implode("\t", $row) . "\n";
    }

    public function sendHttpHeaders()
    {
        header("Content-type: text/tab-separated-values");
        header("Content-Disposition: attachment; filename=".basename($this->filename));
    }
}