<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 07/08/13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Errors;
use LibreMVC\Form;
use LibreMVC\Http\Header;
use LibreMVC\Models\User;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
use LibreMVC\Mvc\Controllers\RestController;
use LibreMVC\Views;
use LibreMVC\Http\Context;
use LibreMVC\Http\Rest\Client;
use LibreMVC\Database\Provider;
use LibreMVC\Files\Config;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Database\Driver\MySQL;

class BookmarkController extends RestController{

    public function __construct() {
        parent::__construct();
        Header::allowXDomain();
        $this->_paths = Environnement::this()->paths;
        $this->_config = Config::load( $this->_paths->base_config . '_db.ini' , false);
        // Database
        Provider::add( 'bookmarks', new \LibreMVC\Database\Driver\MySQL( $this->_config->db_server, $this->_config->db_database, $this->_config->db_user, $this->_config->db_password ) );
        $this->_db = Provider::get('bookmarks');
        $this->_db->toObject("LibreMVC\\Modules\\Bookmarks\\Bookmark");
        Bookmark::binder($this->_db,'my_tables_bookmarks');
    }

    public function get($args) {
        $this->public = false;
        $this->validateRequest();
        $this->httpReply->msg = $args[0];
        $this->httpReply->msg = "get";
    }

    protected function isValidUser($user, $publicKey) {
        //var_dump($user, $publicKey);
        // Charge l'utilisateur par son user & publicKey
        //$_user = User::loadByPublicKey($user, $publicKey, true);
        //var_dump($_user);

        return true;
    }

    public function post($args) {
        //var_dump($args);

        //Déjà fait dans la classe parent
        //$input = file_get_contents('php://input');
        //$input = parse_str(file_get_contents('php://input'), $_POST);

        //var_dump( $_POST );
        //var_dump($_POST);

        //echo( $_SERVER['REQUEST_METHOD']);
        //$this->public = false;
        //$this->validateRequest();
        $this->httpReply->msg = json_encode('Posted');
    }

    public function delete($args) {
        //echo __METHOD__;
        //$input = file_get_contents('php://input');
        //$input = parse_str(file_get_contents('php://input'), $_POST);
        //var_dump( $_POST );
    }

    public function put($args) {
        //echo __METHOD__;
        //$input = file_get_contents('php://input');
        array_walk($_POST,'urldecode');
        $bookmark = new \LibreMVC\Modules\Bookmarks\Models\Bookmark($_POST['url'], $_POST['title'],$_POST['keywords'],$_POST['description'],time(), $_POST['category'], $_POST['public'], $_POST['favicon'] );
        $bookmark->public = true;
        //$bookmark->boundTo();
        if($bookmark->save()) {
            $this->httpReply->msg = json_encode($_POST);
        }
        else {
            Header::badRequest();
            $this->httpReply->valid = false;
            $this->httpReply->msg = "Query statement failed, maybe integrity security";
        }
        //var_dump($bookmark);
        //$this->httpReply->msg = json_encode($_POST);
    }

    /*
    protected function isValidUser() {
        return ($this->token === Client::signature($this->user, md5("inwebo"), $this->timestamp));
    }
*/
    public function formAction(){
        //$form = new Form();
        //$this->_viewbag->form = $form->toHtml(true);
        //Views::renderAction();
    }
}