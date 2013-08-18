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
        $loop = $this->iterations;
        while( --$loop >= 0  ) {
            $this->callback->__invoke();
        }
        $this->timeEnd     = microtime();
        $this->timeElapsed = $this->timeEnd - $this->timeStart;
        $this->memory      = memory_get_usage() - $this->memoryStart;
    }

    public function getResult() {
        return $this->timeElapsed;
    }

    public function getMemoryUsage($unit = 'o') {
        switch( strtolower($unit)) {
            default:
            case 'o':
                return $this->memory;
                break;
            case 'ko':
                return $this->int2Size($this->memory);
                break;
            case 'mo':
                return ceil($this->memory / (1024*2));
                break;
        }

    }

    protected function int2Size($i, $b=1024){
        $o=$i%1024;
        $k=(int)(($i/$b)%$b);
        $m=(int)(($i/$b/$b)%$b);
        $g=(int)(($i/$b/$b/$b));
        return (($g!=0)?($g.' Go '.$m.' Mo '.$k.' Ko '.$o.' o'):($m!=0)?($m.' Mo '.$k.' Ko '.$o.' o'):(($k!=0)?$k.' Ko '.$o.' o':$o.' o'));
    }


    static public function bench( $iterations, $callback ) {
        return new self( $iterations, $callback );
    }
}
