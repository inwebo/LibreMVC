<?php

namespace LibreMCV\System;

// Sale mais obligatoire a ce stade les classes declarees sont vide

/**
 * Class Boot
 *
 * Recoit un objet disposant de methodes static public. Elles seront ececutees consecutivement dans l'ordre d'appararition
 * dans le fichier declarant l'objet.
 *
 * @package LibreMVC\System
 */
class Boot {

    protected $_steps;

    public function __construct( $steps ) {
        if( is_object( $steps ) ) {
            $this->_steps = $steps;
            $this->start();
        }
        else {
            throw new \Exception( __CLASS__ . ' must have valid callback object');
        }
    }

    /**
     * Process each steps
     */
    public function start() {
        $methods = get_class_methods( $this->_steps );
        foreach( $methods as  $member ) {
                 $reflectAssertions = new \ReflectionMethod( $this->_steps, $member );
                 $reflectAssertions->invoke( $member );
        }
    }

}