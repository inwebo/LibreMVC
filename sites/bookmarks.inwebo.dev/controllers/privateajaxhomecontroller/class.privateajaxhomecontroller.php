<?php
namespace LibreMVC\Controllers {

    use LibreMVC\Exception;
    use LibreMVC\Mvc\Controller\AjaxController\PrivateAjaxController;
    use LibreMVC\Mvc\Controller\AuthController;
    use LibreMVC\Mvc\Controller\Traits\System;
    use LibreMVC\Http\Request;
    use LibreMVC\Mvc\Controller\UnauthorizedException;
    use LibreMVC\View;
    use LibreMVC\Modules\AuthUser\Models\AuthUser;
    use LibreMVC\System as SystemDataProvider;

    class PrivateAjaxHomeController extends PrivateAjaxController{}
}