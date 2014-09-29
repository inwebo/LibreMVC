<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 04/08/13
 * Time: 17:11
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Helpers;



class Log {

    /**
     * @var array Current log system
     */
    public $buffer;

    /**
     * @param null|array $array If null new buffer else load array $array
     */
    public function __construct( $array = null ) {
        $this->buffer = ( is_array($array) ) ? $array : array() ;
        $this->startIndex( $this->buffer );
    }

    /**
     * @param $array array input array
     * @param $index int Start array index
     * @return array Reordered array starting at index $index
     */
    private static function startIndex( $array, $index = 1 ) {
        $temp 		= array();
        $compteur 	= $index;
        foreach( $array as $key => $value ) {
            $temp[ $compteur ] = trim( $value );
            ++$compteur;
        }
        return $temp;
    }

    /**
     * @param $lineNumber
     * @return null
     */
    public function getLine( $lineNumber ) {
        return ( $this->isLine( $lineNumber ) ) ? $this->buffer[ $lineNumber ] : null ;
    }

    /**
     * @param $lineNumber
     * @param $text
     * @return bool
     */
    public function updateLine( $lineNumber, $text ) {
        if( $this->isLine( $lineNumber ) ) {
            $this->buffer[ $lineNumber ] = utf8_encode( $text );
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Add $text line to specified index line.
     *
     * @param $text
     * @param null $at
     * @param string $flag
     */
    public function addLine( $text, $at = NULL, $flag = 'last' ) {
        if( $at < $this->getTotalLines() && $at > $this->getTotalLines() && !is_null($at) ) {
            trigger_error( __CLASS__ . ' : Not in ragne line');
        }
        switch ( strtolower($flag) ) {
            default:
            case 'last':
                array_push( $this->buffer, $text );
                break;

            case 'first':
                array_unshift( $this->buffer, $text );
                break;

            case 'prev':
                $left  = array_slice( $this->buffer, 0, $at - 1 );
                $right = array_slice( $this->buffer, $at - 1 );
                array_push( $left, $text );
                $this->buffer = array_merge( $left,$right );
                break;

            case 'next':
                $left = array_slice( $this->buffer,0, $at );
                $right = array_slice( $this->buffer, $at );
                array_push( $left, $text );
                $this->buffer = array_merge( $left,$right );
                break;
        }
        $this->buffer = $this->startIndex( $this->buffer );
    }

    /**
     * Supprime la ligne $lineNumber
     *
     * @param $lineNumber
     * @return bool
     */
    public function delLine( $lineNumber ) {
        if( $this->isLine( $lineNumber ) ) {
            unset( $this->buffer[ $lineNumber ] );
            $this->buffer = $this->startIndex( $this->buffer );
            return TRUE;
        }
        else {
            return FALSE;
        }

    }

    /**
     * Reset du buffer
     *
     * @arguments  VOID
     *
     *
     * @return     VOID
     */
    public function reset() {
        $this->buffer = '';
    }

    /**
     * Count all buffer lines
     *
     * @arguments VOID
     *
     * @return INT total lines
     */
    public function getTotalLines() {
        return count( $this->buffer );
    }

    /**
     * Buffer size, octets unit.
     *
     * @arguments  VOID
     *
     * @return     INT
     */
    public function getBufferSize() {
        return mb_strwidth($this->__toString());
    }

    public function toArray() {
        return $this->buffer;
    }

    /**
     * Is a valid line number
     *
     * @param $int
     * @return bool
     */
    private function isLine( $int ) {
        return ( $int > $this->getTotalLines() );
    }

    /**
     * Display buffer
     *
     * @arguments  VOID
     *
     * @return STRING
     */
    public function __toString() {
        return implode( PHP_EOL, $this->buffer );
    }
}