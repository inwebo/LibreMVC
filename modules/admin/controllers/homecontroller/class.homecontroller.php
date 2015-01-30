<?php

namespace LibreMVC\Modules\Admin\Controllers {
    use LibreMVC\System;
    use LibreMVC\Routing\RoutesCollection;

    class HomeController extends AdminController{
        public function routesAction() {
            $this->toView("routed", System::this()->routed);
            $this->toView("routes", RoutesCollection::get("default"));
            $this->render();
        }
    }
}