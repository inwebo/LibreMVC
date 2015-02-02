<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 24/01/15
 * Time: 20:08
 */

namespace LibreMVC\Modules\Admin\Controllers;


use LibreMVC\Mvc\Controller\BaseController;

abstract class AdminController extends BaseController{

    protected function init(){
        $controller = $this->_system->this()->routed->controller;
        $this->changeLayout($this->_system->getModuleBaseDirs('admin','index'));
        $viewsPath = $this->_system->this()->getModuleBaseDirs('admin','views') .
        $controller::getControllerName() . '/' . $this->_system->this()->routed->action . '.php';
        $this->changePartial('body',$viewsPath);
    }

}