<?php
namespace LibreMVC\Views\Template\Logic;

use LibreMVC\Views\Template;
use LibreMVC\Views\Template\Logic;
use LibreMVC\Views\Template\Logic\LogicLoop;
use LibreMVC\Views\Template\Logic\LogicVar;
use LibreMVC\Views\Template\Parser;
use LibreMVC\Views\Template\Task;
use LibreMVC\Views\Template\Task\TasksComparison;
use LibreMVC\Views\Template\ViewBag;

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
 * @subpackage Logic
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Class métier à appliqué sur un operateur de comparaison.
 * 
 * A noté que le typage est conservé dans le view bag. Et que par conséquent l'
 * operateur indentique === est diponible.
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
class LogicComparison extends Template\Logic {

    /**
     * Pile de tâches à effectuer.
     * @var SplObjectStorage
     */
    public $tasks;

    /**
     * Operateur de comparaison en cours.
     * @var SplObjectStorage
     */
    public $operator;

    /**
     * La chaine d'entrée a traiter.
     * @var string
     */
    public $subject;

    /**
     * Les operands à comparer
     * @var SplObjectStorage
     */
    public $operands;

    /**
     * Applique une classe métier LogicComparison au Tag if
     *
     * Retourne le resultat de la comparaison de deux variables selon un opérateur.
     *
     * @param array $subject Un tableau de retour de preg_match_all
     * @return bool|void Le contenu fichier template modifié par une fonction pcre
     */
    public function process($subject) {
        $this->subject = $subject;
        $this->tasks = new TasksComparison(new LogicVar());
        foreach ($this->tasks as $task) {
            if (preg_match($task->tags->pattern, $this->subject, $this->operator)) {
                $this->operator = $this->operator[1];
                $this->operands = explode($this->operator, $this->subject);
                $i = 0;
                foreach ($this->operands as $operand) {
                    $memberName = preg_replace_callback(PATTERN_VAR, array($task->logic, "getMemberName"), $operand);
                    $this->operands[$i] = self::$ViewBag->$memberName;
                    $i++;
                }

                switch ($this->operator) {
                    case '<' :
                        return $this->operands[0] < $this->operands[1];
                        break;

                    case '>' :
                        return $this->operands[0] > $this->operands[1];
                        break;

                    case '==' :
                        return $this->operands[0] == $this->operands[1];
                        break;

                    case '===' :
                        return $this->operands[0] === $this->operands[1];
                        break;

                    case '>=' :
                        return $this->operands[0] >= $this->operands[1];
                        break;

                    case '<=' :
                        return $this->operands[0] <= $this->operands[1];
                        break;

                    case '!=' :
                        return $this->operands[0] != $this->operands[1];
                        break;
                    case '!==' :
                        return $this->operands[0] !== $this->operands[1];
                        break;

                    default :
                        Parser::$trace[] = "Comparison operator $this->operator unknow";
                        break;
                }
                return true;
            }
        }
    }

}