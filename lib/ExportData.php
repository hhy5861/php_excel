<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 11/6/15
 * Time: 11:15 PM
 */

namespace lib;

use Exception;

abstract class ExportData
{
    public $filename;

    public $tempFilename;

    protected $exportTo;

    protected $tempFile;

    protected $stringData;

    public function __construct($exportTo = "browser", $filename = "exportdata")
    {
        if(!in_array($exportTo, array('browser','file','string') ))
        {
            throw new Exception("$exportTo is not a valid ExportData export type");
        }

        $this->exportTo = $exportTo;

        $this->filename = $filename;
    }

    public function initialize()
    {

        switch($this->exportTo)
        {
            case 'browser':
                $this->sendHttpHeaders();
                break;
            case 'string':
                $this->stringData = '';
                break;
            case 'file':
                if(!$this->tempFilename && !is_dir($this->tempFilename))
                {
                    $this->tempFilename = tempnam(sys_get_temp_dir(), 'exportdata');
                }
                $this->tempFile = fopen($this->tempFilename, "w");
                break;
        }

        $this->write($this->generateHeader());
    }

    public function addRow($row)
    {
        $this->write($this->generateRow($row));
    }

    public function finalize()
    {

        $this->write($this->generateFooter());

        switch($this->exportTo)
        {
            case 'browser':
                flush();
                break;
            case 'string':
                //@TODO
                break;
            case 'file':
                fclose($this->tempFile);
                rename($this->tempFilename, $this->filename);
                break;
        }
    }

    public function getString()
    {
        return $this->stringData;
    }

    abstract public function sendHttpHeaders();

    protected function write($data)
    {
        switch($this->exportTo)
        {
            case 'browser':
                echo $data;
                break;
            case 'string':
                $this->stringData .= $data;
                break;
            case 'file':
                fwrite($this->tempFile, $data);
                break;
        }
    }

    protected function generateHeader()
    {

    }

    protected function generateFooter()
    {

    }

    abstract protected function generateRow($row);
}