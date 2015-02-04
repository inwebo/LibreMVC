<?php
use LibreMVC\Database\Driver\MySql;
use LibreMVC\Modules\AuthUser\Models\AuthUser;
use LibreMVC\Files\Config;
registerModule();
$file = getModule('authuser')->getPath()->getBaseDir('config');
$config = Config::load($file);
$driver = new MySql(
    $config->Database["server"],
    $config->Database["database"],
    $config->Database["user"],
    $config->Database["password"]
);
AuthUser::binder($driver,'id','Users');