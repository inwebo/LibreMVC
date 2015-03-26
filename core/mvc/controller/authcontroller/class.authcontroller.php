<?php
namespace LibreMVC\Mvc\Controller {

    class UnauthorizedException extends \Exception {
        protected $code = 500;
        const MSG = 'Unautorised, please login !';
    }

    use LibreMVC\Modules\AuthUser\Models\AuthUser;
    use LibreMVC\Mvc\Controller;
    use LibreMVC\Http\Request;
    use LibreMVC\View;

    class AuthController extends ActionController{

        use Traits\Authentification;

        public function __construct( Request $request, View $view, AuthUser $authUser ) {
            $this->_request = $request;
            $this->_view    = $view;
            $this->setAuthUser($authUser);
            $this->init();
        }

    }
}