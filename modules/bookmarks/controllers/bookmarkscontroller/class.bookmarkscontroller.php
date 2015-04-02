<?php
namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Files\Config;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Modules\Bookmarks\Models\ViewObjects\Page;
use LibreMVC\Mvc\Controller\ActionController;
use LibreMVC\Mvc\Controller\BaseController;
use LibreMVC\Mvc\Controller\Traits\DataBase;
use LibreMVC\System;
use LibreMVC\Database\Drivers;
use LibreMVC\Database\Driver\MySql;
use LibreMVC\View;
use LibreMVC\Helpers\Pagination;
use LibreMVC\Mvc\Controller\Traits\System as SystemTrait;

class BookmarksController extends ActionController{

    use DataBase;
    use SystemTrait;


    const BOOKMARK_MODEL = '\\LibreMVC\\Modules\\Bookmarks\\Models\\Bookmark';
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
        try {
            $this->setSystem(System::this());
            $config = $this->getModuleConfig('bookmarks')->DataBase;
            $this->setDbDriver(new MySql(
                $config['server'],
                $config['database'],
                $config['user'],
                $config['password']
            ));
            $this->getDbDriver()->toStdClass();
            $this->_table       = $config['table'];
            $this->_pagination  = $config['pagination'];
            $this->_total       = $this->getDbDriver()->query("SELECT COUNT( * ) as total FROM " . $this->_table)->first()->total;

            $this->toView('pagination',$this->_pagination);
            $this->toView('total',$this->_total);
            $this->toView('template', $this->getSystem()->getModule('bookmarks')->getStaticViews('dir') . "bookmark.php");
        }
        catch(\Exception $e) {
            throw $e;
        }

    }

    public function indexAction($page=1){
        $limits = Pagination::sqlLimit($this->_total, $page, $this->_pagination);
        $pagination = Pagination::dummyPagination($this->_total,$page,$this->_pagination);
        $this->getDbDriver()->toObject(self::BOOKMARK_MODEL);
        $bookmarks = $this->getDbDriver()->query("SELECT * FROM " . $this->_table . " ORDER BY dt desc LIMIT " . $limits['start'] . ", " . $this->_pagination)->all();
        $this->toView('pagination',$pagination);
        $this->toView('bookmarks',$bookmarks);
        $this->render();
    }

    public function tagsAction(){
        $tags = $this->getDbDriver()->query('SELECT tags FROM '. $this->_table . " GROUP BY tags ORDER BY dt desc")->all();
        $stringTagInput = "";
        foreach($tags as $tag) {
            $stringTagInput .= $tag->tags;
        }
        $tags = new Bookmark\Tags($stringTagInput);
        $this->toView("tags",$tags->toArray());
        $this->toView("total",$tags->count());
        $this->render();
    }

    public function search($tag) {
        $this->tagAction($tag);
    }

    public function tagAction($tag){
        $this->getDbDriver()->toObject(self::BOOKMARK_MODEL);
        $tags = $this->getDbDriver()->query('SELECT * FROM ' . $this->_table . ' WHERE tags LIKE "%' . $tag . '%" ORDER BY dt desc', array($tag))->all();
        $this->toView('total',count($tags));
        $this->toView("bookmarks",$tags);
        $this->toView("tag",$tag);
        $this->render();
    }

}