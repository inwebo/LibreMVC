<?php
ini_set('display_errors', 'on');
include('../core/view/autoload.php');
use LibreMVC\View;
use LibreMVC\View\ViewObject;
use LibreMVC\View\Template;
use LibreMVC\View\Template\TemplateFromString;

const TEST = "CONST";
try {

    $layout = 'demo/tpl/index.php';
    $partial = 'demo/tpl/partial.php';
    $demo = 'demo/tpl/demo.php';
    $fromString = "<html><body><h1>From string</h1></body></html>";

    $viewObject = new ViewObject();

    $_layout = new Template($layout);
//echo $_layout;
    $_layout2 = new TemplateFromString($fromString);

    $viewLayout = new View($_layout, $viewObject);

    $viewObject->viewObject = "From ViewObject !";


    $viewLayout->attachPartial('body', $partial);
    $p1 = $viewLayout->getPartial('body');
    $p1->attachPartial('demo', $demo);
    echo $viewLayout->render();
}
catch(\Exception $e) {
    var_dump($e);
}
?>
<hr>