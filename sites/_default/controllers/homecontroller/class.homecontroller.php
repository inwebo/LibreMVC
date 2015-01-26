<?php
namespace LibreMVC\Controllers {

    use LibreMVC\Files\Config;
    use LibreMVC\Mvc\Controller\BaseController;

    use LibreMVC\System;
    use LibreMVC\Database\Drivers;
    use LibreMVC\Database\Driver\MySql;


    class HomeController extends BaseController{

        protected $_config;
        protected $_mysql;

        public function init(){
            $config = System::this()->instancePaths->getBaseDir()['config'];
            $this->_config = Config::load($config, false);
            // Prépare les accès bdd.
            try{
                Drivers::add( "bookmarks",
                    new MySql(
                        $this->_config->server,
                        $this->_config->database,
                        $this->_config->user,
                        $this->_config->password )
                );

                $this->_mysql = Drivers::get('bookmarks');
                Drivers::get('bookmarks')->toStdClass();
            }
            catch(\Exception $e) {
                var_dump($e);
            }
            $this->_db = Drivers::get("bookmarks");
        }

        public function indexAction(){
            $this->_view->render();
        }

        public function testAction(){
            $this->_view->render();
        }
    }
}