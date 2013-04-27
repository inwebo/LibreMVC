<?php

namespace LibreMVC\Helpers;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Pagination simplifiée.
 * 
 * Description longue
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
class Pagination {

    
    /**
     * L'objet à paginer.
     * @var mixed 
     */
    public $subject;
    
    /**
     * Nombre de page
     * @var int 
     */
    public $max;
    
    /**
     * Index de la première page
     * @var int 
     */
    public $min;
    
    /**
     * Nombre d'objet par page.
     * @var int
     */
    public $limite;
    
    /**
     * Index courant. (page en cours)
     * @var int
     */
    public $index;
    
    /**
     * L'object paginé.
     * @var mixed
     */
    protected $chunk;
    
    /**
     * Nouvel pagination.
     * 
     * @param mixed $subject Un objet ou un array à paginer.
     * @param int $index La page courante
     * @param int $limite Nombre objet par page.
     */
    public function __construct( $subject, $index = 1 , $limite = 27) {
        $this->subject = $subject;
        $this->index=  $index;
        $this->limite = $limite ;

        $this->chunk = $this->chunk();
        $this->min = $this->setMin();
        $this->max = $this->setMax();
    }

    /**
     * Si le sujet est paginable retourne 1 sinon -1.
     * @return int
     */
    public function setMin() {
       return (!empty($this->chunk)) ? 1 : -1;
    }

    /**
     * Si le sujet est paginable retourne le nombre de page total sinon -1.
     * @return int
     */
    public function setMax() {
        return (!empty($this->chunk)) ? count($this->chunk) : -1;
    }

    /**
     * Existe t il une page suivante.
     * @return bool True si une page suivante existe sinon false
     */
    public function next() {
        return (isset($this->chunk[$this->index+1])) ? true : false;
    }

    /**
     * Existe t il une page précédente.
     * @return bool True si une page précédente existe sinon false
     */
    public function prev() {
        return (isset($this->chunk[$this->index-1])) ? true : false;
    }
    
    /**
     * Retourne la premiére pagination si elle existe.
     * @return mixed objet si elle existe ou null
     */
    public function first() {
        if($this->min !== -1) {
            $this->index = 1;
            return $this->chunk[1];
        }
        else {
            return null;
        }
    }

    /**
     * Retourne la dernière pagination si elle existe.
     * @return mixed objet si elle existe ou null
     */
    public function last() {
        if( $this->max !== -1 ) {
            $this->index = $this->total();
            return $this->chunk[$this->total()];
        }
    }

    /**
     * Nombre items dans la pagination courante
     * @return ints
     */
    public function items() {
        return count( (array) $this->subject );
    }
    
    /**
     * Nombre de page maximum.
     * @return int
     */
    public function total() {
        return ceil($this->items() / $this->limite);
    }

    /**
     * Retourne une pagination à la page $number.
     * 
     * @param int $number Page souhaitée.
     * @param bool $asObject Si vaut true la fonction retourne la page sous forme
     * de class standart, sinon un tableau. Par défaut false
     * @return mixed Selon la valeur de <b>$asObject</b>. Provoque une erreur si la page
     * souhaitée $number est en dehors des limites.
     */
    public function page($number, $asObject = false) {
        if( is_numeric($number) && $number <= $this->max && $number >= $this->min ) {
            $this->index = $number;
            return ($asObject) ? (object) $this->chunk[$number] : $this->chunk[$number];
            
        }
        else {
            trigger_error("Page doesnt exists");
        }

    }
    
    /**
     * @see array_chunk()
     * @return array
     */
    protected function chunk() {
        $chunked = @array_chunk( (array) $this->subject, $this->limite, true);
        $return = array();
        if(!is_null($chunked)) {
            $j=1;
            foreach ( $chunked as $c ) {
                $return[$j++] = $c;
            }
        }
        return $return;
    }
    
    /**
     * Calcul les limites de la requête sql
     * 
     * <code>
     * SELECT * FROM table [LIMIT [offset,] lignes] ]
     * </code>
     * 
     * @param int $items Le nombre d'items à paginés
     * @param int $limite Nombre maximum d'items par page
     * @param int $page Le numéro de page demandé
     * @return Mixed Un tableau si les limites pour le numéro de page existent.
     * sinon null
     */
    static public function sqlLimit($items, $limite, $page) {
        $totalPage= ceil($items/$limite);
        if($page > $totalPage) {
            $limit = null;
        }
        else {
            $limit['start'] = $limite * $page - $limite;
            $limit['end'] = $limite * $page - 1;
        }
        return $limit;
    }

    /**
     * 
     * @param type $attribut
     * @param type $value
     */
    static public function dummyPagination($items, $page = 1, $limit = 20) {
        $subject = array_fill(0, $items, null);
        $pagination = new Pagination( $subject, $page, $limit );
        return $pagination;
    }




    public function __set($attribut, $value) {
        $this->$attribut = $value;
    }

    public function __get($attribut) {
        if (property_exists($this, $attribut)) {
            return $this->$attribut;
        }
    }

}