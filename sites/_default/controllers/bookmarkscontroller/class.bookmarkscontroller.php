<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 12/05/13
 * Time: 01:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMCV\Controllers;

use \LibreMCV\Http\Request;
use LibreMVC\Core\Views\ViewBag;
use \LibreMVC\Database;

use LibreMVC\Helpers\Pagination;
use \LibreMVC\Views;

class BookmarksController {

    protected $_db;

    public function __construct() {
        Database::setup('bookmarks',new \LibreMVC\Database\Driver\MySQL('localhost','bookmarks','root','root'));
        $this->_db =Database::get('bookmarks');
    }

    public function indexAction( $page = 1 ) {

        $f = new Pagination($this->_db->query('SELECT * FROM my_tables_bookmarks'));
        ViewBag::get()->bookmarks =$f->page($page);
        $this->getAllCategories();
        $a = $this->getBookmarksByCategory($this->getAllCategories());
        ViewBag::get()->bookmarks = $a;
        Views::renderAction();

    }

    protected function getAllCategories() {
        $categories  = $this->_db->query('SELECT * FROM my_tables_categories');
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
        echo $idCategorie, $page;
        $a = $this->_db->query('SELECT * FROM my_tables_bookmarks WHERE category = ?', array($idCategorie));
        $f = new Pagination($this->_db->query('SELECT * FROM my_tables_bookmarks WHERE cateogry = ?', array($idCategorie)));
        ViewBag::get()->bookmarks = $f->first();
        Views::renderAction();

    }

}