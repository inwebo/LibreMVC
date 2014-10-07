<?php
use LibreMVC\Mvc\Environnement;

function getBaseUrl() {
    return ev()->instance->getBaseUrl();
}

function getBaseAssetsFolder() {
    return ev()->Files->core['url']['global_assets'];
}

function getBaseJsFolder() {
    return ev()->Files->core['url']['global_assets_js'];
}

function getBaseCssFolder() {
    return ev()->Files->core['url']['global_assets_css'];
}

function getThemeBaseFolder($theme) {
    return ev()->Files->Themes[$theme]['url']['base'];
}

function getThemeBaseUrl($theme) {
    return ev()->Files->Themes[$theme]['realPath']['base'];
}

function ev() {
    return \LibreMVC\Mvc\Environnement::this();
}

function partial( $path, \LibreMVC\View\ViewObject $vo ) {
    try {
        $v = LibreMVC\View::partial($path, $vo);
        $v->render();
    }
    catch(\Exception $e) {
        var_dump($e);
    }
}

function getCss() {
    return ev()->Files->css;
}

function getJs() {
    return ev()->Files->js;
}

function addToBreadCrumbs() {}

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

/**
 * Snippets
 */
/*if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
    return crypt($password, $salt);
}*/
