<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 02/08/14
 * Time: 15:41
 */

namespace LibreMVC\Mvc\Controller;

use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controller;
use LibreMVC\System;
use LibreMVC\View\Template;

class StaticController extends Controller{

    protected $_staticView;

    public function init(){
        $this->_staticView = System::this()->instancePaths->getBaseDir('static_views');
    }

    public function __call( $name, $arguments ) {
        $partial = $this->_staticView . $name.'.php';

        if( is_file($partial) ) {
            $viewObject = $this->_view->getDataProvider();
            $viewObject->attachPartial('body', $this->_view->partial( $partial, $viewObject ));
            $this->_view->render();
        }
        else {
            Header::error(404);
            // Manque le fichier template, affichage du nom attendus.
            //echo 'Static file to : ' . $partial;

        }
    }

} 