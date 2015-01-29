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
        $this->toView("routed", System::this()->routed);
        $this->toView("routes", RoutesCollection::get("default"));
    }

}