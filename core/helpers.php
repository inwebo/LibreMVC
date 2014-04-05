<?php
use LibreMVC\Mvc\Environnement;
function css() {
    foreach (ev()->Theme->assets->css as $css) {
        echo $css;
    }
}
function js() {
    foreach (Environnement::this()->Theme->assets->js as $js) {
        echo $js;
    }
}

function getBreadCrumbs() {

}

function vb() {
    return \LibreMVC\View\Template\ViewBag::get();
}

/**
 * Retourne l environnement courant
 * @return \LibreMVC\Mvc\ViewBag
 */
function ev() {
    return \LibreMVC\Mvc\Environnement::this();
}

function renderBody($path, $vo) {

    $v = LibreMVC\View::partial($path, $vo);
    $v->render();
}

function view() {

}