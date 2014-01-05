<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 16:41
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;
use LibreMVC\Database\Driver\IDriver;
use LibreMVC\Database\Results;
use LibreMVC\Http\Header;

/**
 * Class Statement
 * @package LibreMVC\Database
 */
class Statement {

    public $driver;
    protected $toObject;

    public function __construct( IDriver $driver ) {
        $this->driver = $driver;
        return $this;
    }

    public function toObject( $class_name ) {
        if(class_exists($class_name) ) {
            $this->toObject = $class_name;
        }
        else {
            trigger_error( "Unknown class : " . $class_name );
        }
        return $this;
    }

    public function toAssoc() {
        $this->toObject = null;
        $this->driver->getResource()->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
        return $this;
    }

    public function toStdClass() {
        $this->toObject = null;
        $this->driver->getResource()->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_OBJ);
        return $this;
    }

    public function query($query, $params = array() ) {
        $pdoStatement = $this->driver->getResource()->prepare($query);
        try {
            (!is_null($params) && is_array($params)) ?
                $pdoStatement->execute($params) :
                $pdoStatement->execute();
        }
        // N'est pas un statement valid
        catch(\Exception $e) {
            //Header::badRequest();
            return $e;
        }
        if( isset($this->toObject) ) {
            $pdoStatement->setFetchMode(\PDO::FETCH_CLASS , $this->toObject);
        }
        return new Results($pdoStatement);
    }

    /**
     * @param string $file
     * @return bool
     */
    public function queryFromSqlFile( $file ) {
        var_dump($file);
        var_dump(is_file($file));
        $handle = fopen($file, "r");
        $contents = fread($handle, filesize($file));
        $this->query($contents);
        return true;
    }

    /**
     * Are we able to query a database with instance driver
     * @return bool
     */
    protected function isValidStatement() {
        return ( !is_object($this->driver) && $this->driver instanceof IDriver );
    }
}