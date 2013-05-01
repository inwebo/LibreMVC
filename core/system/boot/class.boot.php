<?php
namespace LibreMVC\System;

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
        // valider l'entree
        $this->_steps = $steps;
        $this->walk();
    }

    /**
     * Process each steps
     */
    public function walk() {
        $methods = get_class_methods($this->_steps);
        var_dump($methods);
        foreach( $methods as  $member ) {
                 $reflectAssertions = new \ReflectionMethod( $this->_steps, $member );
                 $reflectAssertions->invoke( $member );
        }
    }

}