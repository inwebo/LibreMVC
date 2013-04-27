<?php
namespace LibreMVC\Views\Template\Task;

use LibreMVC\Views\Template\Task as Task;
use LibreMVC\Views\Template\Tag as Tag;

/**
 * Collection de tâches.
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
class TasksComparison extends \SplObjectStorage {

    /**
     * Setter des tâches de recherche des opérateurs de comparaison de bases
     */
    public function __construct($logic) {
        $this->attach(new Task(new Tag(PATTERN_DIF), $logic));
        $this->attach(new Task(new Tag(PATTERN_SDIF), $logic));
        $this->attach(new Task(new Tag(PATTERN_EQ), $logic));
        $this->attach(new Task(new Tag(PATTERN_SEQ), $logic));
        $this->attach(new Task(new Tag(PATTERN_SGT), $logic));
        $this->attach(new Task(new Tag(PATTERN_SLT), $logic));
        $this->attach(new Task(new Tag(PATTERN_GET), $logic));
        $this->attach(new Task(new Tag(PATTERN_LET), $logic));
    }

}
