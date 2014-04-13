<?php
namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Form;
use LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Sessions;
use LibreMVC\Database;
use LibreMVC\Helpers\Pagination;
use LibreMVC\View\Parser\Tag;
use LibreMVC\View\ViewObject;
use LibreMVC\Views;
use LibreMVC\Instance;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Mvc;
use LibreMVC\Controllers;
use LibreMVC\Mvc\Controller\PageController;

class BookmarksController extends PageController{

    protected $_config;
    protected $_db;
    protected $_tableBookmarks;
    protected $_totalBookmarks;

    public function init() {
        // Chargement dans le context d'une configuration.
        $this->_config = Environnement::this()->config->instance;

//        var_dump($this->_config);

        // tables
        $this->_tableBookmarks = $this->_config->Db->tablePrefix . "bookmarks";

        // Prépare les accès bdd.
        try{
            Database\Provider::add( "bookmarks",
                new Database\Driver\MySql(
                    $this->_config->Db->server,
                    $this->_config->Db->database,
                    $this->_config->Db->user,
                    $this->_config->Db->password )
            );
        }
        catch(\Exception $e) {
            var_dump($e);
        }

        $this->_db = Database\Provider::get("bookmarks");
//        var_dump($this->_db);
        $this->_db->toStdClass();
//        $this->_totalBookmarks = $this->_db->query( "SELECT COUNT( * ) as total FROM " . $this->_tableBookmarks )->first()->total;
        $this->_totalBookmarks = $this->_db->query( "SELECT COUNT( * ) as total FROM " . $this->_tableBookmarks )->first()->total;


//        var_dump($this->_totalBookmarks);
    }

    public function indexAction( $page = 1 ) {
        $pagination = Pagination::dummyPagination( $this->_totalBookmarks, $page, 20 );
        $sqlLimit = $pagination->sqlLimit( $this->_totalBookmarks, $page, 20 );
        $bookmarks = $this->_db->query("SELECT * FROM " . $this->_tableBookmarks . " ORDER BY dt desc LIMIT " . $sqlLimit['start'] . ", 20")->all();
        //var_dump($bookmarks);
        //var_dump(ViewObject::map($bookmarks));
        $this->toView("bookmarks", ViewObject::map($bookmarks));
        $this->toView("pagination", $pagination);
        $this->_view->render();
    }

    public function tagAction( $tag ) {
        $tags = $this->_db->query('SELECT * FROM ' . $this->_tableBookmarks . ' WHERE tags LIKE "%' . $tag . '%"', array($tag))->all();
        $this->toView("tags",ViewObject::map($tags));
        $this->_view->render();
    }

    public function tagsAction() {
        $tags = $this->_db->query('SELECT tags FROM '. $this->_tableBookmarks . " GROUP BY tags")->all();
        $stringTagInput = "";
        foreach($tags as $tag) {
            $stringTagInput .= $tag->tags;
        }
        $tagsObject = new Tags($stringTagInput);
        $this->toView('tags',$tagsObject);
        $this->_view->render();
    }

    public function widgetAction() {
        $widgetFile = Environnement::this()->instance->realPath.'/assets/js/widget.js';
        $widgetFileAsString = file_get_contents($widgetFile, 1024);
        $widgetFileAsString = str_replace("%user%",Sessions::this()['User']->login,$widgetFileAsString);
        $widgetFileAsString = str_replace("%publicKey%",Sessions::this()['User']->publicKey,$widgetFileAsString);
        $widgetFileAsString = str_replace("%restService%", Environnement::this()->instance->baseUrl."form", $widgetFileAsString);
        $this->_viewbag->get()->widget = $widgetFileAsString;
        Views::renderAction();
    }
}