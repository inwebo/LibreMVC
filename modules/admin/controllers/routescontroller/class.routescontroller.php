<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 05/08/14
 * Time: 13:12
 */

namespace LibreMVC\Modules\Admin;


use LibreMVC\Mvc\Controller\PageController;

class RoutesController extends PageController{

    public function readAction(){
        $this->_view->render();
    }

} 