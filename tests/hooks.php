<?php
include('../core/patterns/autoload.php');
include('../core/system/hooks/autoload.php');

class Foo {

    public $var;

    public $_hooks;

    public function __construct() {
        $this->var = "Test";
        $this->_hooks = new \LibreMVC\System\Hooks\Hook\BindedHook("__before");
    }

    public function __toString(){
        $this->_hooks->call($this->var);
        return $this->var;
    }

}
$foo = new Foo();
$foo->_hooks->attachCallback(new \LibreMVC\System\Hooks\CallBack(function($arg){
    return "+" . $arg;
}));
$foo->_hooks->attachCallback(new \LibreMVC\System\Hooks\CallBack(function($arg){
    return "+" . $arg;
}));
echo $foo;