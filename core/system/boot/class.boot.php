<?php

namespace LibreMVC\Core\System;

use LibreMVC\Core\System\Boot\Task as Task;

class Boot implements \SplObserver{

    public $tasks;

    public function __construct() {
        $this->tasks = new \SplObjectStorage();
        // Construction context http

        // Constantes environnements

        // Chargement ini

        // Erreur handler

        // Db

        // Routing

        // Invokable

        // Is cli

        // View

        new Task( "First task", $this );
        new Task( "Second task", $this );
        new Task( "Third task", $this );
    }

    public function update( \SplSubject $subject ) {
        return true;
    }

}