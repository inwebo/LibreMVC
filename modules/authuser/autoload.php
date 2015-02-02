<?php
use LibreMVC\Database\Driver\MySql;
use LibreMVC\Modules\AuthUser\Models\AuthUser;
registerModule();
$driver = new MySql('localhost','UsersRoles','root','root');
AuthUser::binder($driver,'id','Users');