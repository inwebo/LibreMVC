<?php

namespace LibreMVC\System\Boot\Tasks {

    use LibreMVC\System\Boot\Tasks\Task\Init;
    use LibreMVC\System\Boot\Tasks;
    use LibreMVC\System\Boot\Tasks\Task\Paths;
    use LibreMVC\System\Boot\Tasks\Task\Instance;
    use LibreMVC\System\Boot\Tasks\Task\Modules;
    use LibreMVC\System\Boot\Tasks\Task\Layout;
    use LibreMVC\System\Boot\Tasks\Task\Router;
    use LibreMVC\System\Boot\Tasks\Task\Exceptions;
    use LibreMVC\System\Boot\Tasks\Task\FrontController;
    use LibreMVC\System\Boot\Tasks\Task\Session;
    use LibreMVC\System\Boot\Tasks\Task\Themes;
    use LibreMVC\System\Boot\Tasks\Task\Body;

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
            // Load config file
            $this->attach(new Init($config));
            // Prepare whole app paths
            $this->attach(new Paths());
            // Choose instance
            $this->attach(new Instance());
            // Load modules
            $this->attach(new Modules());
            // Load assets
            $this->attach(new Themes());
            // Prepare User
            $this->attach(new Session());
            // Prepare main View layout
            $this->attach(new Layout());
            // Routing
            $this->attach(new Router());
            // Prepare body partial
            $this->attach(new Body());
            // Controller factory
            $this->attach(new FrontController());
            // Exception System
            $this->attach(new Exceptions());
        }
    }
}