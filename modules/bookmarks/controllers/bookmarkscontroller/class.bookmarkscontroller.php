<?php
namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Form;
use LibreMVC\Http\Context;
use LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Sessions;
use LibreMVC\Database;
use LibreMVC\Helpers\Pagination;
use LibreMVC\String;
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
    protected $_tables;
    protected $_db;
    protected $_servicesUrl;
    protected $_totalBookmarks;

    public function init() {
        parent::init();

        // Chargement dans le context d'une configuration.
        $this->_config = Environnement::this()->config->instance;
        $this->_tables = $this->_config->Db->tablePrefix . $this->_config->Db->table;
        $this->_servicesUrl = $this->_config->Rest->form;

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
        $this->_db->toStdClass();
        $this->_totalBookmarks = $this->_db->query( "SELECT COUNT( * ) as total FROM " . $this->_tables )->first()->total;

    }

    public function indexAction( $page = 1 ) {
        $pagination = Pagination::dummyPagination( $this->_totalBookmarks, $page, 20 );
        $sqlLimit = $pagination->sqlLimit( $this->_totalBookmarks,20,$page );
        $bookmarks = $this->_db->query("SELECT * FROM " . $this->_tables . " ORDER BY dt desc LIMIT " . $sqlLimit['start'] . ", 20")->all();
        //var_dump(ViewObject::map($bookmarks));
        $this->toView("bookmarks", ViewObject::map($bookmarks));
        $this->toView("pagination", $pagination);
        $this->toView("bookmarksCount", $this->_totalBookmarks);
        //$this->_head->title = "My.Bookmarks actuellement " . $this->_totalBookmarks . " bookmarks, page " . $page . " sur " . $pagination->max;
        $this->_head->title = "Inwebo's &hearts; bookmarks.";

        $crud = $this->injectStringsToView(
            BOOKMARKS_CRUD,
            array(
                "%user%",
                "%publicKey%",
                "%restService%"
            ),
            array(
                Sessions::this()['User']->login,
                Sessions::this()['User']->publicKey,
                Context::getBaseUrl() . $this->_config->Rest->service
            )
        );
        $this->toView("crud",$crud);

        $this->_view->render();
    }

    public function tagAction( $tag ) {
        $tags = $this->_db->query('SELECT * FROM ' . $this->_tables . ' WHERE tags LIKE "%' . $tag . '%" ORDER BY dt desc', array($tag))->all();
        //$tags = $this->_db->query('SELECT * FROM ' . $this->_tables . ' WHERE LOCATE('. $tag .',tags) ORDER BY dt desc', array($tag))->all();
        $this->toView("tags",ViewObject::map($tags));
        $this->_head->title = "My.Bookmarks tag : '" .  $tag . "' " . count($tags) . " résultats.";
        //var_dump(Environnement::this());
        $crud = $this->injectStringsToView(
            BOOKMARKS_CRUD,
            array(
                "%user%",
                "%publicKey%",
                "%restService%"
            ),
            array(
                Sessions::this()['User']->login,
                Sessions::this()['User']->publicKey,
                Context::getBaseUrl() . $this->_config->Rest->service
            )
        );
        $this->toView("crud",$crud);
        $this->toView("total",count($tags));
        $this->_view->render();

    }

    public function tagsAction() {
        $tags = $this->_db->query('SELECT tags FROM '. $this->_tables . " GROUP BY tags ORDER BY dt desc")->all();
        $stringTagInput = "";
        $totalTags = count($tags);
        foreach($tags as $tag) {
            $stringTagInput .= $tag->tags;
        }
        $tagsObject = new Tags($stringTagInput);
        $this->toView('tags',$tagsObject);

        $this->_head->title = "My.Bookmarks " . $totalTags . " tags.";
        $this->toView('total', $totalTags);

        $this->_view->render();
    }

    public function widgetAction() {
        $widgetFileAsString = file_get_contents(TPL_BOOKMARKS_WIDGET, 1024);
        $widgetFileAsString = str_replace("%user%",Sessions::this()['User']->login,$widgetFileAsString);
        $widgetFileAsString = str_replace("%publicKey%",Sessions::this()['User']->publicKey,$widgetFileAsString);
        $widgetFileAsString = str_replace("%restService%",Context::getBaseUrl() . $this->_servicesUrl , $widgetFileAsString);
        $this->toView("widget", $widgetFileAsString);
        $this->_view->render();
    }

    protected function injectStringsToView( $file, $patterns, $replacement ) {
        $string = file_get_contents($file, 1024);
        return String::replace( $string, $patterns, $replacement );
    }
}