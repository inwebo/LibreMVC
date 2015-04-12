<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 28/12/13
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database\Driver\SqLite;
use LibreMVC\Database\Driver\SqLite;

class SqLiteToMemory extends SqLite{

    public $persistent;

    /**
     * @param string $name
     * @param int $version
     * @param bool $persistent
     */
    public function __construct( $name = 'default', $version = 3, $persistent = true ) {
        try {
            $this->name = $name;
            $this->persistent = $persistent;
            $this->version = $version;
            $this->toMemory = true;
            $this->dsn = $this->prepareDSN() ;
            $this->driver = ($this->persistent) ? new \PDO( $this->dsn, null, null, array( \PDO::ATTR_PERSISTENT => true ) ) : new \PDO($this->dsn);
            return $this->driver;

        } catch (\Exception $error_string) {
            echo $error_string->getMessage();
        }

    }

}