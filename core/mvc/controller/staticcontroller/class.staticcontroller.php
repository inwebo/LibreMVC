<?php
namespace LibreMVC\Mvc\Controller {

    use LibreMVC\Http\Request;
    use LibreMVC\Mvc\Controller;
    use LibreMVC\System;
    use LibreMVC\View;
    use LibreMVC\View\Template;

    class StaticController extends Controller {

        use Controller\Traits\StaticView;

        public function __construct(Request $request, View $view, $baseDir) {
            parent::__construct($request,$view);
            $this->_baseDir = $baseDir;
        }
    }
}