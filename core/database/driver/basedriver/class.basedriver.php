<?php

namespace LibreMVC\Database\Driver {

    /**
     * Class Driver
     * @package LibreMVC\Database
     */
    abstract class BaseDriver implements IDriver{

        /**
         * @var IDriver
         */
        protected $driver;

        /**
         * @var array
         */
        protected $tables = array();

        public function __construct(){}

        public function getDriver() {
            return $this->driver;
        }

        public function toAssoc() {
            $this->toObject = null;
            $this->driver->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
            return $this;
        }

        public function toStdClass() {
            $this->toObject = null;
            $this->driver->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_OBJ);
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

        public function filterColumnInfo($_table, $col_filter) {
            $class= get_called_class();
            $selectKeys = array($col_filter);
            $buffer = array();
            $j = 0;
            $table = $this->getTableInfos($_table);
            foreach($table as $cols) {
                $name = array_intersect_key((array)$cols, array_flip(array(static::COLS_NAME)))[static::COLS_NAME];
                $buffer[$name] =  array_intersect_key((array)$cols, array_flip($selectKeys))[$col_filter];
                $j++;
            }
            return $buffer;
        }

        public function getTableInfos($table) {
            if( isset($this->tables[$table]) ) {
                return $this->tables[$table];
            }
            else {
                $this->tables[$table] = $this->driver->getTableInfos($table);
            }
        }

        public function getColsName($_table) {
            $class = get_called_class();
            return $this->filterColumnInfo($_table, $class::COLS_NAME);
        }
        public function getColumnsNullable($_table) {
            $class = get_called_class();
            return $this->filterColumnInfo($_table, $class::COLS_NULLABLE);
        }
        public function getPrimaryKey( $_table ) {
            $class = get_called_class();
            $table = (array)$this->filterColumnInfo($_table, $class::COLS_PRIMARY_KEY);
            foreach($table as $k => $v) {
                if( $v == $class::COLS_PRIMARY_VALUE ) {
                    return $k;
                }
            }
        }
    }
}