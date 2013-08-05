<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 12/05/13
 * Time: 01:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Controllers;

use LibreMVC\Http\Request;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Database;
use LibreMVC\Helpers\Pagination;
use LibreMVC\Views;
use LibreMVC\Instance;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Files\Config;
use LibreMVC\Database\Driver\MySQL;

class BookmarksController {

    protected $_db;
    protected $_paths;
    protected $_config;

    public function __construct() {
        $this->_paths = Environnement::this()->paths;
        $this->_config = Config::load( $this->_paths['base_config'] . '_db.ini' );
        //@todo devrait provenir du fichier ini
        Database::setup( 'bookmarks', new MySQL( 'localhost', 'bookmarks', 'root','root' ) );
        $this->_viewbag->baseUrl = "yeah";
        $this->_db = Database::get('bookmarks');
    }

    public function indexAction( $page = 1 ) {
        $f = new Pagination($this->_db->query('SELECT * FROM my_tables_bookmarks'));
        ViewBag::get()->bookmarks = $f->page($page);
        $this->getAllCategories();
        $a = $this->getBookmarksByCategory($this->getAllCategories());
        ViewBag::get()->bookmarks = $a;
        Views::renderAction();
    }

    protected function getAllCategories() {
        $categories = $this->_db->query('SELECT * FROM my_tables_categories');
        return $categories;
    }

    public function addbookmarkAction() {

        \LibreMVC\Http\Header::json();
        echo json_encode(get_declared_classes());


    }

    protected function getBookmarksByCategory($categories, $limit = 20 ) {
        $buffer = new \StdClass();
        foreach($categories as $categorie) {
            $buffer->$categorie['name'] = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE category = ? ORDER BY dt desc LIMIT 1,20 ', array($categorie['id']));
        }
        return $buffer;
    }

    public function categoryAction( $idCategorie = 1, $page = 1 ) {
        //echo $idCategorie, $page;
        $category = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE category = ?', array($idCategorie));
        $categoryName = $this->_db->query('SELECT name FROM my_tables_categories WHERE id=?', array($idCategorie));
        $f = new Pagination($category, $page);
        ViewBag::get()->bookmarks = $f->page($page);
        ViewBag::get()->categoryName = $categoryName[0]['name'];
        ViewBag::get()->categoryId = $idCategorie;

        ViewBag::get()->totalPages = $f->max;
        //var_dump($f);
        Views::renderAction();

    }

}