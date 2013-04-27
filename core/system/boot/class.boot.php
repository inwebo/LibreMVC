<?php

namespace LibreMVC\System;

use LibreMVC\System\Boot\Task as Task;

class Boot implements \SplObserver{

    public $tasks;

    public function __construct() {
        $this->tasks = new \SplObjectStorage();
        new Task( "First task", $this );
        new Task( "Second task", $this );
        new Task( "Third task", $this );
    }

    public function update( \SplSubject $subject ) {
        echo $subject->name, " Ok<br>";
    }

}