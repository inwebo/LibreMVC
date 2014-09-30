<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 07/08/13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Errors;
use LibreMVC\Form;
use LibreMVC\Models\User;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\View;
use LibreMVC\Views;
use LibreMVC\Mvc\Controller\RestController;

class BookmarkController extends RestController{

    protected $_public = false;

    public function formAction() {
        $view = new View(new View\Template(TPL_BOOKMARKS_FORM),new View\ViewObject());
        $view->render();
    }

}