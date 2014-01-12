<?php
namespace LibreMVC\View\Task\TaskCollection;

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

use LibreMVC\View\Task;
use LibreMVC\View\Parser\Tag;
use LibreMVC\View\Parser\Logic\Conditions;
use LibreMVC\View\Parser\Logic\Constant;
use LibreMVC\View\Parser\Logic\Escapement;
use LibreMVC\View\Parser\Logic\Includer;
use LibreMVC\View\Parser\Logic\Loop;
use LibreMVC\View\Parser\Logic\Template;
use LibreMVC\View\Parser\Logic\Vars;

class BaseTags extends \SplObjectStorage {

    protected $dataProvider;

    /**
     * Setter des tâches de recherche des tags de bases
     */
    public function __construct( $dataProvider ) {

        $this->dataProvider = $dataProvider;

        // No parse pattern {noparse}{/noparse}
        $this->attach( new Task( new Tag(PATTERN_NO_PARSE), new Escapement($this->dataProvider)) );

        // Loop pattern {loop="array"}{/loop}
        $this->attach( new Task( new Tag(PATTERN_LOOP), new Loop($this->dataProvider) ) );

        // If pattern {if="condition"}true{else}false{fi}
        $this->attach( new Task( new Tag(PATTERN_IF), new Conditions($this->dataProvider) ) );

        // variable pattern {$vars}
        $this->attach( new Task( new Tag(PATTERN_VAR), new Vars($this->dataProvider) ) );

        // Constante pattern {CONSTANTE}
        $this->attach( new Task( new Tag(PATTERN_CONST), new Constant($this->dataProvider) ) );

        // Include pattern {includer="fileToInclude"}
        $this->attach( new Task( new Tag(PATTERN_INCLUDE), new Includer($this->dataProvider) ) );

        // Tpl pattern {tpl="tplToInclude"}
        $this->attach( new Task( new Tag(PATTERN_TPL), new Template($this->dataProvider) ) );

        // Href
        //$this->attach(new \LibreMVC\Views\Template\Task(new \LibreMVC\Views\Template\Tag(PATTERN_HREF), new \LibreMVC\Views\Template\Logic\LogicHref()));
    }

}
