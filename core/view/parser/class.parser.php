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
use LibreMVC\View\Task\TasksCollection\BaseTags;

class Parser {

    public $tasksCollection;

    public $dataProvider;

    public $template;

    public $autoRender;

    /**
     * Lecture du contenu du fichier template. Création de l'ensemble des constantes de l'application
     */
    public function __construct(Template $template, ViewObject $dataProvider, $autoRender = false) {
        try {
            $this->template = $template;
            $this->dataProvider = $dataProvider;
            $this->autoRender = $autoRender;
        } catch (\Exception $e) {
            var_dump($e);
        }
        $this->tasksCollection = new BaseTags( $this->dataProvider );
        $this->process();
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
    /**
     *
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

    public function getContent() {
        return $this->template->get();
    }

    public function __toString() {
        return $this->template->get();
    }

    public function __destruct() {
        if($this->autoRender) {
            echo $this;
        }
        else {
            return $this->getContent();
        }
    }

}
