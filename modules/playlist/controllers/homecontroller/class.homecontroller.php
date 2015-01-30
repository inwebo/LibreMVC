<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 24/01/15
 * Time: 20:08
 */

namespace LibreMVC\Modules\Playlist\Controllers;

use LibreMVC\Modules\Playlist\Models\Song;
use LibreMVC\Modules\Playlist\Models\Playlist;
use LibreMVC\Modules\Playlist\Models\Mood;
use LibreMVC\Mvc\Controller\BaseController;
use LibreMVC\System;
use LibreMVC\Files\Config;
use LibreMVC\Database\Drivers;
use LibreMVC\Database\Driver\MySql;

class HomeController extends BaseController{

    protected function init(){

        $viewsPath = $this->_system->this()->getInstanceBaseDirs('views') .
            'playlist' . '/' .
            $this->_system->this()->routed->action . '.php';
        $this->changePartial('body',$viewsPath);

        $config = System::this()->instancePaths->getBaseDir()['config'];
        $this->_config = Config::load($config);
        try{
            Drivers::add( "playlist",
                new MySql(
                    $this->_config->Playlist['server'],
                    $this->_config->Playlist['database'],
                    $this->_config->Playlist['user'],
                    $this->_config->Playlist['password']
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
    }

    public function indexAction() {
        $this->toView("Playlist",Playlist::load(1));
        $this->_view->render();
    }

}