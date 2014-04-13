<?php
namespace LibreMVC\Controllers;

use LibreMVC\Mvc\Controller\RestController;

class RestServiceController extends RestController {

    public function get() {
        var_dump( $_GET);
    }
    public function post($args) {
        $jo = json_decode($_POST);
        var_dump( $_POST['jo'] );
    }

}