<?php
namespace LibreMVC\Mvc\Controller;

use LibreMVC\Html\Document\Head;
use LibreMVC\Mvc\Controller;
use LibreMVC\Database;

class PageController extends Controller {

    protected $_head;
    private $_headClone;

    public function init(){
        /**
         * Chargement d'un objet Head.
         */
        Head::binder( Database\Provider::get( 'system' ), 'Heads', 'id' );
        $this->_head = Head::load( md5( $_SERVER['REQUEST_URI'] ),'md5',true);
        $this->_view->vo->head = $this->_head;
        $this->_headClone = clone $this->_head;
        $this->toView('_head', $this->_head );
        $this->toView('_user', $_SESSION['User'] );

    }

    public function __destruct() {
        /*
        if( $this->_view->vo->head->isEqual($this->_headClone) ) {
            $this->_view->vo->head->save();
        }
        */
    }


}