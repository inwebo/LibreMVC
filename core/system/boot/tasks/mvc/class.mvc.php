<?php

namespace LibreMVC\System\Boot\Tasks {

    use LibreMVC\System\Boot\Tasks\Task\Init;
    use LibreMVC\System\Boot\Tasks;
    use LibreMVC\System\Boot\Tasks\Task\Paths;
    use LibreMVC\System\Boot\Tasks\Task\Instance;
    use LibreMVC\System\Boot\Tasks\Task\Modules;
    use LibreMVC\System\Boot\Tasks\Task\Layout;
    use LibreMVC\System\Boot\Tasks\Task\Router;
    use LibreMVC\System\Boot\Tasks\Task\Body;
    use LibreMVC\System\Boot\Tasks\Task\FrontController;
    use LibreMVC\System\Boot\Tasks\Task\Session;

    /**
     * Class MVC
     *
     * Collection de Tasks prédéfinies
     *
     * @package LibreMVC\Mvc\Tasks
     */
    class MVC extends Tasks {
        function __construct($config) {
            $this->_name = "MVC";
            $this->attach( new Init($config) );
            $this->attach( new Paths() );
            $this->attach( new Instance() );
            $this->attach( new Modules() );
            $this->attach( new Session() );
            $this->attach( new Layout() );
            $this->attach( new Router() );
            $this->attach( new Body() );
            $this->attach( new FrontController() );
        }
    }
}