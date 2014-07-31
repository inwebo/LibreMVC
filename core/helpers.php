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

function partial($path, $vo) {
    renderBody($path,$vo);
}

function viewAction() {
    return ev()->templateAction;
}

function getInstanceUri() {
    return \LibreMVC\Http\Context::getBaseUri();
}

function baseJs() {
    echo(ev()->basePaths->global_assets_js);
}

function instanceJs() {
    echo(ev()->urls->instance->instance_assets_js);
}

function baseCss() {
    echo(ev()->basePaths->global_assets_css);
}

function instanceCss() {
    echo(ev()->themes['default']->theme_baseUrl_css);
}

/**
 * Ajoute un item au bread crumb.
 */
function addToBreadCrumbs() {}

function getBaseHref() {
    echo Environnement::this()->instance->getBaseUrl();
}

function getInstanceBaseUri() {
    $baseUri =  trim(Environnement::this()->instance->getInstanceBaseUri(),'/');
    if( $baseUri !== '') {
        $base_uri = '/'.$baseUri.'/';
    }
    else {
        $base_uri = '/';
    }
    return $base_uri ;
}

function vd($var) {
    var_dump($var);
}