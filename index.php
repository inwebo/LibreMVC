<?php

include("autoload.php");


// reflection
/*
class foo {

    public $id;
    private $name;

    public function __construct() {

    }

    public function foo($test, $a, $b) {
        var_dump( $test.$a.$b);
    }

    static public function statik() {

    }

    private function bar() {

    }

}


try {
    \LibreMCV\Mvc::invoker('foo', 'foo',array("hello ", " le ", " world"));
    new \LibreMCV\Controllers\HomeController();
}
catch (Exception $e) {

}
*/
$ViewBag = \LibreMVC\Views\Template\ViewBag::get();

$ViewBag->title = "Titre d'un paragraff";
$ViewBag->test = "#Je suis une variable#";
$ViewBag->array = array('value1', 'value2', 'key'=>'value3');
$ViewBag->object = new stdClass();
$ViewBag->object->test = "test";
$ViewBag->object->test2 = "test2";
define('CONSTANTE', 'Je suis une constante');
//var_dump(is_file('template.php'));
$ViewBag->isTrue =1;
$ViewBag->isFalse =0;
$ViewBag->intMin = 4;
$ViewBag->intMax = 6;
$parser = new \LibreMVC\Views\Template\Parser('template.php');
$parser->render();
