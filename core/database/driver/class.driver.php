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
                // Init constructor params.
                $reflection = new \ReflectionMethod($this->toObject,'__construct');
                $parameters = $reflection->getParameters();
                $pdoStatement->setFetchMode(\PDO::FETCH_CLASS, $this->toObject,$parameters);
            }
            return new Results($pdoStatement);
        }

    }

}