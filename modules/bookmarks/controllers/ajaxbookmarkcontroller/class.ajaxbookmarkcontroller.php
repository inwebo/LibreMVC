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
use LibreMVC\Database\Driver\MySql;
use LibreMVC\Mvc\Controller\Traits\System as Sys;
use LibreMVC\Mvc\Controller\Traits\DataBase;

class AjaxBookmarkController extends RestController{

    use Sys;
    use DataBase;

    const TEMPLATE_FORM = "form.php";

    /**
     * @var Bookmark
     */
    protected $_bookmark;

    //region Getters
    /**
     * @return Bookmark
     */
    public function getBookmark()
    {
        return $this->_bookmark;
    }

    //endregion Getters

    public function init() {
        parent::init();
        $this->setSystem(System::this());
        $config = $this->getModuleConfig('bookmarks')->DataBase;
        $this->setDbDriver(new MySql(
            $config['server'],
            $config['database'],
            $config['user'],
            $config['password']
        ));
        Bookmark::binder($this->getDbDriver(),'id',$config['table']);
        $formPath = $this->getSystem()->getModuleBaseDirs('bookmarks','static_views') . self::TEMPLATE_FORM;
        $this->getView()->attachPartial('body',$formPath);

        if( $this->isNewBookmark() ) {
            // New
            $this->_bookmark = self::bookmarkFactory();
        }
        else {
            // Loaded
            $this->_bookmark = Bookmark::load($this->getSystem()->getRoute()->params['bookmarkId']);

        }

        $this->bookmarkToView();
    }

    //region Helpers
    private function bookmarkToView() {
        $this->toView('bookmark', $this->_bookmark);
    }
    protected function isNewBookmark() {
        return !isset($this->getSystem()->getRoute()->params['bookmarkId']);
    }
    //endregion Helpers

    /**
     * Affiche le formulaire pré-remplis
     */
    public function get() {
        $this->render();
    }

    /**
     * @throws \Exception
     */
    public function post() {
        try {
            $this->getBookmark()->save();
        }
        catch(\Exception $e) {
            Header::badRequest();
            throw $e;
        }
    }

    /**
     *
     */
    public function delete() {
        $this->getBookmark()->delete();
    }
    public function update() {
        $inputs = (object)$this->getRequest()->getInputs();
        $this->_bookmark->title=urldecode($inputs->title);
        $this->_bookmark->description =urldecode($inputs->description);
        $this->_bookmark->tags = urldecode($inputs->tags);
        $this->_bookmark->isPublic = (int)$inputs->isPublic;
        $this->_bookmark->save();
    }

    /**
     * Tout ce qui arrive est url encodé !
     * @return Bookmark
     */
    public function bookmarkFactory() {
        $inputs = (object)$this->getRequest()->getInputs();
        $url = urldecode($inputs->url);
        $title = urldecode($inputs->title);
        $tags = urldecode($inputs->tags);
        $description = urldecode($inputs->description);
        $isPublic= (isset($inputs->isPublic)) ? $inputs->isPublic : "1";
        return Bookmark::build($url,$title,$tags,$description,$tags, $isPublic) ;

    }

    public function __destruct() {}

}