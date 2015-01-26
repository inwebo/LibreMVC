<?php
namespace LibreMVC\Database\Entity {

    use LibreMVC\Database\Driver\IDriver;

    interface IModelable {
        static public function binder(IDriver $iDriver, $pk = null, $table = null, $tableDesc = null);
    }
}