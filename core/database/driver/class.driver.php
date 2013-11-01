<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 14:23
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;

class Driver {

    protected $resource;

    protected $tables;

    public function __construct(){
        $this->tables = array();
    }

    public function getResource() {
        return $this->resource;
    }

    public function filterColumnInfo($_table, $col_filter) {
        $class= get_called_class();
        $selectKeys = array($col_filter);
        $buffer = array();
        $j = 0;
        $table = $this->getTableInfos($_table);
        foreach($table as $cols) {
            $name = array_intersect_key((array)$cols, array_flip(array($class::COLS_NAME)))[$class::COLS_NAME];
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
            $this->tables[$table] = $this->_getTableInfos($table);
            return $this->tables[$table];
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