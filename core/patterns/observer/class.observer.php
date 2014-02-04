<?php

namespace LibreMVC\System;

use LibreMVC\System\Boot\Task;

class Observer implements \SplObserver{

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

        new Task( "First observable", $this );
        new Task( "Second observable", $this );
        new Task( "Third observable", $this );
    }

    public function update( \SplSubject $subject ) {
        return true;
    }

}