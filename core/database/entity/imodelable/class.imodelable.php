<?php
namespace LibreMVC\Database\Entity {

    use LibreMVC\Database\Driver\IDriver;

    interface IModelable {
        static public function binder(IDriver $iDriver, $primaryKey = null, $tableName = null, $tableDesc = null);
    }
}