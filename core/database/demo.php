<?php
include('autoload.php');
use LibreMVC\Database\Driver\MySql;
use LibreMVC\Database\Provider;
use LibreMVC\Database\Entity;

class users extends Entity {
    public $id;
    public $name;
}

class roles extends Entity {}

$db1 = array(
    'Server'   => 'localhost',
    'Database' => 'test',
    'User'     => 'root',
    'Password' => 'root'
);
try {
    $sqlite = new LibreMVC\Database\Driver\SqLite('db');
}
catch (\Exception $e) {
    echo $e->getMessage();
}

Provider::add('db_sqlite', $sqlite);






/*
$driverMySQL_1 = new MySql($db1['Server'],$db1['Database'],$db1['User'],$db1['Password']);
Provider::add('db1', $driverMySQL_1);
Provider::get('db1')->toObject('users');
$users = Provider::get('db1')->query('SELECT * FROM users')->all();
var_dump($users);
*/
/**
 * Ici l'application devrait renvoyer un message d'erreur précisant que le bind objet PHP > Table SQL n'est pas fait

    $user1 = Users::load(1);
    var_dump($user1);
 */

/**
 * Ici l'application plante comme une vieille merdasse, ne retourne qu'une seule lettre.
    users::binder(Provider::get('db1'));
*/
//users::binder(Provider::get('db1'),'users','id');

//$user1 = users::load(2);

//$user1->name = "++Jool++";
//$user1->save();
//var_dump($user1);
/*
$nu = new users();
$nu->name = "toto";*/
//$nu->save();

//$driverSqlite = new LibreMVC\Database\Driver\SqLite("../../db");