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

/**
 * Class MySql
 * @package LibreMVC\Database\Driver
 */
class MySql extends Driver implements IDriver{

    const COLS_NAME          = "Field";
    const COLS_TYPE          = "Type";
    const COLS_NULLABLE      = "Null";
    const COLS_DEFAULT       = "Default";
    const COLS_PRIMARY_KEY   = "Key";
    const COLS_PRIMARY_VALUE = "PRI";

    /**
     * @var string
     */
    protected $host;
    /**
     * @var string
     */
    protected $database;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var array
     */
    protected $options;

    /**
     * @param string $host Database server
     * @param string $database Database name
     * @param string $username Database user
     * @param string $password Database password
     * @param array $options see : http://php.net/manual/fr/ref.pdo-mysql.php
     * @throws
     */
    public function __construct($host, $database, $username, $password, $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) {
        parent::__construct();
        try {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $database;
            $this->resource = new \PDO($dsn, $username, $password, $options);
            $this->resource->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            $this->host = $host;
            $this->database = $database;
            $this->username = $username;
            $this->passwd = $password;
            $this->options = $options;

            return $this->resource;

        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * @param $table Database table's name.
     * @return array All table's columns.
     */
    public function _getTableInfos( $table ) {
        $info = $this->resource->query( 'SHOW COLUMNS FROM ' . $table );
        $info->setFetchMode(\PDO::FETCH_OBJ);
        return $info->fetchAll();
    }

}