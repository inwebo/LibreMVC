<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 24/01/15
 * Time: 20:08
 */

namespace LibreMVC\Modules\Bookmarks\Controllers;


use LibreMVC\Files\Config;
use LibreMVC\Helpers\Pagination;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Mvc\Controller\BaseController;
use LibreMVC\System;
use LibreMVC\Database\Drivers;
use LibreMVC\Database\Driver\MySql;
use LibreMVC\View;

class BookmarksController extends BaseController{

    const BOOKMARKLET_FILE = "bookmarklet.js";
    const BOOKMARK_MODEL = '\\LibreMVC\\Modules\\Bookmarks\Models\\Bookmark';
    /**
     * @var Config
     */
    protected $_config;
    /**
     * @var Drivers
     */
    protected $_db;
    /**
     * @var string
     */
    protected $_table;
    /**
     * @var int
     */
    protected $_total;
    /**
     * @var int
     */
    protected $_pagination;
    /**
     * @var string
     */
    protected $_uriRestService;

    public function init(){
        $c = $this->_system->getModule('bookmarks')->getConfig("dir");
        $this->_config          = Config::load($c);
        $this->_pagination      = $this->_config->Bookmarks['pagination'];
        $this->_uriRestService  = $this->_config->Rest['service'];

        // Prépare les accès bdd.
        try{
            Drivers::add( "bookmarks",
                new MySql(
                    $this->_config->Bookmarks['server'],
                    $this->_config->Bookmarks['database'],
                    $this->_config->Bookmarks['user'],
                    $this->_config->Bookmarks['password']
            ));
            $this->_table = $this->_config->Bookmarks['tablePrefix'] . $this->_config->Bookmarks['table'];
            $this->_db = Drivers::get('bookmarks');
            $this->_db->toStdClass();
            $this->_total = $this->_db->query("SELECT COUNT( * ) as total FROM " . $this->_table)->first()->total;
            $this->toView('total',$this->_total);
            $bookmark_tpl = $this->_system->getModule('bookmarks')->getStaticViews('dir') . "bookmark.php";
            $this->toView('template',$bookmark_tpl);
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }

    public function indexAction($page=1){
        $limits = Pagination::sqlLimit($this->_total, $page, $this->_pagination);
        $pagination = Pagination::dummyPagination($this->_total,$page,$this->_pagination);
        $this->toView("pagination",$pagination);
        $this->_db->toObject(self::BOOKMARK_MODEL);
        $bookmarks = $this->_db->query("SELECT * FROM " . $this->_table . " ORDER BY dt desc LIMIT " . $limits['start'] . ", " . $this->_pagination)->all();
        $this->toView("bookmarks",$bookmarks);
        $this->_view->render();
    }

    public function tagsAction(){
        $tags = $this->_db->query('SELECT tags FROM '. $this->_table . " GROUP BY tags ORDER BY dt desc")->all();
        $stringTagInput = "";
        foreach($tags as $tag) {
            $stringTagInput .= $tag->tags;
        }
        $tags = new Bookmark\Tags($stringTagInput);
        $this->toView("tags",$tags->toArray());
        $this->toView("total",$tags->count());
        $this->_view->render();
    }

    public function tagAction($tag){
        $tags = $this->_db->query('SELECT * FROM ' . $this->_table . ' WHERE tags LIKE "%' . $tag . '%" ORDER BY dt desc', array($tag))->all();
        $this->toView("bookmarks",$tags);
        $this->toView("tag",$tag);
        $this->_view->render();
    }

    public function bookmarkletAction() {
        $body = System::this()->getModule('bookmarks')->getStaticDir() . $this->_system->routed->action . '.php';
        $this->changePartial('body',$body);
        $bookmarklet = $this->_system->getModule('bookmarks')->getJsDir() . self::BOOKMARKLET_FILE;
        $this->toView('user', user()->login);
        $this->toView('publicKey', user()->publicKey);
        $this->toView('restService', $this->_uriRestService );
        //$view = View::partialsFactory($bookmarklet,$this->_vo);
        //$this->_vo->attachPartial('bookmarklet',$view);
        $this->render();
    }

}