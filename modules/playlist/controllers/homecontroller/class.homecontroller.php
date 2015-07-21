<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 24/01/15
 * Time: 20:08
 */

namespace LibreMVC\Modules\Playlist\Controllers;


use LibreMVC\Modules\Bookmarks\Models\Bookmark;

use LibreMVC\Mvc\Controller\ActionController;
use LibreMVC\Mvc\Controller\BaseController;
use LibreMVC\Mvc\Controller\Traits\DataBase;
use LibreMVC\System;

use LibreMVC\Database\Driver\MySql;
use LibreMVC\View;

use LibreMVC\Modules\Playlist\Models\Mood;
use LibreMVC\Modules\Playlist\Models\Playlist;
use LibreMVC\Modules\Playlist\Models\Song;

use LibreMVC\Mvc\Controller\Traits\System as SystemTrait;

class HomeController extends ActionController{
    use DataBase;
    use SystemTrait;

    /**
     * @var string
     */
    protected $_table;

    protected function init(){

        $this->setSystem(System::this());
        $config = $this->getModuleConfig('playlist')->DataBase;

        $this->setDbDriver(new MySql(
            $config['server'],
            $config['database'],
            $config['user'],
            $config['password']
        ));

        $this->getDbDriver()->toStdClass();
        Playlist::binder($this->getDbDriver(),'id',$this->getModuleConfig('playlist')->Tables['playlists']);

        //$this->_table       = $config['table'];
/*

        $viewsPath = $this->_system->this()->getInstanceBaseDirs('views') .
            'playlist' . '/' .
            $this->_system->this()->routed->action . '.php';

        $this->changePartial('body',$viewsPath);

        /**
        try{
            Drivers::add( "playlist",
                new MySql(
                    $config['server'],
                    $config['database'],
                    $config['user'],
                    $config['password']
                ));
            $this->_table = $this->_config->Playlist['tablePrefix'] . $this->_config->Playlist['table'];
            $this->_db = Drivers::get('playlist');
            $this->_db->toStdClass();
            Playlist::binder($this->_db);
            Song::binder($this->_db);
            Mood::binder($this->_db);
        }
        catch(\Exception $e) {
            var_dump($e);
        }
         **/
    }

    public function indexAction() {

        //$m = Mood::load(2);
        //var_dump($m);
        //$m = new Mood(9);
        //$m = Mood::load(8);
        //$m->name = "---";
        //var_dump($m);
        //$m->delete();
        //$m = new Mood();
        //$m->name = "test";
        ///$m->save();
        $this->toView("Playlist",Playlist::load(1));
        //var_dump(Playlist::load(1));
        $this->render();

    }

}