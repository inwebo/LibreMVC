<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 14:23
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database\Driver;
use LibreMVC\Database\Driver;

class SqLite extends Driver implements IDriver{

    const COLS_NAME = "name";
    const COLS_TYPE = "type";
    const COLS_NULLABLE = "notnull";
    const COLS_DEFAULT = "dflt_value";
    const COLS_PRIMARY_KEY = "pk";
    const COLS_PRIMARY_VALUE = "1";

    public $filename;
    protected $dsn;
    protected $toMemory;
    protected $version;

    public function __construct( $filename = "", $version = 3 ) {
        parent::__construct();
        try {
            $this->toMemory = empty($filename);
            $this->filename = ($this->isValidDataBaseFile($filename)) ? $filename : "";
            $this->version = $version;
            $this->dsn = $this->prepareDSN() ;
            $this->resource = new \PDO($this->dsn);
            $this->resource->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $this->resource;
        } catch (\Exception $error_string) {
            echo $error_string->getMessage();
        }
    }

    protected function prepareDSN() {
        $dsn = "sqlite";
        switch($this->version) {
            default:
            case 3:
                $dsn .=':';
                break;

            case 2:
                $dsn .= "2:";
                break;
        }
        $dsn .= ($this->toMemory) ? ':memory:' : $this->filename;
        return $dsn;
    }

    public function isValidDataBaseFile( $filename ) {
        if(!$this->toMemory) {
            if( !is_file($filename) ) {
                throw new \Exception('Database : ' .  getcwd() . '/' . $filename . ' not found.');
                if(!is_writable($filename)) {
                    throw new \Exception('Database : ' .  getcwd() . '/' . $filename . ' is not writable.');
                }
            }
            if( !is_writable( getcwd(). '/'. dirname($filename) ) ) {
                throw new \Exception('Base folder : ' . getcwd() . '/' . dirname($filename) . ' is not writable.');
            }
        }
        return true;
    }

    public function _getTableInfos( $table , $filter = null) {
            $table = explode('\\',$table);
            $table = $table[count($table)-1];
            $statement = $this->resource->query('PRAGMA table_info('. $table .');');
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            return $statement->fetchAll();
    }


}