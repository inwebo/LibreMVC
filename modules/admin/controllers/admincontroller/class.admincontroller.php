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
        // Call hooks->__layout
        //$this->changeLayout(".");
        $this->toView("routed", System::this()->routed);
        $this->toView("routes", RoutesCollection::get("default"));
    }

}