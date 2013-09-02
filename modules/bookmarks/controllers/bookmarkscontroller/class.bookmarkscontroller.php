<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 12/05/13
 * Time: 01:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Http\Request;
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
use LibreMVC\Mvc\Controllers\ErrorsController;


class BookmarksController extends PageController{

    protected $_db;
    protected $_paths;
    protected $_config;
    protected $_tables;

    public function __construct() {
        parent::__construct();
        $this->_paths = Environnement::this()->paths;
        $this->_config = Config::load( $this->_paths->base_config . '_db.ini' , false);
        Database::setup( 'bookmarks', new MySQL( $this->_config->db_server, $this->_config->db_database, $this->_config->db_user, $this->_config->db_password ) );
        $this->_db = Database::get('bookmarks');
        $this->_meta->base .="bookmarks/";
    }

    public function indexAction( $page = 1 ) {
        $f = new Pagination($this->_db->query("SELECT * FROM my_tables_bookmarks"));
        ViewBag::get()->bookmarks = $f->page($page);
        ViewBag::get()->categories = $this->getAllCategories();
        $a = $this->getBookmarksByCategory($this->getAllCategories());
        ViewBag::get()->bookmarks = $a;
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
        $category = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE category = ?', array($idCategorie));
        $categoryName = $this->_db->query('SELECT name FROM my_tables_categories WHERE id=?', array($idCategorie));
        $this->_meta->title = "Inwebo > Bookmarks > " . $categoryName[0]['name'] . ' > page > '. $page;
        $this->_meta->description = "Annuaire de liens intéressants par Inwebo dans la catégorie " . $categoryName[0]['name'] . ' et à la page ' . $page;
        $f = new Pagination($category, $page);
        if( $page > $f->max ) {
            ErrorsController::throwHttpError("404");
        }

        ViewBag::get()->bookmarks = $f->page($page);
        ViewBag::get()->categoryName = $categoryName[0]['name'];
        ViewBag::get()->categoryId = $idCategorie;
        ViewBag::get()->totalPages = $f->max;
        //var_dump($f);
        Views::renderAction();

    }

}