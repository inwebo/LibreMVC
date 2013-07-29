<?php
namespace LibreMVC\Views\Template\Task;
use LibreMVC\Views\Template as Template;
use LibreMVC\Views\Template\Logic as Logic;
use LibreMVC\Views\Template\Logic\LogicComparison as LogicComparison;
use LibreMVC\Views\Template\Logic\LogicConst as LogicConst;
use LibreMVC\Views\Template\Logic\LogicIf as LogicIf;
use LibreMVC\Views\Template\Logic\LogicInclude as LogicInclude;
use LibreMVC\Views\Template\Logic\LogicLoop as LogicLoop;
use LibreMVC\Views\Template\Logic\LogicNoparse as LogicNoparse;
use LibreMVC\Views\Template\Logic\LogicTpl as LogicTpl;
use LibreMVC\Views\Template\Logic\LogicVar as LogicVar;
use LibreMVC\Views\Template\Parser as Parser;
use LibreMVC\Views\Template\Tag as Tag;
use LibreMVC\Views\Template\Task as Task;
use LibreMVC\Views\Template\Task\TaskComparison as TaskComparison;
use LibreMVC\Views\Template\ViewBag as ViewBag;


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
class TasksTag extends \SplObjectStorage {

    /**
     * Setter des tâches de recherche des tags de bases
     */
    public function __construct() {
        // No parse pattern {noparse}{/noparse}
        $this->attach(new \LibreMVC\Views\Template\Task( new \LibreMVC\Views\Template\Tag(PATTERN_NO_PARSE), new \LibreMVC\Views\Template\Logic\LogicNoParse()) );
        // Loop pattern {loop="array"}{/loop}
        $this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_LOOP), new \LibreMVC\Views\Template\Logic\LogicLoop()));
        // If pattern {if="condition"}true{else}false{fi}
        $this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_IF), new \LibreMVC\Views\Template\Logic\LogicIf()));
        // variable pattern {$var}
        $this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_VAR), new \LibreMVC\Views\Template\Logic\LogicVar()));
        // Constante pattern {CONSTANTE}
        $this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_CONST), new \LibreMVC\Views\Template\Logic\LogicConst()));
        // Include pattern {include="fileToInclude"}
        $this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_INCLUDE), new \LibreMVC\Views\Template\Logic\LogicInclude()));
        // Tpl pattern {tpl="tplToInclude"}
        $this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_TPL), new \LibreMVC\Views\Template\Logic\LogicTPL()));
        // Href
        //$this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_HREF), new \LibreMVC\Views\Template\Logic\LogicHref()));
    }

}
