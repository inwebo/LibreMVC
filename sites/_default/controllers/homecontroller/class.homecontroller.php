<?php
namespace LibreMVC\Controllers;

use LibreMVC\Form;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Http\Request;
use LibreMVC\Database;
use LibreMVC\Instance;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Views;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Errors;
class HomeController extends PageController {

    protected $_cachable = false;

    public function __construct() {
        parent::__construct();
        $this->_viewbag->baseHref = Environnement::this()->instance->baseUrl;
        $this->_viewbag->menus = $this->toMenuEntries();
    }

    public function indexAction() {
        $this->_viewbag->demoViewBag = "Depuis le viewbag !";
        $this->_meta->title ="Welcome home visitors from futur.";
        Views::renderAction();
    }

    public function debugAction() {
        ViewBag::get()->env = Environnement::this();
        Views::renderAction();
    }

}