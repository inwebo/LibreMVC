<?php

namespace LibreMVC\Form;

use LibreMVC\Html\Tag as Tag;


/**
 * HTML5 progress bar
 * @package LibreMVC
 * @subpackage Form
 * @subpackage Tag
 * @subpackage Progress
 */

/**
 * <p>Représentation de la progressions d'une tâche.</p>
 * @param array $attributs <p>Un tableau associatif autorisant les valeurs</p>
 * <code>
 * array(<br>
 * "value"=> // La valeur courante<br>
 * "max"=> // Valeur maximal<br>
 * )<br>
 * </code>
 * @param array $dataAttributs <p>Un tableau associatif des attributs data-*</p>
 * <code>
 * array(<br>
 * "hash"=> "fapokdsfoipq5d4f56qsdf4sq6df"<br>
 * "title"=> "titre"<br>
 * )<br>
 * <p>sera représenté sous la forme html</p>
 * <code> data-hash="fapokdsfoipq5d4f56qsdf4sq6df" data-title="titre"</code>
 * </code>
 * @link http://www.w3.org/html/wg/drafts/html/master/single-page.html#the-progress-element description
 */
class Progress extends Tag {

    protected $tag = "progress";
    protected $selfClosingTag = false;
    public $allowDescendants = false;

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

    static protected function getLocalAttributs() {
        return array(
            "value" => "",
            "max" => ""
        );
    }

}
