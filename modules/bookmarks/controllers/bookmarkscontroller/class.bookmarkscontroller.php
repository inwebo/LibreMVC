<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 12/05/13
 * Time: 01:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Form;
use LibreMVC\Http\Request;
use LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags;
use LibreMVC\Sessions;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Database;
use LibreMVC\Helpers\Pagination;
use LibreMVC\Views;
use LibreMVC\Instance;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Files\Config;
use LibreMVC\Database\Driver\MySQL;
use LibreMVC\Http\Header;
use LibreMVC\Mvc;
use LibreMVC\Controllers;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Mvc\Controllers\ProtectedController;
// @todo page > total
use LibreMVC\Mvc\Controllers\ErrorsController;
use LibreMVC\System\Hooks;

class BookmarksController extends ProtectedController{

    protected $_db;
    protected $_paths;
    protected $_config;
    protected $_prefixTables;

    public $breadcrumbs;


    public function __construct() {
        parent::__construct();
        // Context
        $this->_paths = Environnement::this()->paths;
        $this->_config = Config::load( $this->_paths->base_config . '_db.ini' , false);

        // Database
        try {
            Database\Provider::add( 'bookmarks', new MySQL( $this->_config->db_server, $this->_config->db_database, $this->_config->db_user, $this->_config->db_password ) );
        }
        catch(\Exception $e) {
            //var_dump($e);
        }
        $this->_db = Database\Provider::get('bookmarks');
        $this->_prefixTables = Config::load(Environnement::this()->Modules->Bookmarks->config);
        $this->_prefixTables =  $this->_prefixTables->Db->tablePreffix ;

        // Menu
        $menus = new \StdClass;
        $menus->Tags = "tags/";
        $categories = $this->_db->query("SELECT * FROM ".$this->_prefixTables."categories")->all();

        // ViewBag
        $this->_viewbag->categories = $categories;
        $this->_viewbag->menus =$menus;

        $this->_viewbag->bookmarks = new \StdClass;
        $this->_viewbag->bookmarks->categories = new \StdClass;;

        //BreadCrumbs
        $this->_breadCrumbs->items->bookmarks = '';

    }

    protected function getCurrentTable() {
        return $this->_prefixTables . $this->_table;
    }

    public function indexAction( $page = 1 ) {
        $categories = $this->_db->query("SELECT * FROM ".$this->_prefixTables."categories")->all();
        foreach($categories as $category) {
            $cat = new \StdClass();
            $cat->id = $category['id'];
            $cat->name = $category['name'];
            $cat->total = $this->_db->query("SELECT count(*) as total FROM ".$this->_prefixTables."bookmarks as t1 where t1.category=?", array($category['id']))->first()['total'];

            $this->_meta->title = "Mon annuaire en ligne avec " . $cat->total . " liens sauvegardés";

            $this->_viewbag->bookmarks->categories->$category['name'] = $cat;
            $bookmarks = $this->_db->query("SELECT * FROM ".$this->_prefixTables."bookmarks as t1 where t1.category=? ORDER BY `t1`.`dt` DESC LIMIT 0,10", array($category['id']));
            $this->_viewbag->bookmarks->categories->$category['name']->bookmarks = $bookmarks->all();
        }
        Views::renderAction();
    }

    protected function getAllCategories() {
        $categories = $this->_db->query("SELECT * FROM ".$this->_prefixTables."categories")->all();
        return $categories;
    }

    protected function getBookmarksByCategory($categories, $limit = 20 ) {

        $buffer = new \StdClass();
        foreach($categories as $categorie) {
            $buffer->$categorie['name'] = $this->_db->query('SELECT * FROM '.$this->_prefixTables.'bookmarks WHERE category = ? ORDER BY dt desc LIMIT 1,? ', array($categorie['id'],$limit));
        }
        return $buffer;
    }

