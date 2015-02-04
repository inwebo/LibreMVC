<?php

use LibreMVC\Autoloader\Handler;
use LibreMVC\Autoloader\Decorators;
use LibreMVC\Http\Url;
use LibreMVC\System;
use LibreMVC\Routing\Route;
use LibreMVC\Routing\RoutesCollection;

function htmlBase() {
    echo Url::get()->getServer(true,false) . System::this()->instance->getBaseUri();
}

/**
 * @return User
 */
function user() {
    return (isset($_SESSION['User'])) ? $_SESSION['User'] : null;
}

/**
 * @return bool
 */
function isDefaultUser(){
    if(isset($_SESSION['User'])) {
        return ( user()->isDefault() );
    }
    else {
        return true;
    }
}
function addRoute($pattern, $controller, $action, $collection="default"){
    $uri = System::this()->instance->getBaseUri();
    $route = new Route(
        $uri .= $pattern,
        $controller,
        $action
    );
    RoutesCollection::get($collection)->addRoute($route);
}
function addStaticRoute($pattern){
    $uri = System::this()->instance->getBaseUri();
    $route = new Route(
        $uri .= $pattern,
        '\\LibreMVC\\Mvc\\Controller\\StaticController',
        ''
    );
    RoutesCollection::get('default')->addRoute($route);
}
function registerModule(){
    Handler::addDecorator(new Decorators(getcwd()));
}
function registerInstance(){
    $path = System::this()->instance->getRealPath();
    Handler::addDecorator(new Decorators($path));
}
function getBaseUrl(){
    return System::this()->basePaths->getBaseUrl();
}
function getModules(){
    return System::this()->modules;
}

/**
 * @param $name
 * @return \LibreMVC\Models\Module
 */
function getModule($name){
    return System::this()->modules[$name];
}
