<?php

include('../core/http/authentification/autoload.php');

use LibreMVC\Http\Authentification\Digest;
$user = array('a','z');
$realm = "Tesst";
$auth = new Digest($realm);
$auth->addUsers($user);
$auth->registerShutDown(function(){
    echo "HaHA";
});
$auth->header();
echo '+';
session_start();
var_dump($_SESSION);