    public function categoryAction( $idCategorie = 1, $page = 1 ) {
        $total = $this->_db->query('
                                        SELECT count( * ) as "total"
                                        FROM '.$this->_prefixTables.'bookmarks as t1
                                        WHERE t1.category =?', array($idCategorie))->first();
        $pagination = Pagination::dummyPagination($total['total'], $page, 25);
        $sqlLimit = $pagination->sqlLimit($total['total'], 25, $page);
        $this->_db->toAssoc();
        $bookmarks = $this->_db->query(' SELECT *
                                        FROM `'.$this->_prefixTables.'bookmarks` AS t1, (
                                        SELECT count( * ) as "total"
                                        FROM '.$this->_prefixTables.'bookmarks
                                        ) AS totalBookmarks
                                        JOIN '.$this->_prefixTables.'categories AS t2
                                        WHERE t2.id = ?
                                        AND t1.category = ? Order by t1.dt desc LIMIT ' . $sqlLimit['start'] . ',25', array($idCategorie, $idCategorie))->all();
        $this->_breadCrumbs->items->category="";
        $this->_breadCrumbs->items->$bookmarks[0]["name"]="";
        $p = "page&nbsp;".$page;
        $this->_breadCrumbs->items->$p="";

        $cat = new \StdClass();
        $cat->id = $bookmarks[0]['id'];
        $cat->name = $bookmarks[0]['name'];
        $cat->total = $bookmarks[0]['total'];
        $cat->bookmarks = $bookmarks;

        $this->_viewbag->bookmarks->categories = null;
        $this->_viewbag->bookmarks->categories->current = $cat;
        $this->_viewbag->bookmarks->pagination = $pagination;

        $this->_meta->title = "Catégorie > " . $bookmarks[0]['name'] . " > page " . $page;

        Views::renderAction();

    }

    public function tagAction( $tag ) {
        //echo $tag;
        $tags = $this->_db->query('SELECT * FROM '.$this->_prefixTables.'bookmarks WHERE tags LIKE "%'.$tag.'%"', array($tag));
        $total = $this->_db->query('SELECT count(*) as total FROM '.$this->_prefixTables.'bookmarks WHERE tags LIKE "%'.$tag.'%"', array($tag));
        //var_dump('SELECT * FROM my_tables_bookmarks WHERE tags LIKE "%'.$tag.'%"');
        $cat = new \StdClass();
        $cat->id = "";
        $cat->name = $tag;
        $cat->total = $total->first()['total'];
        $cat->bookmarks = $tags->all();

        $this->_breadCrumbs->items->tag = "";
        $this->_breadCrumbs->items->$tag = "";
        $this->_meta->title="Tag : " . $tag;
        $this->_viewbag->bookmarks->categories = null;
        $this->_viewbag->bookmarks->categories->current = $cat;
        $this->_viewbag->breadcrumbs = $this->breadcrumbs[1];
        Views::renderAction();
    }

    public function tagsAction($tag="") {
        $this->_breadCrumbs->items->tags = "tags/";
        $tag = ($tag==="") ? "all" : $tag;
        $this->_breadCrumbs->items->$tag = "";

        $tagsArray = array();
        $tags = $this->_db->query('SELECT * FROM '.$this->_prefixTables.'bookmarks WHERE tags LIKE "%'.$tag.'%"', array($tag))->all();
        $return = array();

        foreach($tags as $tag) {
            $t = new Tags($tag['tags']);
            $tagsArray = array_merge($tagsArray, $t->buffer);
            //$t->toNormalizedArray();
            //var_dump($t->toNormalizedArray());
            //$imploded = strtolower(implode(" ", $t->buffer));
            //echo "UPDATE my_tables_bookmarks SET tags = '".$imploded."' WHERE my_tables_bookmarks.id = ". $tag['id'] ."" . '<br>';
            //$this->_db->query("UPDATE my_tables_bookmarks SET tags = '".$imploded."' WHERE my_tables_bookmarks.id = ". $tag['id'] .";");
        }
        //@todo normalize tags

        $_tagsArrayCount = $tagsArray;
        //var_dump(count(array_keys($_tagsArrayCount,'icon')));
        $tagsArray = array_map('strtolower', $tagsArray);
        $tagsArray = array_filter($tagsArray);
        asort($tagsArray);
        array_flip($tagsArray);
        $_tagsArray = array_unique($tagsArray);

        foreach($_tagsArray as $k=> $v) {
            $return[$v] = count( array_keys($_tagsArrayCount, $v) );
        }

        //var_dump( $tagsArray );
        //var_dump( $_tagsArrayCount );
        //var_dump( $_tagsArray );
        //var_dump( $return );
        $this->_viewbag->bookmarks->tags = $return;
        Views::renderAction();
    }

    /**
     * Widget
     */
    public function formAction( ) {
        $this->isForbidden();
        $cat = $this->getAllCategories();
        $this->_viewbag->Bookmarks = new \StdClass;
        foreach($cat as $v) {
            $this->_viewbag->Bookmarks->categories->$v['name'] = $v['id'];
        }
        Views::renderAction();
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
    public function loginAction() {
        $this->_breadCrumbs->items->login=null;
        $this->_meta->title = "Please login";
        Views::renderAction();
    }
}