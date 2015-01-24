<?php
ini_set('display_errors', 'on');
include('../core/patterns/isingleton/class.isingleton.php');
include('../core/system/hooks/autoload.php');

use LibreMVC\System\Hooks;

class Foo {

    public function __construct(){
        Hooks::this()->createHook('construct');
        print 'Hello';
        Hooks::this()->attachHookCallback('construct', function($s, $t){
            $t[0] = " ";
            print  $s . $t[0];
        });
    }

    public function toString(){
        $arf = ",";
        $test = array("x");
        Hooks::this()->callHooks('construct',$arf,$test);
        print 'world';
    }

}

$v = new Foo();
$v->toString();