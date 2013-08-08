<?php
namespace LibreMVC\Views\Template;

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
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Parser de fichier template.
 * 
 * Création des constantes nécessaire à l'application.
 * Ouverture du fichier template.
 * Affichage du contenu
 * 
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
class Parser {

    /**
     * Contient l'ensemble des erreurs de l'application.
     * @static
     * @var array
     */
    static public $trace = array();

    /**
     * Collection de tâches à effectuer.
     * @var SplObjectStorage
     */
    public $tasks;

    /**
     * Objet template courante
     * @var object
     */
    public $template;

    /**
     * Le contenu traité de l'objet courant doit il être
     * affiché à la destruction de l'objet.
     * @var bool 
     */
    public $autoRender = false;
    
    /**
     * Ensemble des patterns PCRE de l'application. Deviendront des CONSTANTES
     * @var array
     */
    public $constantes = array(
        "PATTERN_NO_PARSE" => "#\{noparse\}(.*){/noparse\}#ismU",
        "PATTERN_LOOP" => '#\{loop={1}"{1}\$([a-z]*)"}(.*)\{{1}\/loop\}{1}#ismU',
        "PATTERN_VAR" => '#\{\$([aA-zZ_]*)\}#',
        'PATTERN_CONST' => '#\{([A-Z_]*)\}#',
        'PATTERN_INCLUDE' => '#\{include="([aA-zZ.]*)"\}#',
        'PATTERN_TPL' => '#\{tpl="([aA-zZ\.0-9]*)"\}#',
        'PATTERN_IF' => '#\{if "([aA-zZ0-9<!=>{$}]*)"\}(.*)\{else\}(.*)\{fi\}#ismU',
        'PATTERN_DIF' => '#(!=)[^=!<>]#',
        'PATTERN_EQ' => '#[^!<>=](==){1}[^!<>=]#',
        'PATTERN_SEQ' => '#[^!<>=](===)[^!<>=]#',
        'PATTERN_SGT' => '#(>){1}[^<>!=]#',
        'PATTERN_SLT' => '#(<){1}[^<>!=]#',
        'PATTERN_GET' => '#[^<>!=](>=)[^<>!=]#',
        'PATTERN_SDIF' => '#(!==)[^=!<>]#',
        'PATTERN_LET' => '#[^<>!=](<=)[^<>!=]#',
        //'PATTERN_HREF' => '#<a href=\\"(.*)\">#U'
    );

    /**
     * Lecture du contenu du fichier template. Création de l'ensemble des consta
     * ntes de l'application
     * @param string $templateFile Le chemin d'accés à un fichier template.
     */
    public function __construct($templateFile) {
        try {
            $this->template = new \LibreMVC\Views\Template($templateFile);
        } catch (\Exception $e) {
            echo $e->getMessage();
            throw new \Exception('');
        }
        $this->define();
        $this->tasks = new \LibreMVC\Views\Template\Task\TasksTag();
        $this->process();
    }

    /**
     * Definition des constantes nécessaires.
     */
    protected function define() {
        foreach ($this->constantes as $key => $value) {
            (!defined($key) ) ? define($key, $value) : null;
        }
    }

    /**
     * Ajoute un tâche à la liste des tâches.
     *
     * @param Task $task Un objet Task
     */
    public function attach(Task $task) {
        $this->tasks->attach($task);
    }

    /**
     * Parse les balises utilisateurs et les remplace par le résultat d'une regex
     */
    public function process() {
        $this->tasks->rewind();
        // Pour chaque tache contenue dans la file d'attente des taches.
        // On execute une fonction preg_replace avec comme callback la methode
        // process d'un objet Logic sur le contenu courant du template.
        while ($this->tasks->valid()) {
            $this->template->content = preg_replace_callback(
                                        $this->tasks->current()->tags->pattern,
                                        // Astuce pour l'acces a une methode
                                        // d'objet dans un callback.
                                        // array( Objet, methode )
                                        array( $this->tasks->current()->logic, 'process'),
                                        $this->template->content );
            $this->tasks->next();
        }

    }
    
    public function getContent( $toString = false ) {
        if ($toString) {
            return $this->template->content;
        }
        else {
            echo $this->template->content;
        }
    }


    static public function render( $file, $toString = false ) {
        try {
            $parser = new self( $file );
            return $parser->getContent( $toString );
        }
        catch ( \Exception $e ) {
            //echo $e->getMessage();
            //throw new \Exception('');
        }

    }
    
    public function __destruct() {
        ( $this->autoRender ) ? $this->getContent() : null;
    }

}
