<?php
ini_set('display_errors', 'on');
include('../core/system/boot/autoload.php');
include('../core/system/class.system.php');

use LibreMVC\System\Boot;

new Boot( new Boot\Requirements() );

// Fancy
include('../core/http/autoload.php');
include('../core/web/instance/autoload.php');

new Boot( new Boot\MVC() );
use LibreMVC\System;

var_dump(System::this());
