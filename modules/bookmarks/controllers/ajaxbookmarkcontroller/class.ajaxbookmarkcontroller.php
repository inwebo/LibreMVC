<?php
namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Modules\Bookmarks\Models\Tags;
use LibreMVC\Mvc\Controller\AjaxController\PrivateAjaxController;
use LibreMVC\System;
use LibreMVC\View;
use LibreMVC\View\Template;

class AjaxBookmarkController extends PrivateAjaxController{

    const FORM = "form.php";

    public function indexAction(){
        $this->_ajaxResponse->data = "<div><h1>Démo</h1><p>Yo</p>";
    }

    public function formAction(){
        // Chargement du formulaire d'ajout
        $template = $this->_system->getModuleBaseDirs('bookmarks','static_views') . self::FORM;
        $view = new View(
            new Template($template),
            $this->_vo
        );
        $bookmark = new \StdClass();
        $bookmark->id = $this->_inputs['id'];
        $view->getViewObject()->bookmark =$bookmark;
        $view->setAutoRender(false);
        $this->_ajaxResponse->data = $view->render();
    }

    public function bookmarkFactory() {

    }

}