<?php

namespace LibreMVC\Database {

    use LibreMVC\Database\Driver\BaseDriver;

    class Driver extends BaseDriver{

        public function query($query, $params = array() ) {
            $pdoStatement = $this->driver->prepare($query);
            try {
                (!is_null($params) && is_array($params)) ?
                    $pdoStatement->execute($params) :
                    $pdoStatement->execute();
            }
            catch(\Exception $e) {
                var_dump($e);
            }
            if( isset($this->toObject) ) {
                $pdoStatement->setFetchMode(\PDO::FETCH_CLASS , $this->toObject);
            }
            return new Results($pdoStatement);
        }

    }

}