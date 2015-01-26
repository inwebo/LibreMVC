<?php
namespace LibreMVC\Database\Entity {

    use LibreMVC\Database\Driver\IDriver;

    class EntityConfiguration {

        /**
         * @var IDriver
         */
        public $driver;
        public $primaryKey;
        public $table;
        public $tableDescription;

        public function __construct( IDriver $iDriver, $primaryKey, $table, $tableDesc) {
            $this->driver           = $iDriver;
            $this->primaryKey       = $primaryKey;
            $this->table            = $table;
            $this->tableDescription = $tableDesc;
        }
    }

}