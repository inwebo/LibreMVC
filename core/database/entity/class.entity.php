<?php

namespace LibreMVC\Database {

    use LibreMVC\Database\Driver\IDriver;
    use LibreMVC\Database\Entity\IModelable;
    use LibreMVC\Database\Entity\EntityConfiguration;

    abstract class Entity implements IModelable
    {

        const SQL_SELECT = "";

        /**
         * @var EntityConfiguration
         */
        static public $_entityConfiguration;

        public function __construct(){
            $this->init();
        }

        protected function init() {}

        static public function binder(IDriver $iDriver, $pk = null, $table = null, $tableDesc = null){
            $i = $iDriver;
            $t = (!is_null($table)) ? $table : self::classToTable() . 's';
            $p = (!is_null($pk)) ? $pk : $i->getPrimaryKey($t);
            $td =$i->getColsName($t);
            $conf = new EntityConfiguration($i, $p, $t, $td);
            static::$_entityConfiguration = $conf;
        }

        static public function load($id) {
            $conf = static::$_entityConfiguration;
            // Est-il configuré ?
            if (!is_null($conf)) {
                $conf->driver->toObject(self::getCalledClass());
                return $conf->driver->query('select * from ' . $conf->table . ' WHERE ' . $conf->primaryKey . "=? LIMIT 1",array($id))->first();
            } else {
                throw new Exception("Bind model first");
            }
        }

        static public function classToTable() {
            $class = self::getCalledClass();
            $table = array();
            // Is namespaced
            if ((strpos($class, '\\') !== false)) {
                $table = explode('\\', trim($class, '\\'));
                $table = end($table);
            } // nope
            else {
                $table = $class;
            }
            return $table;
        }

        static public function getCalledClass()
        {
            return get_called_class();
        }
    }
}