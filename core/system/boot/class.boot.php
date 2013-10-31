<?php

namespace LibreMVC\System;

// Sale mais obligatoire a ce stade les classes declarees sont vide

/**
 * Class Boot
 *
 * Recoit un objet disposant de methodes static public. Elles seront executees consecutivement dans l'ordre d'appararition
 * dans le fichier declarant l'objet.
 *
 * @package LibreMVC\System
 * @todo Oberver Observable ?
 */
class Boot {

    /**
     * @var object
     */
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
     * Process each mvc
     */
    public function start() {
        $members = get_class_methods( $this->_steps );
        foreach( $members as  $member ) {
                 $reflectAssertions = new \ReflectionMethod( $this->_steps, $member );
                 $reflectAssertions->invoke( $member );
        }
    }

}