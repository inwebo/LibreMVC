<?php
namespace LibreMVC\View\Parser\Logic;

/**
 * Class métier à appliqué sur un Tag Loop.
 *
 * Objet métier, sera le function de callback de preg_match_all cf la class Task
 * Itére un tableau.
 * 
 * <code>
 * <ul>
 * {loop array="{$array}"}
 * <li>{$key},{$value}</li>
 * {/loop}
 * </ul>
 * </code>
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
use LibreMVC\View\Parser\Logic;
use LibreMVC\View\Parser\Tag;
use LibreMVC\View\Parser;
use LibreMVC\View\Task;
use LibreMVC\View\ViewObject;


class Loop extends Logic {

    /**
     * Boucle sur un tableau
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process($match) {
        //var_dump($match);
        // PAttern complet
        $loop = $match[0];
        preg_match(PATTERN_LOOP_HEADER,$loop, $header);

        // entete pattern complet
        $header = $header[0];
        preg_match(PATTERN_AS_VAR_LOOP, $header, $_dataProvider);

        // Contenu
        preg_match(PATTERN_INNER_LOOP,$loop, $innerLoop);
        $innerLoop = $innerLoop[1];

        // ViewObject membre souhaité
        $dataProviderMember = $_dataProvider[1];
        $asvarloop = trim($_dataProvider[2],' ');

        $recursive = (bool)preg_match(PATTERN_LOOP, $innerLoop);

        preg_match( PATTERN_KEY_VALUE_LOOP , $header, $keyValue );
        $key = $keyValue[1];
        $value = $keyValue[2];

        preg_match(PATTERN_LOOP_GET_LOCAL_VARS,$innerLoop,$buffer);
        $localVars = $buffer[1];
        /*
        var_dump($buffer);
        var_dump($loop);
        var_dump($header);
        var_dump($key);
        var_dump($value);
        */
        // Pour la propriete du viewobject courant.
        //var_dump($dataProviderMember);

        if(!isset($this->dataProvider->$dataProviderMember)) {
            return $localVars;
        }

        $_return = "";
        foreach( $this->dataProvider->$dataProviderMember as $k => $v) {
            echo $k.$v;
            $buffer = $localVars;
            // Remplace les occurences de $key / $value
            $buffer = preg_replace('#(\{\$'.$key.'\})#m',$k,$buffer);
            $buffer = preg_replace('#\{\$'.$value.'\}#m',$v,$buffer);
            $_return .= $buffer;

            // Si est loop imbriquée nouvelle loop
        }

        //$iterable = $this->dataProvider->$dataProviderMember;
/*
        var_dump($iterable);
        // Dans un nouveau viewobject avec $key->value
        var_dump($asvarloop);
        // Nouvelle loop si loop imbriquées.
        var_dump($innerLoop);
        var_dump($recursive);
*/
        /*
        $viewObject = new ViewObject();
        $task = new Task(new Tag(PATTERN_LOOP), new Loop($iterable));
        $task->getLogic()->process($innerLoop);
*/
        /*
        foreach( $iterable as $key => $value ) {
            echo $value;
        }
*/
        var_dump($_return);
        return $_return;
        /*
        $buffer = array();
        if (!isset($this->dataProvider->$match[1])) {
            // Error
            return null;
        }
        $logic = new LogicVar();
       
        foreach ($this->dataProvider->$match[1] as $this->dataProvider->$match[1]->key => $this->dataProvider->$match[1]->value) {
            $buffer[] = preg_replace_callback(PATTERN_VAR, array($logic, 'process'), $match[2]);
        }

        return implode('', $buffer);*/
    }

}