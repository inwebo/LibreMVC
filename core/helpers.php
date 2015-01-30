<?php

use LibreMVC\Autoloader\Handler;
use LibreMVC\Autoloader\Decorators;

function addRoute($pattern, $controller, $action, $collection="default"){
    $uri = \LibreMVC\System::this()->instance->getBaseUri();
    $route = new \LibreMVC\Routing\Route(
        $uri .= $pattern,
        $controller,
        $action
    );
    \LibreMVC\Routing\RoutesCollection::get($collection)->addRoute($route);
}
function addStaticRoute($pattern){
    $uri = \LibreMVC\System::this()->instance->getBaseUri();
    $route = new \LibreMVC\Routing\Route(
        $uri .= $pattern,
        '\\LibreMVC\\Mvc\\Controller\\StaticController',
        ''
    );
    \LibreMVC\Routing\RoutesCollection::get('default')->addRoute($route);
}

function registerModule(){
    Handler::addDecorator(new Decorators(getcwd()));
}
function registerInstance(){
    $path = \LibreMVC\System::this()->instance->getRealPath();
    Handler::addDecorator(new Decorators($path));
}

function getBaseUrl(){
    return \LibreMVC\System::this()->basePaths->getBaseUrl();
}

function getModules(){
    return \LibreMVC\System::this()->modules;
}
function getModule($name){
    return \LibreMVC\System::this()->modules[$name];
}
