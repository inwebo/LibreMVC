<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 12/05/13
 * Time: 01:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Apache\Controllers;

use LibreMVC\Http\Request;
use LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags;
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
// @todo page > total
use LibreMVC\Mvc\Controllers\ErrorsController;
use LibreMVC\System\Hooks;

class ApacheController extends PageController{

    protected $_db;
    protected $_paths;
    protected $_config;
    protected $_tables;

    public $breadcrumbs;

    public function __construct() {
        parent::__construct();
        $this->_paths = Environnement::this()->paths;
        $this->_config = Config::load( $this->_paths->base_config . '_db.ini' , false);
        Database::setup( 'bookmarks', new MySQL( $this->_config->db_server, $this->_config->db_database, $this->_config->db_user, $this->_config->db_password ) );
        $this->_db = Database::get('bookmarks');
        $this->_meta->base .="bookmarks/";


        $this->breadcrumbs[1]->items->home = Environnement::this()->instance->baseUrl ;
        $this->breadcrumbs[1]->items->bookmarks = $this->breadcrumbs[1]->items->home . "bookmarks/";
        ViewBag::get()->bookmarks = "";
        ViewBag::get()->bookmarks->categories = "";
    }

    public function indexAction( $page = 1 ) {

        $categories = $this->_db->query("SELECT * FROM my_tables_categories");
        foreach($categories as $category) {
            $cat = new \StdClass();
            $cat->id = $category['id'];
            $cat->name = $category['name'];
            $cat->total = $this->_db->query("SELECT count(*) as total FROM my_tables_bookmarks as t1 where t1.category=?", array($category['id']))[0]['total'];

            ViewBag::get()->bookmarks->categories->$category['name'] = $cat;
            $bookmarks = $this->_db->query("SELECT * FROM my_tables_bookmarks as t1 where t1.category=? LIMIT 0,10", array($category['id']));
            ViewBag::get()->bookmarks->categories->$category['name']->bookmarks = $bookmarks;
        }
        Views::renderAction();
    }

    protected function getAllCategories() {
        $categories = $this->_db->query("SELECT * FROM my_tables_categories");
        return $categories;
    }

    protected function getBookmarksByCategory($categories, $limit = 20 ) {
        $buffer = new \StdClass();
        foreach($categories as $categorie) {
            $buffer->$categorie['name'] = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE category = ? ORDER BY dt desc LIMIT 1,20 ', array($categorie['id']));
        }
        return $buffer;
    }

    public function categoryAction( $idCategorie = 1, $page = 1 ) {

        $total = $this->_db->query('
                                        SELECT count( * ) as "total"
                                        FROM my_tables_bookmarks as t1

                                        WHERE t1.category =?', array($idCategorie))[0]['total'];

        $pagination = Pagination::dummyPagination($total, $page, 25);
        $sqlLimit = $pagination->sqlLimit($total, 25, $page);

        $category = $this->_db->query(' SELECT *
                                        FROM `my_tables_bookmarks` AS t1, (
                                        SELECT count( * ) as "total"
                                        FROM my_tables_bookmarks
                                        ) AS totalBookmarks
                                        JOIN my_tables_categories AS t2
                                        WHERE t2.id = ?
                                        AND t1.category = ? Order by t1.dt desc LIMIT ' . $sqlLimit['start'] . ',25', array($idCategorie, $idCategorie));

        $this->breadcrumbs[1]->items->category = "";
        $this->breadcrumbs[1]->items->$category[0]['name'] = $this->breadcrumbs[1]->items->category ."category/" .$category[0]['id'];
        $this->breadcrumbs[1]->items->page = $this->breadcrumbs[1]->items->category ."category/" .$category[0]['id'] . '/page/' . $page;
        $this->breadcrumbs[1]->items->$category[0]['id'] = "";

        ViewBag::get()->breadcrumbs = $this->breadcrumbs[1];
        $cat = new \StdClass();
        $cat->id = $category[0]['id'];
        $cat->name = $category[0]['name'];
        $cat->total = $total;
        $cat->bookmarks = $category;
        ViewBag::get()->bookmarks->categories = null;
        ViewBag::get()->bookmarks->categories->current = $cat;
        ViewBag::get()->bookmarks->pagination = $pagination;
        Views::renderAction();

    }

    public function tagAction( $tag ) {
        //echo $tag;
        $tags = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE tags LIKE "%'.$tag.'%"', array($tag));
        $total = $this->_db->query('SELECT count(*) as total FROM my_tables_bookmarks WHERE tags LIKE "%'.$tag.'%"', array($tag));
        //var_dump('SELECT * FROM my_tables_bookmarks WHERE tags LIKE "%'.$tag.'%"');
        $cat = new \StdClass();
        $cat->id = "";
        $cat->name = $tag;
        $cat->total = $total[0]['total'];
        $cat->bookmarks = $tags;
        $this->breadcrumbs[1]->items->tag = "";
        $this->breadcrumbs[1]->items->$tag = "";
        ViewBag::get()->bookmarks->categories = null;
        ViewBag::get()->bookmarks->categories->current = $cat;
        ViewBag::get()->breadcrumbs = $this->breadcrumbs[1];
        Views::renderAction();
    }

    public function tagsAction($tag="") {
        $tagsArray = array();
        $tags = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE tags LIKE "%'.$tag.'%"', array($tag));
        $return = array();

        foreach($tags as $tag) {
            $t = new Tags($tag['tags']);
            $tagsArray = array_merge($tagsArray, $t->buffer);
            var_dump($t->toNormalizedArray());
            //$imploded = strtolower(implode(" ", $t->buffer));
            //echo "UPDATE my_tables_bookmarks SET tags = '".$imploded."' WHERE my_tables_bookmarks.id = ". $tag['id'] ."" . '<br>';
            //$this->_db->query("UPDATE my_tables_bookmarks SET tags = '".$imploded."' WHERE my_tables_bookmarks.id = ". $tag['id'] .";");
        }
        //@todo normalize tags
        $tagsArray = array_map('strtolower', $tagsArray);
        $tagsArray = array_filter($tagsArray);
        asort($tagsArray);
        $_tagsArray = array_flip($tagsArray);
        $_tagsArray = array_unique($tagsArray);

        foreach($_tagsArray as $k=> $v) {
            $return[$v] = count(array_keys($tagsArray, $v));
            //echo $v . "<br>";
        }


        //var_dump( $tagsArray );
        //var_dump( $_tagsArray );
        //var_dump( $return );
        ViewBag::get()->bookmarks->tags = $return;
        Views::renderAction();
    }

}