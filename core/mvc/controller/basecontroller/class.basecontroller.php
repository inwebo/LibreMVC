<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/02/14
 * Time: 23:04
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controller;
use LibreMVC\Http\Request;
use LibreMVC\Mvc\Controller\IController;
use LibreMVC\View;

/**
 * Class BaseController
 *
 * Représentation d'un actionController doit posséder une vue ansi qu'une requête.
 *
 * @package LibreMVC\Mvc\Controller
 */
abstract class BaseController implements IController {

    protected $_request;
    protected $_view;

    public function __construct( Request $request, View $view ) {

        $this->_request = $request;
        $this->_view    = $view;

        $this->init();
    }

    /**
     * Est toujours appellé
     */
    protected function init() {}

    public function hasAction( $action ) {
        return (bool)method_exists( $this, $action . ACTION_SUFFIX );
    }

    /**
     * Doit être surchargée.
     */
    public function indexAction() {}

}