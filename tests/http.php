<?php
ini_set('display_errors', 'on');
include('../core/http/autoload.php');

use LibreMVC\Url;
use LibreMVC\Http\Request;

var_dump(Url::getVerb());
var_dump(Url::getUrl());
var_dump(Url::getServer());
var_dump(Url::getUri());
var_dump(Url::get());

var_dump(assert(Url::getVerb() === "GET"));
var_dump(assert(Url::getServer() === "http://localhost"));
var_dump(assert(Url::getServer(false) === "localhost"));
var_dump(assert(Url::getServer(false,true) === "localhost/"));

$request = Request::this(Url::get(false,true));

var_dump($request);
var_dump($request->getHeaders());

