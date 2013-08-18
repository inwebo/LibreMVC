<?php

namespace LibreMVC\Database;

use LibreMVC\Database\Driver;
use ReflectionObject;
use ReflectionProperty;
use LibreMVC\Database\Query;

/**
 * LibreMVC
 *
 * LICENCE
 *
 * You are free:
 * to Share ,to copy, distribute and transmit the work to Remix —
 * to adapt the work to make commercial use of the work
 *
 * Under the following conditions:
 * Attribution, You must attribute the work in the manner specified by
 * the author or licensor (but not in any way that suggests that they
 * endorse you or your use of the work).
 *
 * Share Alike, If you alter, transform, or build upon
 * this work, you may distribute the resulting work only under the
 * same or similar license to this one.
 *
 *
 * @category  LibreMVC
 * @package   Database
 * @subpackage Entity
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * La classe entité est la représentation logique d'une table provenant d'une
 * base de donnée quelconque.
 *
 * Tous les models souhaitant implémenter le design patter ORM DOIT étendre cette
 * classe abstraite.
 *
 * @category   LibreMVC
 * @package    Database
 * @subpackage Entity
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 * @abstract
 */
abstract class Entity {

    static protected $_dbResource;
    static protected $_table;
    static protected $_idRow;
    protected  $public;

    public function __construct() {
        $this->bindAttributs();
    }

    static public function orm( $dbResource, $table, $idRow ) {
        self::$_dbResource = $dbResource;
        self::$_table      = $table;
        self::$_idRow      = $idRow;
    }

    protected function bindAttributs() {
        $ref = new ReflectionObject( $this );
        $props = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
        $public = array();
        foreach($props as $prop) {
            false && $pro = new \ReflectionProperty();
            $public[$prop->getName()] = $prop->getValue($this);
        }

        $this->public = $public;
    }

    public function save(){
        $this->bindAttributs();
        if( is_null($this->id) ) {
            $query = $this->insert();
        }
        else {
            $query = $this->update();
        }
        return self::$_dbResource->query($query);
    }
    public function delete(){
        $this->bindAttributs();
        $query = "DELETE FROM " . self::$_table . " WHERE ". self::$_idRow . "='" . $this->public[self::$_idRow] . "'";
        self::$_dbResource->query($query);
    }

    public function insert() {
        $this->bindAttributs();

        $keys = array_keys($this->public);
        array_walk($keys,array('LibreMVC\Database\Query','toKey'));
        $values = array_values($this->public);
        array_walk($values, 'LibreMVC\Database\Query::toValue');
        $query = "INSERT INTO " . self::$_table . " (" . implode(',', $keys) . ') VALUES (' . implode(',', $values) . ')';
        return $query;
    }

    public function update() {
        $this->bindAttributs();
        return "UPDATE " . self::$_table . ' SET ' . Query::toCouple($this->public) . ' WHERE ' . ' `'.self::$_idRow.'`' . ' = "' . $this->public[self::$_idRow].'"';

    }

    static public function getById($id){
        $query = "SELECT * FROM " . self::$_table . ' WHERE `' . self::$_idRow . '` = "' . $id . '"';
        $values = self::$_dbResource->query($query);

        if( !isset($values[0]) ) {
            return false;
        }
        else {
            $class = get_called_class();
            $new = new $class;
            foreach( $values[0] as $key => $value ) {
                $new->$key = $value;
            }
            return $new;
        }

    }

}
