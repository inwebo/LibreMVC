<?php
include( dirname(__FILE__) . "/core/autoloader/class.autoloader.php" );
include('core/standart.php');
include('core/helpers.php');

use LibreMVC\Mvc\Environnement;
use LibreMVC\System\Boot;
use LibreMVC\System\Boot\Mvc;
use LibreMVC\AutoLoader;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Http\Header;
use LibreMVC\Errors\ErrorsHandler;
use LibreMVC\Routing\RoutesCollection;

/**
 * JS
 */

/*

var user = 'inwebo';
var token = 'd46a1e7d07cb1bca68b501f85c803abc';

$.ajax({
type: "POST",
url: "http://www.inwebo.dev/LibreMVC/restservice/",

headers: {
    Accept : "application/json",
    "Content-Type": "application/json"
},
beforeSend:function(xhr){
    var timestamp = Date.now();
    xhr.setRequestHeader('User', user);
    xhr.setRequestHeader('Timestamp', timestamp);
    xhr.setRequestHeader('Token', token);
}
}).error(function(msg){
    console.log(msg.responseText);
})
.done(function( msg ) {
    console.log( msg );
});


 */

try {
    AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    if(php_sapi_name() !== 'cli') {
        //Boot MVC
        new Boot( new Mvc() );
    }
    else {
        //Boot cli
    }

    new Boot( new Boot\Requirements() );

} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    \LibreMVC\Http\Header::serverError();
    \LibreMVC\Views\Template\ViewBag::get()->exception = $e;
    include('error500.php');
}

