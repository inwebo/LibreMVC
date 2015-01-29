<?php
registerModule();
use LibreMVC\Modules\Admin as Module;
addRoute("admin/[:controller]/[:action]",'\\LibreMVC\\Modules\\Admin\\Controllers\\RoutesController','index');
/*
use LibreMVC\System;
use LibreMVC\System\Hooks\CallBack;

$hooks  = System::this()->hooks;
$routed = System::this()->routed;
*/
//var_dump($routed);

/* Systematique
$hooks->__layout->attachCallback(new CallBack(function(){
    $module = getModule('admin');
    $path = $module->getPath()->getBaseDir('index');
    return $path;
}));
*/
/*
$hooks->__layout_body_partial->attachCallback(new CallBack(function(){
    $module = getModule('admin');
    $path = $module->getPath()->getBaseDir('views');
    return $path;
}));
*/
