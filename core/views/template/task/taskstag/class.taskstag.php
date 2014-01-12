<?php
namespace LibreMVC\Views\Template\Task;

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

use LibreMVC\Views\Template;
use LibreMVC\Views\Template\Logic;
use LibreMVC\Views\Template\Logic\LogicComparison;
use LibreMVC\Views\Template\Logic\LogicConst;
use LibreMVC\Views\Template\Logic\LogicIf;
use LibreMVC\Views\Template\Logic\LogicInclude;
use LibreMVC\Views\Template\Logic\LogicLoop;
use LibreMVC\Views\Template\Logic\LogicNoparse;
use LibreMVC\Views\Template\Logic\LogicTpl;
use LibreMVC\Views\Template\Logic\LogicVar;
use LibreMVC\Views\Template\Parser;
use LibreMVC\Views\Template\Tag;
use LibreMVC\Views\Template\Task;
use LibreMVC\Views\Template\Task\TaskComparison;
use LibreMVC\Views\Template\ViewBag;

class TasksTag extends \SplObjectStorage {

    /**
     * Setter des tâches de recherche des tags de bases
     */
    public function __construct() {
        // No parse pattern {noparse}{/noparse}
        $this->attach( new Task( new Tag(PATTERN_NO_PARSE), new LogicNoParse()) );
        // Loop pattern {loop="array"}{/loop}
        $this->attach( new Task( new Tag(PATTERN_LOOP), new LogicLoop() ) );
        // If pattern {if="condition"}true{else}false{fi}
        $this->attach( new Task( new Tag(PATTERN_IF), new LogicIf() ) );
        // variable pattern {$vars}
        $this->attach( new Task( new Tag(PATTERN_VAR), new LogicVar() ) );
        // Constante pattern {CONSTANTE}
        $this->attach( new Task( new Tag(PATTERN_CONST), new LogicConst() ) );
        // Include pattern {includer="fileToInclude"}
        $this->attach( new Task( new Tag(PATTERN_INCLUDE), new LogicInclude() ) );
        // Tpl pattern {tpl="tplToInclude"}
        $this->attach( new Task( new Tag(PATTERN_TPL), new LogicTPL() ) );
        // Href
        //$this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_HREF), new \LibreMVC\Views\Template\Logic\LogicHref()));
    }

}
