<?php
registerModule();
use LibreMVC\Modules\Foo as Module;

use LibreMVC\System;
use LibreMVC\System\Hooks\CallBack;

$hooks = System::this()->hooks;

$hooks->__layout->attachCallback(new CallBack(function(){
    $module = getModule('admin');
    $path = $module->getPath()->getBaseDir('index');
    return $path;
}));
