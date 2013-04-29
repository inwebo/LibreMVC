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
abstract class Entity implements Modifiable {

    // <editor-fold defaultstate="collapsed" desc="Attributs">
    /**
     * Nom de la table au pluriel associée à l'instance courante.
     * @var String Le nom de la classe au pluriel
     */
    private $table;

    /**
     * Clef primaire de la table courante
     * @var String Clef primaire
     */
    protected $id = null;

    /**
     * Connexion valide vers une base de donnée.
     * @var PDO
     */
    protected $driver;

    /**
     * Tous les attributs publique de l'instance courante.
     * @var Array Equivalence nom de colonne / attribut de classe
     */
    protected $public;

    /**
     * Les tables peuvent être préfixés.
     * @var String Prefix table utilisateur.
     */
    protected $tablePrefix;

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Construct">
    public function __construct() {
        $this->driver = "default";
        $this->public = $this->getPublicAttributs();
        $this->table = $this->getTableName();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="getTable Name">
    protected function getTableName($plural = true) {
        if (__NAMESPACE__ != '') {
            $class = explode('\\', get_called_class());
            $class = strtolower($class[count($class) - 1]);
        } else {
            $class = strtolower(get_called_class());
        }

        ($plural) ? $class .= 's' : null;

        if (isset($this->tablePrefix)) {
            $class = Query::toKey($this->tablePrefix . $class);
        }

        return $class;
    }

    /**
     * Retourne un tableau associatif à deux entrées. Cela correspond à l'état
     * de l'objet courant.
     *
     * <code>
     *
     * class user extends Entity{
     *      public $id;
     *      public $name,
     *
     *     public function __construct($id , $name) {
     *         $this->id = 1;
     *         $this->name = "inwebo";
     *
     *         echo $this->getPublicAttributs(),
     *     }
     *
     * }
     *
     * // Retourne
     * Array(
     *      ['cols'] = Array(id, name);
     *      ['value'] = Array(1, "Inwebo");
     * )
     *
     * <code>
     *
     * @return Array
     */
    protected function getPublicAttributs() {
        $bind = array();
        foreach ($this->getReflectionObject() as $key => $value) {
            $bind["cols"][] = Query::toKey($key);
            $bind['values'][] = Query::toValue($value);
        }
        return $bind;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Reflection">
    /**
     * Retourne les attributs public de la class courante. Ils seront binder
     * sur les noms de colonnes de la table courante.
     *
     * @return Array Les attributs public.
     */
    protected function getReflectionObject() {
        $ref = new ReflectionObject($this);
        $pros = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
        $result = array();
        foreach ($pros as $pro) {
            false && $pro = new ReflectionProperty();
            $result[$pro->getName()] = $pro->getValue($this);
        }
        return $result;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Modifiable">
    /**
     * Supprime la ligne en BDD associée à l'id courant.
     * @return Bool True si la ligne est effacée sinon False
     */
    public function delete() {
        $delete = "DELETE FROM " . $this->table . " WHERE id= '" . $this->id . "'";
        if (!is_null($this->id) && (Driver::get($this->driver)->query($delete) !== false)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sauvegarde les attributs public de l'object courant dans une ligne de la
     * base de donnée.
     *
     * Si la ligne n'existe pas elle est crée. Sinon update de la ligne
     *
     */
    public function save() {
        if (is_null($this->id)) {
            if (Driver::get($this->driver)->query($this->insert()) !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            if (Driver::get($this->driver)->query($this->update()) !== FALSE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function insert() {
        $this->public = $this->getPublicAttributs();
        return "INSERT INTO " . $this->table . " ( " . implode(',', $this->public['cols']) . ') VALUES (' . implode(',', $this->public['values']) . ')';
    }

    public function update() {
        $this->public = $this->getPublicAttributs();
        return "UPDATE " . $this->table . ' SET ' . Query::toCouple($this->public) . ' WHERE ' . ' `id` ' . ' = ' . $this->id;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="getters and setters">
    public function __get($name) {
        return ( isset($this->$name) ) ? $this->$name : trigger_error("Unknow attribut $name.");
    }

    public function __set($name, $value) {
        return $this->$name = $value;
    }

    // </editor-fold>
}