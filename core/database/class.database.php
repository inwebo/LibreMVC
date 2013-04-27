<?php

namespace LibreMVC;

use \PDO;
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
 * @subpackage Driver
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Container d'instance PDO unique de connexion valide d'une base de donnée.
 * Chaque instance de connexion doit être configurées au préalable avec une
 * class de setup.
 *
 * La classe implémente le design pattern singleton
 *
 * <code>
 * // Exemple avec une connexion SQlite
 * $user = new lSQlite( 'db/db.sqlite3' );
 * $path = new lSQlite( 'db/db2.sqlite3' );
 *
 * Driver::setup("user",  $user );<br>
 * Driver::setup("home", $path );<br>
 *
 * Driver::get("user")->query('SELECT * FROM user');
 * </code>
 *
 * @category   LibreMVC
 * @package    Database
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 * @abstract
 */
abstract class Database {
    /**
     * Options à transmettre à la methode PDO::execute()
     * @var array
     * @todo Refactoring -> options
     */
    protected $params;

    /**
     * Fetch_style
     * @var Array 
     * @see http://php.net/manual/fr/pdostatement.fetch.php
     */
    protected $fetchStyle;

    /**
     * Jeux de résultat de la dernière requête SQL.
     * @var Mixed
     */
    public $results;

    /**
     * Object PDOStatement courant
     * @var PDOStatement
     */
    protected $pdoStatement;

    /**
     * Connection database courantes
     * @var PDO
     */
    public $resource;

    /**
     * Requête courante
     * @var String
     */
    protected $query;

    /**
     * Execute une requête préparée.
     *
     * @param String $query
     * @param Array $params
     * @param PDOConstantes $options
     * @return \LibreMVC\Database\Database
     * @todo Refactoring
     */
    public function query($query, $params = NULL, $options = array(PDO::FETCH_ASSOC), $chaining = false) {
        $this->results = false;
        $this->pdoStatement = $this->resource->prepare($query);
        $this->fetchStyle = null;
        //var_dump( $this->fetchStyle );
        //Difference entre requete mal formée et retour vide
        if (!$this->pdoStatement) {
            trigger_error("Not valid SQL query : " . $query);
            return false;
        } else {
            (!is_null($params) && is_array($params)) ?
                            $this->pdoStatement->execute($params) :
                            $this->pdoStatement->execute();


            // N'est pas FETCH_CLASS
            if( isset($this->fetchStyle) ) {
                $options = $this->fetchStyle;
            }
            
            if (isset($options[0]) && !isset($options[1]) && !isset($options[2])) {
                $this->pdoStatement->setFetchMode($options[0]);
            }
            // Est FETCH_CLASS sans parametre constructeur
            else if (isset($options[0]) && isset($options[1])) {
                $this->pdoStatement->setFetchMode($options[0], $options[1]);
            }
            // Fetch class params
            else {
                $this->pdoStatement->setFetchMode($options[0], $options[1], $options[2]);
            }
            $this->results = $this->pdoStatement->fetchAll();
        }
        if (!$chaining) {
            return $this->results;
        } else {
            return $this;
        }
    }

    /**
     * 
     * @param String $class
     * @return \LibreMVC\Database
     */
    public function toObject( $class_name ) {
        if(class_exists($class_name) ) {
            $this->fetchStyle = array(PDO::FETCH_CLASS, $class_name);
        }
        return $this;
    }
    
    /**
     * Met à jour une instance existante de la classe demandée, liant les
     * colonnes du jeu de résultats aux noms des propriétés de la classe 
     * @return \LibreMVC\Database
     */
    public function toSetter() {
        $this->fetchStyle = array(PDO::FETCH_INTO);
        return $this;
    }
    
    /**
     * Retourne un tableau indexé par le nom de la colonne comme retourné dans 
     * le jeu de résultats 
     * @return \LibreMVC\Database
     */
    public function toAssoc() {
        $this->fetchStyle = array(PDO::FETCH_ASSOC);
        return $this;
    }
    
    /**
     * retourne un objet anonyme avec les noms de propriétés qui correspondent
     * aux noms des colonnes retournés dans le jeu de résultats 
     * @return \LibreMVC\Database
     */
    public function toStdClass() {
        $this->fetchStyle = array(PDO::FETCH_OBJ);
        return $this;
    }
    
    // <editor-fold defaultstate="collapsed" desc="SQL Syntax">

    public function select($fields) {
        $this->query = "SELECT " . $fields;
        return $this;
    }

    public function from($table) {
        $this->query .= ' FROM ' . Query::toKey($table);
        return $this;
    }

    public function where($condition, $params = null) {
        $this->query .= ' WHERE ' . $condition;
        (isset($params)) ? $this->params = $params : null;

        return $this;
    }

    public function table($table, $options = array(PDO::FETCH_ASSOC), $chaining = true) {
        if( isset($this->fetchStyle) ) {
            $options = $this->fetchStyle;
        }
        $this->query = "SELECT * FROM " . Query::toKey($table);
        if(!$chaining){
            return $this->query($this->query, $this->params, $options);
        }
        else {
            return $this;
        }
        
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="@TODO">
    public function fetchOne($options = array(PDO::FETCH_ASSOC)) {
        $this->query .= ' LIMIT 1';
        if( isset($this->fetchStyle) ) {
            $options = $this->fetchStyle;
        }
        $this->query($this->query, $this->params, $options);
        if (isset($this->results) && is_array($this->results) && count($this->results) === 1) {
            return $this->results[0];
        } else {
            return false;
        }
    }

    public function fetchAll($options = array(PDO::FETCH_ASSOC)) {
        if( isset($this->fetchStyle) ) {
            $options = $this->fetchStyle;
        }
        $this->query($this->query, $this->params, $options);
    }

    public function findById($id, $options = array(PDO::FETCH_ASSOC) ) {
        if( isset($this->fetchStyle) ) {
            $options = $this->fetchStyle;
        }
        
        return $this->where( 'id = ?', array($id) )->toObject('LibreMVC\Models\User')->fetchOne();
    }

    // </editor-fold>
}