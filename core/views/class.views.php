<?php

namespace LibreMVC;

use LibreMVC\Views\Template\Parser;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Instance;
use LibreMVC\Http\Context;
use LibreMVC\Files\Config;
/**
 * LibreMVC
 *
 * LICENCE
 *
 * You are free:
 * to Share ,to copy, distribute and transmit the work to Remix —
 * to adapt the work to make commercial use of the work
 *
 * Under the following conditions:
 * Attribution, You must attribute the work in the manner specified by
 * the author or licensor (but not in any way that suggests that they
 * endorse you or your use of the work).
 *
 * Share Alike, If you alter, transform, or build upon
 * this work, you may distribute the resulting work only under the
 * same or similar license to this one.
 *
 *
 * @category  LibreMVC
 * @package   Views
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Conteneur global des variables nécessaire aux templates.
 * 
 * Singleton, permet d'éviter de polluer le namespace global avec les variables
 * des templates. C'est l'interface entre une vue & modéle. Toutes données qui
 * doivent être affichées devraient être définies dans le viewbag.
 * 
 * @category   LibreMVC
 * @package    Views
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
class Views {

    public function __construct() {

    }

    // @todo passer un id pour inclure le template dans une <div id="$id"></div>
    static public function render( $template ) {
        return Parser::render( $template );
    }

    // auto $template !
    // Reflection
    // Controller Methods
    // Avec la method on peux reconstruire le chemin
    static public function renderAction() {
        /**
         * Snippet
         * Recupere pile Appel LIFO
         */
        $debug = list(, $caller) = debug_backtrace(false);

        /**
         * - Creation contexte
         * - Execution par reflection du controller courant
         * - C'est le controller qui peuple le viewbag
         * - Rendu du fichier index.php de l'instance courante avec l'inclusion de la vue courante
         *   transmis par le ViewBag dans une partie reservee
         */
        // Methode Courante (avant derniere)

        array_shift($debug);
        $method = $debug[0]['function'];
        $method = str_replace('Action','',$method);
        $class = strtolower($debug[0]['class']);
        $class = join('', array_slice(explode('\\', $class), -1));
        $instance = new Instance( Context::getUrl() );
        $paths = $instance->processPattern( Config::load( "config/paths.ini" ), $class, $method );
        Environnement::this()->viewPath = $paths['base_view'] ;
        Parser::render($paths['base_index']);
    }

}