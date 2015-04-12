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

class SqliteDriverFileException extends \Exception {}

class SqLite extends Driver {

    const COLS_NAME          = "name";
    const COLS_TYPE          = "type";
    const COLS_NULLABLE      = "notnull";
    const COLS_DEFAULT       = "dflt_value";
    const COLS_PRIMARY_KEY   = "pk";
    const COLS_PRIMARY_VALUE = "1";

    /**
     * @var string
     */
    public $filename;
    protected $dsn;
    public $toMemory;
    protected $memoryPersistence;
    protected $version;

    /**
     * @param string $filename Absolute database file path.
     * @param int $version
     * @param bool $readonly
     */
    public function __construct( $filename = "", $version = 3, $readonly = false ) {
        parent::__construct();
        try {
            $this->toMemory = empty($filename);
            $this->filename = ($this->isValidDataBaseFile($filename)) ? $filename : "";
            $this->version = $version;
            $this->dsn = $this->prepareDSN() ;
            $this->driver = new \PDO($this->dsn);
            $this->driver->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $this->driver;
        } catch (\Exception $error_string) {
            var_dump($error_string);
        }
    }

    /**
     * @param $filename
     * @return bool
     * @throws SqliteDriverFileException
     */
    public function isValidDataBaseFile( $filename ) {

        $filenameRealPath = dirname(realpath($_SERVER['SCRIPT_FILENAME'])).'/'.$filename;
        //var_dump($filenameRealPath);
        $filenameDirName  = dirname($filenameRealPath).'/';
        //var_dump($filenameDirName);
        /*
                if(!$this->toMemory) {
                    // Le dossier contenant le fichier sqlite n'est pas accessible en ecriture.
                    if( !is_writable( $filenameDirName ) ) {
                        throw new SqliteDriverFileException('Database file\'s root folder : ' . $filenameDirName . ' must be writable');
                    }

                    if( !is_file( $filenameRealPath ) && !is_writable( $filenameDirName ) ) {
                        throw new SqliteDriverFileException('Database file : ' . $filenameRealPath . ' doesn\'t exist, ' . $filenameDirName . ' must be writable.');
                    }

                }*/
        return true;
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

    public function getTableInfos( $table , $filter = null) {
            $table = explode('\\',$table);
            $table = $table[count($table)-1];
            $statement = $this->driver->query('PRAGMA table_info('. $table .');');
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            return $statement->fetchAll();
    }


}