<?php
/**
 * http://php.net/manual/fr/closure.bind.php
 * http://php.net/manual/fr/closure.bindto.php
 * http://www.htmlist.com/development/extending-php-5-3-closures-with-serialization-and-reflection/
 */
namespace LibreMVC\System\Hooks\Temp {


    class Hook {
        /**
         * @var string
         */
        protected $_name;
        /**
         * @var \ArrayIterator
         */
        protected $_callbacks;

        public function __construct($name){
            $this->_name = $name;
            $this->_callbacks = new \ArrayIterator();
        }

        public function getName() {
            return $this->_name;
        }

        public function attachCallbacks(CallBack $callback, $priority = null) {
            if( !is_null($priority) ) {
                if( is_int($priority) && is_int($priority) > 0 ) {
                    if( !isset($this->_callbacks[$priority]) ) {
                        $this->_callbacks[$priority] = $callback;
                    }
                    else {
                        trigger_error("Priority already uesd !");
                    }
                }
            }
            else {
                $this->_callbacks[] = $callback;
            }

        }

        public function call() {
            $this->_callbacks->rewind();
            $buffer = array();
            while( $this->_callbacks->valid() ) {
                $reflection = new \ReflectionMethod($this->_callbacks->current(), '__invoke');
                $buffer[] = $reflection->invoke(
                    $this->_callbacks->current(),
                    $this->_callbacks->current()->getParameters()
                );
                $this->_callbacks->next();
            }
            return $buffer;
            //return $buffer[count($buffer)-1];
        }
    }

    class CallBack{

        protected $_closure;
        protected $_reflection;

        public function __construct(\Closure $closure){
            $this->_closure = $closure;
            $this->_reflection = new \ReflectionFunction($this->_closure);
        }

        public function __invoke() {
            $args = func_get_args();
            $this->_reflection->invokeArgs($args);
        }

        public function getParameters() {
            return $this->_reflection->getParameters();
        }

    }

    $base = "Hello world";
    echo 'Depart : '. $base . "<br>";

    $callback1 = function($a)use(&$base){
        echo var_dump($a);
        $base = "Bonjour le monde";
    };

    $callback2 = function()use(&$base){
        $base = "Ola el mundo";
    };

    $hook = new Hook('test');
    $hook->attachCallbacks(new CallBack($callback1));
    $hook->attachCallbacks(new CallBack($callback2));
    $hook->call();
    echo 'Fin : '.$base .'<br>';





    $base = "Test";
    $hook = new Hook('test2');
    $c = new CallBack(function($base){
        $base = "Fin" . $base[0];
    });

    $hook->attachCallbacks($c);
    $hook->call();
    echo $base .'<br>';
}