<?php

namespace LibreMVC\Modules\Error\Controllers;

use LibreMVC\Mvc\Controller\StaticController;

class ErrorController extends StaticController{

    const GET = '\\LibreMVC\\Modules\\Error\\Controllers\\ErrorController';

    public function init(){
        parent::init();
    }

    public function __call( $name, $arguments ) {
        $this->_staticView  = $this->_staticView . $name.'.php';
        $viewObject = $this->_view->getDataProvider();
        try{
            $viewObject->attachPartial('body', $this->_view->partial( $this->_staticView, $viewObject ));
            $this->_view->render();
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }
}