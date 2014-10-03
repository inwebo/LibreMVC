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
use LibreMVC\Http\Header;
use LibreMVC\Models\User;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\View;
use LibreMVC\Views;
use LibreMVC\Mvc\Controller\RestController;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Database;
use LibreMVC\Http\Context;

class BookmarkController extends RestController{

    protected $_public = true;

    protected $_config;
    protected $_tables;
    protected $_db;

    protected $_servicesUrl;

    /**
     * @var New bookmark appear in urlbar as $_GET values.
     */
    protected $_isNew;

    public function init() {
        parent::init();
        $this->_config      = Environnement::this()->config->instance;
        $this->_tables      = $this->_config->Db->tablePrefix . $this->_config->Db->table;
        $this->_servicesUrl = Context::getBaseUrl() . $this->_config->Rest->service;
        $this->_isNew       = $this->isNewBookmark();

        // User peut etre setter en GET

        // Prépare les accès bdd.
        try{
            Database\Provider::add( "bookmarks",
                new Database\Driver\MySql(
                    $this->_config->Db->server,
                    $this->_config->Db->database,
                    $this->_config->Db->user,
                    $this->_config->Db->password )
            );

            $this->_db = Database\Provider::get("bookmarks");
            $this->_db->toStdClass();

            Bookmark::binder( $this->_db, $this->_tables, 'hash' );
        }
        catch(\Exception $e) {
            var_dump($e);
        }

    }

    public function isNewBookmark() {
        return $this->getVerb() == "get" && !empty($_GET);
    }

    public function formAction( $hash ) {
        $view = new View( new View\Template(TPL_BOOKMARKS_FORM), $this->voFactory( $hash ) );
        $this->msg = $view->render();
    }

    protected function voFactory( $hash ) {
        $vo = new View\ViewObject();
        $vo->login = ( !is_null($this->_request->httpHeader['User']) )? $this->_request->httpHeader['User'] : $_GET['user'];
        $vo->publicKey = ( !is_null($this->_request->httpHeader['Token']) )? $this->_request->httpHeader['Token'] : $_GET['publicKey'];
        $vo->verb = $this->getVerb();
        $vo->restUrl = $this->_servicesUrl;
        $vo->bookmark = $this->bookmarkFactory( $hash, $vo );
        return $vo;
    }

    protected function bookmarkFactory( $hash, $vo ) {

        if( $this->_isNew && !empty($_GET)) {

            if( !isset($_GET['url']) ) {
                Header::badRequest();
            }

            $title = ($_GET['title']) ? $_GET['title'] : '';
            $keywords = ($_GET['title']) ? $_GET['keywords'] : '';
            $description = ($_GET['title']) ? $_GET['description'] : '';
            $favicon = ($_GET['title']) ? $_GET['favicon'] : '';
            $bookmark = new Bookmark($_GET['url'],$title, $keywords, $description );
            $bookmark->description = $description;
            $bookmark->favicon = $favicon;
            $bookmark->public = 1;
            $bookmark->category = 1;
            $vo->verb = "PUT";
        }
        else {
            $bookmark = Bookmark::load($hash,'hash');
            $vo->verb = "POST";
        }

        return $bookmark;
    }

    private function defaultBinder() {
        Bookmark::binder($this->_db, $this->_tables, 'id');
    }

    /**
     * Add
     */
    public function put() {
        $this->defaultBinder();
        $bookmark = new Bookmark($this->_INPUTS['url'], $this->_INPUTS['title'], $this->_INPUTS['keywords'], $this->_INPUTS['description']);
        $bookmark->category = 1;
        $bookmark->public = 1;

        $c = Bookmark::loadAll()->count();
        $this->_reply->msg = $c;
        $bookmark->save();
    }

    /**
     * Update
     */
    public function post() {
        $this->defaultBinder();
        /**
        $bookmark = new Bookmark($this->_INPUTS['url'], $this->_INPUTS['title'], $this->_INPUTS['keywords'], $this->_INPUTS['description']);
        $bookmark->category = 1;
        $bookmark->public = 1;
         */
        //var_dump($this->_INPUTS['hash']);
        $bookmark = Bookmark::load($this->_INPUTS['hash'],'hash');
        $bookmark->title = $this->_INPUTS['title'];
        $bookmark->description = $this->_INPUTS['description'];
        $bookmark->tags = $this->_INPUTS['keywords'];
        $bookmark->save();
    }

    public function delete() {
        $bookmark = Bookmark::load($this->_INPUTS['hash'],'hash');
        $bookmark->delete();
    }
}