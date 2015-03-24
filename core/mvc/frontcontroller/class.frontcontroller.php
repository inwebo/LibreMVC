<?php
namespace LibreMVC\Mvc {

    use LibreMVC\ClassNamespace;
    use LibreMVC\Http\Request;
    use LibreMVC\Mvc\Controller\ActionController;
    use LibreMVC\Mvc\Controller\StaticController;
    use LibreMVC\Mvc\FrontController\Decorator;
    use LibreMVC\Mvc\FrontController\Filter;
    use LibreMVC\Routing\Route;
    use LibreMVC\View;
    use LibreMVC\System;
    use LibreMVC\Mvc\Controller\AjaxController;
    use LibreMVC\Exception;

    class FrontControllerUnknownController extends Exception {
        const MSG = 'Action, %s->%s() not found, add method : <cite>public function %s()&#123;&#125;</cite> to %s controller.';
    };

    class FrontControllerUnknownAction extends Exception {
        const MSG = 'Action, %s->%s() not found, add method : <cite>public function %s()&#123;&#125;</cite> in %s file.';
    };

    /**
     * Class Dispatcher (Distributeur)
     *
     * Recoit un objet Http\Request, une routes déjà routée ainsi qu'une vue, le frontcontroller doit permettre
     * l'instaciation de l'ActionController, appel de la methode d'action correspondante avec les bon paramètres.
     *
     * @todo : Devrait gérér les plugins.
     *
     * @package LibreMVC\Mvc
     */

    class FrontController {

        const DEFAULT_ACTION = "index";
        const ACTION_SUFFIX = "Action";

        //const CONTROLLER_TYPE_ACTION = 'LibreMVC\Mvc\Controller\ActionController';
        //const CONTROLLER_TYPE_ACTION = ActionController::getCalledClass();
        //const CONTROLLER_TYPE_ACTION_NAME = 'ActionController';
        //const CONTROLLER_TYPE_STATIC = 'LibreMVC\Mvc\Controller\StaticController';
        //const CONTROLLER_TYPE_STATIC_NAME = 'StaticController';

        /**
         * @var Request
         */
        protected $_request;
        /**
         * @var Route
         */
        protected $_route;
        /**
         * @var View
         */
        protected $_view;
        /**
         * @var mixed
         */
        protected $_controller;
        /**
         * @var System
         */
        protected $_system;
        /**
         * @var Route
         */
        protected $_defaultRoute;
        /**
         * @var \SplStack
         */
        protected $_controllerDecorators;

        public function __construct( Request $request, System $system ) {
            $this->_request             = $request;
            $this->_system              = $system;
            $this->_view                = $this->_system->this()->layout;
            $this->_route               = $this->_system->this()->routed;
            $this->_controllerDecorators= new \SplStack();
        }
        #region Helpers
        public function getAction() {
            return $this->_route->action . self::ACTION_SUFFIX;
        }
        public function getParams() {
            return $this->_route->params;
        }
        public function pushDecorator(Decorator $decorator) {
            $this->_controllerDecorators->push($decorator);
        }
        public function getControllerDecorators() {
            $this->_controllerDecorators->rewind();
            return $this->_controllerDecorators;
        }
        #endregion

        public function invoker() {
            $decorators = $this->getControllerDecorators();
            $decorated  = null;
            while($decorators->valid()) {
                $decorator = $decorators->current();
                if( $decorator->isTyped() ) {
                    if( $decorator->isValidController() ) {
                        if( $decorator->isValidAction() ) {
                            $decorated = $decorator;
                            //echo 'Valid action';
                        }
                        else {
                            // Action inconnues
                            //echo "Action inconnus";
                            //return;
                        }
                        //echo 'Valid controller';
                    }
                    else {
                        // Controller inconnus
                        //echo "Controller inconnus";
                        //return;
                    }
                    //echo "Type connus";
                }
                else {
                    // Type inconnus
                    //echo "Type inconnus";
                    //return;
                }

                $decorators->next();
            }
            try {
                if (!is_null($decorated)) {
                    switch ($decorated->getType()) {
                        case ActionController::getShortCalledClass():
                            return $decorated->factory(array(
                                System::this()->request,
                                System::this()->layout
                            ));
                            break;

                        case StaticController::getShortCalledClass():
                                return $decorated->factory(array(
                                    System::this()->request,
                                    System::this()->layout,
                                    $this->_system->instancePaths->getBaseDir('static_views')
                                ));
                            break;
                    }


                } else {

                }
            }
            catch(\Exception $e ) {
                var_dump($e);
                throw $e;
            }
        }
    }
}