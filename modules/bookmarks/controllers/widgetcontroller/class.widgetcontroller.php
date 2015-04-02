<?php
namespace LibreMVC\Modules\Bookmarks\Controllers {

    use LibreMVC\Http\Url;
    use LibreMVC\Mvc\Controller\AjaxController\PrivateAjaxController;
    use LibreMVC\Controllers\PrivateController;

    class WidgetController extends PrivateController{


        public function init() {
            parent::init();
            $this->setSystem(\LibreMVC\System::this());
        }

        public function bookmarkletAction() {
            $body = $this->getSystem()->getModule('bookmarks')->getStaticViews('dir') . self::getActionShortName('bookmarkletAction') . '.php';
            $bookmarklet = $this->getSystem()->getModule('bookmarks')->getJs("dir") . self::getActionShortName('bookmarkletAction') . '.js';
            $this->changePartial('body',$body);
            $this->getView()->getPartial('body')->attachPartial('bookmarklet',$bookmarklet);
            $this->toView('user', user()->login);
            $this->toView('publicKey', user()->publicKey);
            $this->toView('restService', Url::getServer(true,true) . 'form/');
            $this->render();
        }

    }

}