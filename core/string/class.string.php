<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 02/10/14
 * Time: 21:39
 */

namespace LibreMVC;


class String {

    /**
     * Replace string arrays by string arrays.
     *
     * @param $subject String Input string
     * @param $patterns Array Patterns to search for.
     * @param $replacement Array Replacement values.
     * @return mixed
     */
    static public function replace($subject, $patterns, $replacement) {
        $buffer = $subject;
        $j = -1;
        if( is_array($patterns) && is_array($replacement) ) {
            while( isset( $patterns[++$j] ) && isset( $replacement[$j] ) ) {
                $buffer = str_replace( $patterns[$j], $replacement[$j], $buffer );
            }
        }
        return $buffer;
    }

} 