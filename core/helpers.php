<?php
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

/**
 * @return \LibreMVC\Views\Template\ViewBag
 */
function vb() {
    return \LibreMVC\Views\Template\ViewBag::get();
}

/**
 * Retourne l environnement courant
 * @return \LibreMVC\Mvc\ViewBag
 */
function ev() {
    return \LibreMVC\Mvc\Environnement::this();
}