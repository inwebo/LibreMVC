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
use LibreMVC\View\Template\TemplateFromString;
use LibreMVC\View\Task;
use LibreMVC\View\ViewObject;

class Loop extends Logic {

    protected $buffer = "";
    protected $loopInformations;

    protected function initialize( $pregReplaceCallbackResult ){
        // Extract de la loop courante du résultat d'une $pregReplaceCallback
        if( is_string($pregReplaceCallbackResult) ) {
            $loop = $pregReplaceCallbackResult;
        }
        elseif( is_array($pregReplaceCallbackResult) ){
            $loop = $pregReplaceCallbackResult[0];
        }

        // Informations sur la loop courante
        $loopInformationsFactory = new Loop\Informations($this->dataProvider);
        $this->loopInformations = $loopInformationsFactory->process($loop);

        // Pas de DataProvider pas de traitement.
        if( !isset( $this->loopInformations->dataProvider ) || empty($this->loopInformations->dataProvider) || count($this->loopInformations->dataProvider) === 0 ) {
            return '<<<<<<<<<'.$this->loopInformations->string.'>>>>>>>>>';
        }

    }

    /**
     * Point entrée de la classe
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process($match) {

        $this->initialize( $match );

        /**
         * N'est pas iterable, ne posséde donc pas de membre. retourne tag loop inchangé.
         */
        if( ! is_object($this->dataProvider) ) {

            return '<<<'.$this->loopInformations->toString.'>>>';
        }
        /**
         * Le remplacement peut se faire.
         */
        else {

            return  $this->processLocalVars($this->loopInformations);
        }

    }

    /**
     * Remplace une loop imbriquée par un placeholder. Permet le traitement des variables du scope local.
     * @param $stringLoop
     * @return mixed Voir preg_replace
     */
    protected function obfuscateInternalLoop( $stringLoop ) {
        return preg_replace(Tag::LOOP, TAG::PLACEHOLDER , $stringLoop);
    }

    protected function iterateDataProvider( $callback ) {
        foreach($this->dataProvider as $key => $value) {
            return call_user_func_array($callback, array("key"=>$key,"value"=>$value));
        }

    }

    protected function simpleBodyVarsCallback($key, $value) {
        $_return ="";
        $buffer = $this->loopInformations->bodyVars;
        // Remplace les occurences de $key / $value
        $buffer = $this->processLocalVars($this->loopInformations->as['key'], $key,$buffer);
        $buffer = $this->processLocalVars($this->loopInformations->as['value'], $value,$buffer);
        //var_dump($buffer);
        $_return .= $buffer;
        return $_return;
    }

    protected function isValidDataProviderMember( $dataProviderMember ) {
        return (isset( $this->dataProvider->$dataProviderMember ));
    }

    public function processLocalVars($loopInformations) {

        $_return ="";

        // A partir d'ici nous savons que le data provider est iterable
        /**
         * Est ce une boucle imbriquée ?
         */
        // N'est pas une boucle imbriquée
        if( !$loopInformations->recursive ) {

            // Parcours tous les membre du dataProvider
            //$this->iterateDataProvider(array('',''));
/*
            foreach($this->dataProvider as $k => $v) {
                $buffer = $loopInformations->bodyVars;
                // Remplace les occurences de $key / $value
                $buffer = $this->processLocalVars($loopInformations->as['key'], $k,$buffer);
                $buffer = $this->processLocalVars($loopInformations->as['value'], $v,$buffer);
                //var_dump($buffer);
                $_return .= $buffer;
            }
*/
        }
        /**
         * Est une boucle imbriquée
         */
        else {
            $_return = $this->iterateDataProvider( array( $this, 'includedBodyVarsCallBack' ) );
        }

        return $_return;
    }

    protected function processInnerLoopDataProvider($dataMember){

    }

    public function includedBodyVarsCallBack($key, $value) {
        $tempLoop = $this->obfuscateInternalLoop($this->loopInformations->body);



        // Est un membre du view object
        if( $this->isValidDataProviderMember($key)  ) {
            // Scope local
            $tempLoop = $this->populateLocalVars($this->loopInformations->as['key'], $key, $tempLoop);
            $tempLoop = $this->populateLocalVars($this->loopInformations->as['value'], $value, $tempLoop);

            // Replace le placeHolder avec loop inclue
            preg_match(Tag::LOOP, $this->loopInformations->body, $innerLoop);
            $tempLoop = $innerLoop;

            $tempLoopInformations = new Loop\Informations($this->dataProvider->$key);
            var_dump($tempLoopInformations->process($innerLoop[0]));
            $tempLoopInformations->injectDataProviderName($key);

            var_dump($tempLoop);

        }
        if( $this->isValidDataProviderMember($key) && is_object($key) ) {
            // Getter loop inclue


            // GetResult
            if( is_array($innerLoop) && isset($innerLoop) && !empty($innerLoop) ) {
                $innerLoop = $innerLoop[0];
                $tempLoop = str_replace(Tag::PLACEHOLDER, $innerLoop, $tempLoop);
            }

            var_dump($tempLoop);

            // Inject la donnée

            var_dump(preg_match(Tag::LOOP_ITERABLE, $this->loopInformations->body , $tempData));
            if(is_object($this->dataProvider->$key)) {
                var_dump(preg_replace(Tag::LOOP_ITERABLE,$this->dataProvider->$key,$tempData[0]));
                var_dump($tempData[0]);
            }
        }

        /*
        else {
            // Template depuis la chaine temploop

        }
        */
        return $tempLoop;
    }

    public function populateLocalVars( $search, $replacement, $subject ) {
        return  preg_replace( '#\{\$'.$search.'\}#m',$replacement, $subject );
    }

}