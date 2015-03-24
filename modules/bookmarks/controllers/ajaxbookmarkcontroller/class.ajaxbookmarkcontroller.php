<?php
namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Http\Header;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Modules\Bookmarks\Models\Tags;
use LibreMVC\Mvc\Controller\AjaxController\PrivateAjaxController;
use LibreMVC\System;
use LibreMVC\View;
use LibreMVC\View\Template;
use LibreMVC\Mvc\Controller\AjaxController\PrivateAjaxController\RestController;
use LibreMVC\Files\Config;
use LibreMVC\Database\Drivers;
use LibreMVC\Database\Driver\MySql;

class AjaxBookmarkController extends RestController{

    const FORM = "form.php";

    protected $_new;

    protected $_form;

    public function init() {
        parent::init();
        $c = $this->_system->getModule('bookmarks')->getConfig("dir");
        $this->_config          = Config::load($c);
        $this->_pagination      = $this->_config->Bookmarks['pagination'];
        $this->_uriRestService  = $this->_config->Rest['service'];

        // Prépare les accès bdd.

            Drivers::add( "bookmarks",
                new MySql(
                    $this->_config->Bookmarks['server'],
                    $this->_config->Bookmarks['database'],
                    $this->_config->Bookmarks['user'],
                    $this->_config->Bookmarks['password']
                ));
        Bookmark::binder(Drivers::get('bookmarks'));
        $form = $this->_system->getModuleBaseDirs('bookmarks','static_views') . self::FORM;
        $contentEditable = $this->_system->getModule('bookmarks')->getStaticViews('dir') . "bookmark.php";
        $bookmark = $this->bookmarkFactory();
        $this->toView('bookmark',$bookmark);
        $this->toView('contentEditable',$contentEditable);
        $this->toView('user',$this->_trustedUser->login);
        $this->toView('publicKey',$this->_trustedUser->publicKey);
        $this->toView('verb',($bookmark->isLoaded()) ? 'UPDATE' : 'PUT');
        $this->_form = new View(
            new Template($form),
            $this->_vo
        );
        $this->_form->attachPartial('body', $contentEditable);
        //$this->_form->getPartial('form-content')->toView('bookmark', $this->bookmarkFactory());
        $this->_form->setAutoRender(false);
        $this->_ajaxResponse->data = $this->_form->render();
        $this->_new = $this->isNewBookmark();

    }

    public function initByVerb() {}

    public function update() {
        $bookmark = $this->bookmarkFactory();
        $bookmark->save();
    }
    public function put() {
        $bookmark = $this->bookmarkFactory();
        try {
            $bookmark->save();
            $this->_ajaxResponse->data = "Done";
        }
        catch(\Exception $e) {
            Header::badRequest();
            $this->_ajaxResponse->error = $e->getCode();
            $this->_ajaxResponse->data = $e->getMessage();
        }

    }

    public function get() {
        //var_dump($this->bookmarkFactory());
    }

    public function delete() {
        if(!$this->isNewBookmark()) {
            $bookmark = Bookmark::load($this->_inputs['id']);
            $bookmark->delete();
        }
    }

    protected function isNewBookmark() {
        return !(isset($this->_inputs['id']));
    }

    public function bookmarkFactory() {
        $in = $this->_inputs;
        $id = $this->_trustedUser->id;
        $url = (!is_null($in['url']))  ? $in['url'] : "";
        $title = (!is_null($in['title']))  ? $in['title'] : "";
        $tags = (!is_null($in['tags']))  ? $in['tags'] : "";
        $description = (!is_null($in['description']))  ? $in['description'] : "";
        $bookmark = Bookmark::build($id,$url,$title,$tags,$description);
        return $bookmark;
    }

}