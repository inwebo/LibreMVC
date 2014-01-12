<?php
namespace LibreMVC\View;

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

use LibreMVC\View\Template;
use LibreMVC\View\Task\TaskCollection\BaseTags;

class Parser {

    /**
     * Contient l'ensemble des erreurs de l'application.
     * @static
     * @vars array
     */
    public $trace = array();

    /**
     * Collection de tâches à effectuer.
     * @vars SplObjectStorage
     */
    public $tasksCollection;

    public $dataProvider;

    /**
     * Objet template courante
     * @vars object
     */
    public $template;

    /**
     * Le contenu traité de l'objet courant doit il être
     * affiché à la destruction de l'objet.
     * @vars bool
     */
    public $autoRender = false;
    
    /**
     * Ensemble des patterns PCRE de l'application. Deviendront des CONSTANTES
     * @vars array
     */
    public $constants = array(
        "PATTERN_NO_PARSE"  => '#\{noparse\}(.*)\{/noparse\}#ismU',
        'PATTERN_CONST'     => '#\{([A-Z_]*)\}#',
        "PATTERN_LOOP"      => '#\{loop={1}"{1}\$([a-z]*)"}(.*)\{{1}\/loop\}{1}#ismU',
        "PATTERN_VAR"       => '#\{\$([aA-zZ_]*)\}#',
        //@todo : A affiner
        'PATTERN_INCLUDE'   => '#\{include="(.*)"\}#',
        'PATTERN_TPL'       => '#\{tpl="(.*)"\}#',

        'PATTERN_IF'        => '#\{if "([aA-zZ0-9<!=>{$}]*)"\}(.*)\{else\}(.*)\{fi\}#ismU',
        'PATTERN_DIF'       => '#(!=)[^=!<>]#',
        'PATTERN_EQ'        => '#[^!<>=](==){1}[^!<>=]#',
        'PATTERN_SEQ'       => '#[^!<>=](===)[^!<>=]#',
        'PATTERN_SGT'       => '#(>){1}[^<>!=]#',
        'PATTERN_SLT'       => '#(<){1}[^<>!=]#',
        'PATTERN_GET'       => '#[^<>!=](>=)[^<>!=]#',
        'PATTERN_SDIF'      => '#(!==)[^=!<>]#',
        'PATTERN_LET'       => '#[^<>!=](<=)[^<>!=]#',
        //'PATTERN_HREF' => '#<a href=\\"(.*)\">#U'
    );

    /**
     * Lecture du contenu du fichier template. Création de l'ensemble des constantes de l'application
     */
    public function __construct(Template $template, ViewObject $dataProvider) {
        try {
            //$this->template = new Template($templateFile);
            $this->template = $template;
            $this->dataProvider = $dataProvider;
        } catch (\Exception $e) {
            var_dump($e);
        }
        $this->define();
        $this->tasksCollection = new BaseTags( $this->dataProvider );
        $this->process();
    }

    /**
     * Definition des constantes nécessaires.
     */
    protected function define() {
        foreach ($this->constants as $key => $value) {
            (!defined($key) ) ? define($key, $value) : null;
        }
    }

    /**
     * Ajoute un tâche à la liste des tâches.
     *
     * @param Task $task Un objet Task
     */
    public function attach(Task $task) {
        $this->tasksCollection->attach($task);
    }

    /**
     * Parse les balises utilisateurs et les remplace par le résultat d'une regex
     */
    public function process() {
        $this->tasksCollection->rewind();
        // Pour chaque tache contenue dans la file d'attente des taches.
        // On execute une fonction preg_replace avec comme callback la methode
        // process d'un objet Logic sur le contenu courant du template.
        while ($this->tasksCollection->valid()) {
            $this->template->set( preg_replace_callback(
                                        $this->tasksCollection->current()->getTag()->getPattern(),
                                        // Snippet pour l'acces a une methode
                                        // d'objet dans un callback.
                                        // array( Objet, methode )
                                        array( $this->tasksCollection->current()->getLogic()->get(), 'process'),
                                        $this->template->get() ) );
            $this->tasksCollection->next();
        }

    }
    
    public function getContent( $toString = false ) {
        if ($toString) {
            return $this->template->get();
        }
        else {
            echo $this->template->get();
        }
    }

    public function __destruct() {
        ( $this->autoRender ) ? $this->getContent() : null;
    }

}
