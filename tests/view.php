<?php
ini_set('display_errors', 'on');
include('../core/view/autoload.php');
use LibreMVC\View;
use LibreMVC\View\ViewObject;
use LibreMVC\View\Template;

$vo = new ViewObject();
$_layout = new View(
    new Template('demo/tpl/index.php'),
    $vo
);

$_partial = new View(
    new Template('demo/tpl/partial.php'),
    $vo
);

$vo->attachPartial('menu',$_partial);

$vo->arf = "arf";

$_layout->render();