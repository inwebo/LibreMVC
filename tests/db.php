<?php
ini_set('display_errors', 'on');
include('../core/database/autoload.php');

use LibreMVC\Database as DB;
use LibreMVC\Database\Driver\MySql;

$s = "localhost";
$db = "inwebourl";
$u = "root";
$p = "root";

DB\Provider::add("MySQL", new MySql($s, $db,$u, $p));