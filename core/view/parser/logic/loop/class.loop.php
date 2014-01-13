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

    protected $buffer = "";

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

        $obfuscatedLoop = new Loop\Informations($this->dataProvider);
        $loopInformations = $obfuscatedLoop->process($loop);

        //var_dump($loopInformations);

        // Pas de DataProvider pas de traitement.
        $dp = $loopInformations->dataProvider;
        if( !isset( $this->dataProvider->$dp ) ) {
            return $loop;
        }

        // Est ce une boucle recursive
        // @todo : Recusivité

        return  $this->processLocalVars($loopInformations);
    }

    public function processLocalVars($loopInformations) {
        $dp = $loopInformations->dataProvider;
        $_return = "";
        $j=0;
        foreach( $this->dataProvider->$dp as $k => $v) {

            if($loopInformations->recursive) {

                // Obfuscation de la loop interne
                $tempLoop = preg_replace(Tag::LOOP,'####', $loopInformations->body);
                var_dump($tempLoop);

                $buffer = $tempLoop;

                $obfuscatedLoop = new Loop($this->dataProvider);
                preg_match(Tag::LOOP, $loopInformations->body, $innerLoop);
                var_dump($innerLoop[0]);

                $computedInnerLoop =  $obfuscatedLoop->process($innerLoop);
                var_dump($computedInnerLoop);

            }
            else {
                $buffer = $loopInformations->bodyVars;
                // Remplace les occurences de $key / $value
                $buffer = $this->processLocalVars($loopInformations->as['key'], $k,$buffer);
                $buffer = $this->processLocalVars($loopInformations->as['value'], $v,$buffer);
                //$buffer = preg_replace('#(\{\$'.$loopInformations->as['key'].'\})#m',$k,$buffer);
                //$buffer = preg_replace('#\{\$'.$loopInformations->as['value'].'\}#m',$v,$buffer);
                $_return .= $buffer;
            }
            $j++;
        }

        return $_return;
    }

    public function populateLocalVars($search, $pattern, $subject) {
        return  preg_replace('#\{\$'.$search.'\}#m',$pattern,$subject);
    }

}