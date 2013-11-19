<?php
namespace LibreMVC\Helpers;

use Closure;
use Exception;

class BenchmarkCallBackException extends Exception{}

/**
 * Simple benchmark.
 * 
 * @category   LibreMVC
 * @package    Helpers
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/LibreMVC/blob/master/core/helpers/benchmark/class.benchmark.php
 * @author     Inwebo
 */
class Benchmark {

    /**
     * @var int Nombre d'itération du benchmark.
     */
    protected $iterations;

    /**
     * @var Closure Une fonction anonyme avec comme corps de function le code à tester.
     */
    protected $callback;

    /**
     * @var float Timestamp de départ.
     */
    protected $timeStart;

    /**
     * @var float Timestamp de fin.
     */
    protected $timeEnd;

    /**
     * @var float Durée total d'execution en seconde.
     */
    protected $elapsedTime;

    /**
     * @var int Empreinte mémoire avant execution.
     */
    protected $memoryStart;

    /**
     * @var int Empreinte mémoire total des tests.
     */
    protected $memory;

    /**
     * @param $iterations int Nombre d'itération du benchmark
     * @param $callback \Closure Une fonction anonyme avec comme corps de function le code à tester
     * @throws \BenchmarkCallBackException Si le callback n'est pas une closure valide.
     */
    public function __construct( $iterations, $callback ) {
        $this->memoryStart = memory_get_usage();
        $this->iterations = $iterations;
        $this->callback   = $callback;
        $this->timeStart = self::getCleanMicrotime();
        // Est une closure valide.
        if( is_object($this->callback) && ($this->callback instanceof \Closure)){
            $this->start();
        }
        else {
            throw new \BenchmarkCallBackException('Callback is not a closure a valid closure.');
        }
    }

    /**
     * @return float Secondes sans la timestamp.
     */
    static protected function getCleanMicrotime() {
        return explode(' ', microtime())[0];
    }

    protected function nanoSecondesToSeconde( $floatToString = true ) {
        $result = $this->elapsedTime;
        // Est un exposant
        if(strpos($result,'E') && $floatToString) {
            $buffer = explode('E', $result);
            /*
             * Se lit de droite a gauche
             * Récupération de la valeur absolue de l'exposant auquel on ajout 1 ( pour le futur point), on peuple un tableau
             * avec des char 0. Puis le retourne sous forme de chaine de caractères.
             */
            $return = implode('', array_fill(0,abs($buffer[1])+1,'0'));
            // Une chaine est également un tableau
            $return[1] = ".";
            $result = $return . str_replace('.','',$buffer[0]);
        }
        return $result;
    }

    protected function start() {
        $loop = $this->iterations;
        $args = func_get_args( $this->callback );
        var_dump($args);
        while( --$loop >= 0  ) {
            if( count($args) > 0 ) {
                call_user_func_array($this->callback, $args);
            }
            else {
                $this->callback->__invoke();
            }
        }
        $this->timeEnd =  self::getCleanMicrotime();
        //Hack pour les résultats negatifs. Fausse les résultats d'une nanoseconde.
        //time_nanosleep( 0, 1 );
        $this->elapsedTime = $this->timeEnd - $this->timeStart;
        $this->memory      = memory_get_usage() - $this->memoryStart;
    }

    /**
     * @param $floatToString bool
     * @return float|string
     */
    public function getElapsedTime( $floatToString = true) {
        return $this->nanoSecondesToSeconde($floatToString);
    }

    /**
     * @return int Empreinte mémoire en octet
     */
    public function getMemoryUsage() {
        return $this->memory;
    }

    /**
     * @param $iterations
     * @param $callback
     * @return Benchmark
     */
    static public function bench( $iterations, $callback ) {
        return new self( $iterations, $callback );
    }
}
