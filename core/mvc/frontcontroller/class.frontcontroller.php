<?php
namespace LibreMVC\Mvc {

    use LibreMVC\ClassNamespace;
    use LibreMVC\Http\Request;
    use LibreMVC\Modules\Error\Controllers\ErrorController;
    use LibreMVC\Mvc\Controller\ActionController;
    use LibreMVC\Mvc\Controller\StaticController;
    use LibreMVC\Mvc\FrontController\Decorator;
    use LibreMVC\Mvc\FrontController\Filter;
    use LibreMVC\Routing\Route;
    use LibreMVC\View;
    use LibreMVC\System;
    use LibreMVC\Mvc\Controller\AjaxController;


    class FrontControllerUnknownController extends \Exception {
        protected $code = 500;
        const MSG = 'Action, %s->%s() not found, add method : <cite>public function %s()&#123;&#125;</cite> to %s controller.';
    };

    class FrontControllerUnknownAction extends \Exception {
        protected $code = 500;
        const MSG = 'Action, %s->%s() not found, add method : <cite>public function %s()&#123;&#125;</cite> in %s file.';
    };

    class FrontControllerException extends \Exception {
        protected $code = 500;
        protected $message = 'FrontController decorators <cite>(filters)</cite> unknow, controller or action not found.';
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

        const DEFAULT_ACTION    = "index";
        const ACTION_SUFFIX     = "Action";

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

        public function decoratorsFilter() {
            $decorators = $this->getControllerDecorators();
            while($decorators->valid()) {
                $decorator = $decorators->current();
                if( $decorator->isTyped() ) {
                    if( $decorator->isValidController() ) {
                        if( $decorator->isValidAction() ) {
                            return $decorator;
                        }
                    }
                }
                $decorators->next();
            }
        }

        public function invoker() {
            $decorated  = $this->decoratorsFilter();
            try {
                if (!is_null($decorated)) {
                    switch ($decorated->getType()) {
                        case ActionController::getCalledClass():
                            return $decorated->factory(array(
                                System::this()->request,
                                System::this()->layout
                            ));
                            break;

                        case StaticController::getCalledClass():
                                return $decorated->factory(array(
                                    System::this()->request,
                                    System::this()->layout,
                                    $this->_system->instancePaths->getBaseDir('static_views')
                                ));
                            break;

                    }
                }
                /**
                 * Aucun controllers ne correspond
                 */
                else {
                    throw new FrontControllerException();
                }
            }
            catch(\Exception $e ) {
                throw $e;
            }
        }
    }
}