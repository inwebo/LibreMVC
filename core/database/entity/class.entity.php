<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;

include('../query/class.query.php');
class Entity {

    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;

    static public function binder($statement, $table = null, $primaryKey = null) {
        $class = get_called_class();
        if( strpos( $class , '\\') ) {
            $class = explode('\\', $class);
            $class = $class[count($class)-1];
        }
        $class::$_statement        = $statement;
        $class::$_table            = (!is_null($table)) ? $table : $class.'s';
        $class::$_tableDescription = $class::$_statement->driver->getColsName($class::$_table);
        $class::$_primaryKey       = (!is_null($primaryKey)) ? $primaryKey : $class::$_statement->driver->getPrimaryKey($class::$_table);
    }

    protected function bound() {
        $class = get_called_class();
        return !is_null($class::$_statement) && !is_null($class::$_table) && !is_null($class::$_tableDescription) && !is_null($class::$_primaryKey);
    }

    static public function load( $primaryKey ) {
        $class = get_called_class();
        $class::$_statement->toObject($class);
        return $class::$_statement->query('select * from ' . $class::$_table . ' WHERE ' . $class::$_primaryKey . " =? LIMIT 1",array($primaryKey))->first();
    }

    public function save() {
        Query::toKey(";");
        $class = get_called_class();
        $tableCols = $this->GetInstanceValues();
        $pk = $class::$_primaryKey;
        $arrayKeys=  array_keys((array)$tableCols) ;
        $arrayValues=  array_values((array)$tableCols) ;

        if (is_null($this->$pk)) {
            // Insert
            array_walk($arrayKeys,__NAMESPACE__ . '\\QueryString::toInsert');
            $tokens = array_fill(0, count((array)$tableCols), '?');
            $query = "INSERT INTO " . $class::$_table . " ( " . implode(',', $arrayKeys ) . ' ) VALUES ( ' . implode(',', $tokens ) . ' )';
            $statement = $class::$_statement->query($query,$arrayValues );
            return (!$statement) ? false : true;
        } else {
            try {
                $query = "UPDATE " . $class::$_table . ' SET ' . Query::toUpdate($tableCols) . ' WHERE ' . $pk . ' =?';
                $arrayValues = array_merge($arrayValues, array($this->$pk));
                $statement = $class::$_statement->query($query, $arrayValues );
                return (!$statement) ? false : true;
            }
            catch(\Exception $e) {
                echo $e->getMessage();
            }

        }
    }

    protected function GetInstanceValues(){
        $class = get_called_class();
        $return = new \StdClass();
        foreach( $class::$_tableDescription as $k => $v ) {
            $return->$v = $this->$v;
        }
        return $return;
    }

    public function delete() {
        $class = get_called_class();
        $pk= $class::$_primaryKey;
        $class::$_statement->query('delete from ' . $class::$_table . ' WHERE ' . $class::$_primaryKey . " = ? LIMIT 1",array( $this->$pk ));
    }

    static function deleteMultiple(  $ids = null  ) {
        $class = get_called_class();

        $tokens = array_fill(0, count($ids), '?');

        ( !is_null($ids) && is_array($ids) ) ?
            $class::$_statement->query('delete from ' . $class::$_table . ' WHERE ' . $class::$_primaryKey . " IN (". implode(',', $tokens) .")",$ids) :
            null ;
    }

}