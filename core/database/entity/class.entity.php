<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;

//include('../query/class.query.php');
/**
 * Class Entity
 * @package LibreMVC\Database
 */
class Entity {

    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;

    /**
     * @todo: Devrait exister 1 constructeur pour l'instanciation ET pour le chargement de la database, cela évite les contructeur
     * avec des parametres par default inutile (cf Model\User )
     */

    /**
     * @param $statement
     * @param null $table
     * @param null $primaryKey
     */

    static public function binder($statement, $table = null, $primaryKey = null) {
       $class = get_called_class();
       if( strpos( $class , '\\') ) {
            $className = explode('\\', $class);
            $className = $class[count($class)-1];
        }
        $class::$_statement        = $statement;
        $class::$_table            = (!is_null($table)) ? $table : $className.'s';
        $class::$_tableDescription = $class::$_statement->driver->getColsName($class::$_table);
        $class::$_primaryKey       = (!is_null($primaryKey)) ? $primaryKey : $class::$_statement->driver->getPrimaryKey($class::$_table);
    }

    static function bound() {
        $class = get_called_class();
        return !is_null($class::$_statement) && !is_null($class::$_table) && !is_null($class::$_tableDescription) && !is_null($class::$_primaryKey);
    }
    static function boundTo() {
        $class = get_called_class();
        var_dump($class::$_statement);
        var_dump($class::$_table);
        var_dump($class::$_tableDescription);
        var_dump($class::$_primaryKey);

        return !is_null($class::$_statement) && !is_null($class::$_table) && !is_null($class::$_tableDescription) && !is_null($class::$_primaryKey);
    }

    static public function load( $primaryKeyValue, $primaryKey = null, $enableAutoload = false ) {
        $class = get_called_class();
        $pk = ( is_null( $primaryKey ) ) ? $class::$_primaryKey : $primaryKey;
        if( !is_object($class::$_statement) ) {
            throw new \Exception("From object" . $class . ' please bind your entity to a table.' );
        }
        $class::$_statement->toObject($class);
        $result = $class::$_statement->query('select * from ' . $class::$_table . ' WHERE ' . $pk . "=? LIMIT 1",array($primaryKeyValue))->first();
        if( $enableAutoload && is_null($result)) {
            $instance = new $class;
            $instance->$pk = $primaryKeyValue;
            return $instance;
        }
        else {
            return $result;
        }
    }

    static public function loadAll(  ) {
        $class = get_called_class();
        if( !is_object($class::$_statement) ) {
            throw new \Exception("From object" . $class . ' please bind your entity to a table.' );
        }
        $class::$_statement->toObject($class);
        return $class::$_statement->query('select * from ' . $class::$_table);
    }

    public function save( $forceInsert = false ) {
        $class = get_called_class();
        $tableCols = $this->GetInstanceValues();
        $pk = $class::$_primaryKey;
        $arrayKeys=  array_keys((array)$tableCols) ;
        $arrayValues=  array_values((array)$tableCols) ;

        if (is_null($this->$pk)||$forceInsert) {
            // Insert
            array_walk($arrayKeys,__NAMESPACE__ . '\\Query::toInsert');
            $tokens = array_fill(0, count((array)$tableCols), '?');
            $query = "INSERT INTO " . $class::$_table . " ( " . implode(',', $arrayKeys ) . ' ) VALUES ( ' . implode(',', $tokens ) . ' )';
            $statement = $class::$_statement->query($query,$arrayValues );
            if($statement instanceof \Exception) {
                var_dump($statement);
                return false;
            }
            //@todo : Test si statement est valid : ex: insert multiple avec la meme clef primaire unique fait renvoit une erreur pas un booléan

            return (!$statement) ? false : true;
        } else {
            try {

                $query = "UPDATE " . $class::$_table . ' SET ' . Query::toUpdate($tableCols) . ' WHERE ' . $pk . ' =?';
                $arrayValues = array_merge($arrayValues, array($this->$pk));
                $statement = $class::$_statement->query($query, $arrayValues );
                if($statement instanceof \Exception) {
                    return false;
                }
                return (!$statement) ? false : true;
            }
            catch(\Exception $e) {
                echo $e->getMessage();
            }

        }
    }

    public function insert() {
        $class = get_called_class();
        $tableCols = $this->GetInstanceValues();
        $pk = $class::$_primaryKey;
        $arrayKeys=  array_keys((array)$tableCols) ;
        $arrayValues=  array_values((array)$tableCols) ;
        array_walk($arrayKeys,__NAMESPACE__ . '\\Query::toInsert');
        $tokens = array_fill(0, count((array)$tableCols), '?');
        $query = "INSERT INTO " . $class::$_table . " ( " . implode(',', $arrayKeys ) . ' ) VALUES ( ' . implode(',', $tokens ) . ' )';
        $statement = $class::$_statement->query($query,$arrayValues );
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