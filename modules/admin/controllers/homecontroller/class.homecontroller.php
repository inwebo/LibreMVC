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

        public function modulesAction() {
            $modules = $this->_system->appPaths->getBaseDir('modules');
            $availableModules = glob($modules . '*');
            $buffer = array();
            foreach($availableModules as $k => $v) {
                $buffer[] = basename($v);
            }
            $this->toView('available', $buffer);

            $enabledModules = $this->_system->getModules();
            $this->toView('enabled', $enabledModules);
            $this->render();
        }
    }
}