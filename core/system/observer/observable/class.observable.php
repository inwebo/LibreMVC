<?php
namespace LibreMVC\Core\System\Observer;

class Observable implements \SplSubject{

    public $observers;
    public $name;

    public function __construct( $name, $observer ) {
        $this->observers = new \SplObjectStorage();
        $this->attach($observer);
        $this->name = $name;
        $this->notify();
    }

    public function attach(\SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notify() {
        $this->observers->rewind();
        while($this->observers->valid()) {
            $this->observers->current()->update($this);
            $this->observers->next();
        }
    }

}