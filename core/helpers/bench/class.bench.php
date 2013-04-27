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
class Bench {

    /**
     * Applique une expression régulière sur un sujet et retourne le temps mis
     * pour l'effectué n fois.
     * 
     * @param array $pattern Un tableau d'expressions régulière.
     * @param string $subject La chaine
     * @param int $loop Nombre de boulce à faire
     */
    public static function Pattern($pattern, $subject, $loop = 200) {
        $results = array();
        foreach ($pattern as $pattern) {
            $timeStart = microtime(true);
            $nbLoops = $loop;
            while ($nbLoops--) {
                preg_match($pattern, $subject);
            }
            $results[$pattern] = number_format(microtime(true) - $timeStart, 5);
        }
        asort($results, SORT_NUMERIC);
        self::Results($results);
    }

    /**
     * Affichage des résultats du benchmark par ordre croissant de durée
     * d'execution. Le résultat le plus rapide sera l'étalon 100%.
     * 
     * @param array $arrayResults Un tableau de temps d'execution d'expression
     * regulière.
     */
    public static function Results($arrayResults) {
        $first = $arrayResults;
        $shortest = array_shift($first);
        $memoryStart = memory_get_usage();
        $buffer = "<ol>";
        foreach ($arrayResults as $key => $value) {
            $buffer .= '<li>[' . self::Delta($shortest, $value) . '% - ' . $value . ' s ] : ' . $key . ' </li>';
        }
        $buffer .= "</ol>";
        echo memory_get_usage() - $memoryStart . " O";
        echo $buffer;
    }

    public static function Delta($shortest, $test) {
        if ($shortest > 0) {
            return round($test * 100 / $shortest);
        }
    }

}
