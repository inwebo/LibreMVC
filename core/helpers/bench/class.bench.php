<?php


/**
 * Simple benchmark d'expression régulière
 * 
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @static
 */
class Benchmark {

    protected $iterations;
    protected $callback;
    protected $timeStart;
    protected $timeEnd;
    protected $timeElapsed;
    protected $memoryStart;
    protected $memory;

    public function __construct( $iterations, $callback ) {
        $this->memoryStart = memory_get_usage();
        $this->iterations = $iterations;
        $this->callback   = $callback;
        $this->timeStart = microtime();
        $this->start();
    }

    protected function start() {
        $this->memory      = memory_get_usage() - $this->memoryStart;
        while( --$this->iterations >= 0  ) {
            $this->callback->__invoke();
        }
        $this->timeEnd     = microtime();
        $this->timeElapsed = $this->timeEnd - $this->timeStart;
    }

    public function getResult() {
        return $this->timeElapsed;
    }

    public function getMemoryUsage() {
        return $this->memory;
    }

    static public function bench( $iterations, $callback ) {
        return new self( $iterations, $callback );
    }
}
