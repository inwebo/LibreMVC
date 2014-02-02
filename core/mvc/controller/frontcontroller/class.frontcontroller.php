<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 02/02/14
 * Time: 22:45
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controller;

/**
 * Class FrontController
 *
 * Doit router l'objet Http\Request parmi une collection de route. Doit router soit vers un controller par default ou
 * vers une page d'erreur si des exceptions surviennent. Doit ensuite transmettre cette route ainsi que la vue souhaitée
 * vers l'objet de Dispatcher.
 *
 * @package LibreMVC\Mvc\Controller
 */
class FrontController {

    protected $_router;

}