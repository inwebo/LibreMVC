<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 24/01/15
 * Time: 20:08
 */

namespace LibreMVC\Modules\Admin\Controllers;

use LibreMVC\Mvc\Controller\PageController;
use LibreMVC\Routing\RoutesCollection;

class RoutesController extends PageController{

    protected $_routesCollections;

    protected function init(){
        $this->toView("routes", RoutesCollection::get("default"));
    }

}