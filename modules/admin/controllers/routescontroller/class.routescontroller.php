<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 24/01/15
 * Time: 20:08
 */

namespace LibreMVC\Modules\Admin\Controllers;

use LibreMVC\Mvc\Controller\BaseController;

use LibreMVC\Routing\RoutesCollection;
use LibreMVC\System;

class RoutesController extends BaseController{

    protected $_routesCollections;

    protected function init(){
        $controller = $this->_system->this()->routed->controller;
        $this->changeLayout($this->_system->getModuleBaseDirs('admin','index'));
        $viewsPath = $this->_system->this()->getModuleBaseDirs('admin','views') .
            $controller::getControllerName() . '/' . $this->_system->this()->routed->action . '.php';
        var_dump($viewsPath);
        $this->changePartial('body',$viewsPath);
        $this->toView("routed", System::this()->routed);
        $this->toView("routes", RoutesCollection::get("default"));
    }

}