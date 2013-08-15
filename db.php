<?php

include('core/database/class.database.php');
include('core/database/driver/class.driver.php');
include('core/database/driver/mysql/class.mysql.php');
include('core/database/driver/sqlite/class.sqlite.php');
include('core/database/modifiable/class.modifiable.php');
include('core/database/query/class.query.php');

use LibreMVC\Database;
use LibreMVC\Database\Driver;
use LibreMVC\Database\Driver\MySQL;
use LibreMVC\Database\Driver\SQlite;
use LibreMVC\Database\Modifiable;
use LibreMVC\Database\Query;

$_dbHead = Database::setup('system',new MySQL('localhost', 'test', 'root', 'root'));
$_dbHead = Database::get('system');
//var_dump($_dbHead);


$_dbBookmarks  = Database::setup('bookmarks', new MySQL('localhost', 'bookmarks', 'root', 'root'));
$_dbBookmarks = Database::get('bookmarks');
//var_dump($_dbBookmarks);

abstract class _Entity {

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
        $ref = new \ReflectionObject( $this );
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
        return "UPDATE " . self::$_table . ' SET ' . Query::toCouple($this->public) . ' WHERE ' . ' `'.self::$_idRow.'`' . ' = ' . $this->public[self::$_idRow];

    }

    static public function getById($id){
        $query = "SELECT * FROM " . self::$_table . ' WHERE ' . self::$_idRow . ' = ' . $id;
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

class Head extends _Entity{

    public $id;
    public $uri;
    public $md5;
    public $description;
    public $keywords;
    public $author;
    public $title;


    public function __construct() {
        parent::__construct();
    }

}

class Test extends _Entity {

    public $id;

    public function __construct() {
        parent::__construct();
    }
}

//_Entity::setup( Database::get('system'), 'heads', 'id' );
//$e = new _Entity();
//var_dump($e);

Head::orm($_dbHead, 'heads', 'id' );

$a = Head::getById(666);
var_dump($a);



$head = new Head();

$head->uri = 'http://www.inwebo.dev/LibreMVC/';
$head->md5 =md5($head->uri);
$head->description = 'one deux one deux';
$head->keywords = 'test, arf';

$head->title = "welcome";
//$head->save();
$head = Head::getById(1);
$head->delete();


//$head->save();

/*
$head->md5 = 789;
$head->save();
var_dump($head);*/

//$a = Head::getById(666);
//var_dump( $a );

/*
Test::orm($_dbBookmarks, 'my_tables_bookmarks', 'id' );
$a = Test::getById(6);
var_dump($a);
$test = new Test();
var_dump($test);
*/