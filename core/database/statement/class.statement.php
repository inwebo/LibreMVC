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
        if(!$pdoStatement) {
            trigger_error('Bad resource error');
        }
        (!is_null($params) && is_array($params)) ?
            $pdoStatement->execute($params) :
            $pdoStatement->execute();

        if( isset($this->toObject) ) {
            $pdoStatement->setFetchMode(\PDO::FETCH_CLASS , $this->toObject);
        }
        return new Results($pdoStatement);
    }
}