<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 02/08/14
 * Time: 15:41
 */

namespace LibreMVC\Mvc\Controller;

use LibreMVC\Mvc\Controller;
use LibreMVC\View\Template;

class StaticController extends Controller{

    /**
     * Doit être creusé.
     *
     * @param $name
     * @param $arguments
     */
    public function __call( $name, $arguments ) {
        $this->_view->render();
    }

} 