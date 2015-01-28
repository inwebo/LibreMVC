<?php
namespace LibreMVC\Mvc\Controller;

use LibreMVC\Html\Document\Head;
use LibreMVC\Mvc\Controller;
use LibreMVC\Database;

class PageController extends BaseController {

    protected $_head;
    private $_headClone;

    protected function init(){
        /**
         * Chargement d'un objet Head.
         */
        Head::binder( Database\Provider::get( 'system' ), 'Heads', 'id' );
        $this->_head = Head::load( md5( $_SERVER['REQUEST_URI'] ),'md5',true);
        $this->_view->getDataProvider()->head = $this->_head;
        // @todo : juste nom, title changement.
        $this->_headClone = clone $this->_head;
        $this->toView('_head', $this->_head );
        $this->toView('_user', $_SESSION['User'] );

    }

    public function __destruct() {
        // New Head
        if( is_null($this->_headClone->uri) ) {
            //var_dump($this->_headClone);
            $this->_view->getDataProvider()->head->save();
        }

        // Updated Head
        elseif( $this->_view->getDataProvider()->head->isEqual( $this->_headClone ) ) {
            $this->_view->getDataProvider()->head->save();
        }

    }


}