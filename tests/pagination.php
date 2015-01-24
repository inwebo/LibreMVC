<?php
ini_set('display_errors', 'on');
include('../core/helpers/pagination/class.pagination.php');
use LibreMVC\Helpers\Pagination;
$a = array_fill(1,70,"");

$p = new Pagination($a);

var_dump($p->total());
var_dump($p->page(3));