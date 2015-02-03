<?php

namespace LibreMVC\Database {

    use LibreMVC\Database\Driver\IDriver;
    use LibreMVC\Database\Entity\IModelable;
    use LibreMVC\Database\Entity\EntityConfiguration;

    abstract class Entity implements IModelable {

        const SQL_LOAD ='Select * from `%s` WHERE %s=? LIMIT 1';
        const SQL_DELETE ='Delete from `%s` WHERE %s=? LIMIT 1';
        const SQL_DELETE_MULTIPLE ='Delete * from `%s` WHERE %s=? IN %s LIMIT 1';
        const SQL_INSERT ='INSERT INTO %s %s VALUES %s';
        const SQL_UPDATE ='UPDATE %s SET %s WHERE %s=?';

        /**
         * @var string
         */
        protected $_loaded;

        /**
         * @var EntityConfiguration
         */
        static public $_entityConfiguration;

        public function __construct(){
            $this->_loaded = true;
            $this->init();
        }

        protected function init() {
            $this->_loaded = false;
        }

        /**
         * @param bool $statement
         */
        protected function setLoaded($statement) {
            $this->_loaded = $statement;
        }

        static public function binder(IDriver $iDriver, $primaryKey = null, $tableName = null, $tableDesc = null){
            $_table = (!is_null($tableName)) ? $tableName : self::getShortName() . 's';
            $pk     = (!is_null($primaryKey)) ? $primaryKey : $iDriver->getPrimaryKey($_table);
            $cols   = $iDriver->getColsName($_table);
            $conf   = new EntityConfiguration($iDriver, $pk, $_table, $cols);
            static::$_entityConfiguration = $conf;
        }

        static public function getBoundDriver() {
            if( !is_null(static::$_entityConfiguration) ) {
                return static::$_entityConfiguration->driver;
            }
        }

        public function save(){
            $conf = static::$_entityConfiguration;
            $toBind = $this->getValues();
            $toBindKeys = array_keys($toBind);
            $toBindValues = array_values($toBind);
            $sqlKeys = $conf->aggregateCols($toBindKeys);
            $tokens = $conf->aggregateCols($conf->getTokens(count($toBindKeys)));
            if($this->_loaded) {
                // Update
                $sqlUpdateQuery = sprintf(self::SQL_UPDATE, $conf->table,$conf->toUpdate($toBindKeys),$conf->primaryKey);
                $toInject = array_merge($toBindValues, array($this->id));
                try {
                    $conf->driver->query($sqlUpdateQuery,$toInject);
                }
                catch(\Exception $e) {
                    var_dump($e);
                }

                //var_dump($sqlKeys,$sqlValues,$sqlUpdateQuery);
                //var_dump($conf->toColsName($toBindKeys));
                //var_dump($toInject);
            }
            else {
                // Insert
                $sqlInsertQuery = sprintf(self::SQL_INSERT, $conf->table, $sqlKeys, $tokens);
                $conf->driver->query($sqlInsertQuery, $toBindValues);
            }
        }

        public function delete() {
            $sqlDelete = sprintf(self::SQL_DELETE, $this->getConf()->table, $this->getConf()->primaryKey);
            $this->getConf()->driver->query($sqlDelete,array($this->id));
        }

        static public function deleteByIds($array){
            $conf = static::$_entityConfiguration;
            $sqlDelete =sprintf(self::SQL_DELETE_MULTIPLE, $conf->table,$conf->primaryKey,$conf->aggregateCols($array));
        }

        static public function load($id, $by = null) {
            $conf = static::$_entityConfiguration;
            // Est-il configuré ?
            if (!is_null($conf)) {
                $conf->driver->toObject(get_called_class());
                $by = (is_null($by)) ? $conf->primaryKey : $by;
                $sqlSelect =  sprintf(self::SQL_LOAD,$conf->table,$by);
                $obj = $conf->driver->query($sqlSelect,array($id))->first();
                if( !is_null($obj) ) {
                    $obj->setLoaded(true);
                    return $obj;
                }
            } else {
                throw new Exception("Bind model first");
            }
        }

        static public function getConf() {
            return static::$_entityConfiguration;
        }

        static public function getShortName() {
            $ref = new \ReflectionClass( get_called_class() );
            return $ref->getShortName();
        }

        protected function getValues() {
            $members = $this->getConf()->intersectObj($this);
            $array = array();
            foreach($members as $v) {
                $array[$v] = $this->$v;
            }
            return $array;
        }

    }
}