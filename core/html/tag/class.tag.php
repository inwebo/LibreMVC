<?php

namespace LibreMVC\Html;

use LibreMVC\Html\Helpers\CleanOutput as CleanOutput;

// <editor-fold defaultstate="collapsed" desc="Licence">
/**
 * My Framework : My.Forms
 *
 * LICENCE
 *
 * You are free:
 * to Share ,to copy, distribute and transmit the work to Remix —
 * to adapt the work to make commercial use of the work
 *
 * Under the following conditions:
 * Attribution, You must attribute the work in the manner specified by
 *   the author or licensor (but not in any way that suggests that they
 *   endorse you or your use of the work).
 *
 * Share Alike, If you alter, transform, or build upon
 *     this work, you may distribute the resulting work only under the
 *     same or similar license to this one.
 *
 *
 * @category   My.Forms
 * @package    Base
 * @copyright  Copyright (c) 2005-2011 Inwebo (http://www.inwebo.net)
 * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version    $Id:$
 * @link       https://github.com/inwebo/My.Forms
 * @since      File available since Beta 01-10-2011
 */
// </editor-fold>

/**
 * <p>Class abstraite dont tous les objets d'un formulaire HTML <b>doivent</b> 
 * hérités.</p>
 * <p>
 *  Un tag html peut être autofermant <code>$selfClosingTag</code>, posséde un
 * tag Html valide <code>$tag</code>, à des attributs Html contenus dans <code>$attributs</code>
 * sous forme d'un tableau associatif, peut posséder des attributs html5
 * <code>data-*</code>, peut avoir définir si il autorise la balise à avoir des
 * descendants <code>$allowDescendants</code>, si cela est autorisé ils seront
 * contenus dans <code>$descendants</code>, et il peut posséder également un
 * inner html
 * </p>
 *
 * @package    LibreMVC/Html
 * @subpackage Html
 * @subpackage Tag
 * @copyright  Copyright (c) 2005-2013 Inwebo (http://www.inwebo.net)
 * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version    $Id:$
 * @link       https://github.com/inwebo/My.Forms
 * @since      Class available since Beta 01-10-2011
 * @abstract Toutes les balises HTML <b>devraient</b> héritées de cette classe.
 */
abstract class Tag {

    /**
     * Seed unique. Permet l'atomicité des champs du formulaire.
     * @var int
     */
    static protected $seed = 0;

    /**
     * La balise HTML est elle autofermante.
     * @var bool
     */
    protected $selfClosingTag = false;

    /**
     * Balise HTML.
     * @var string
     */
    protected $tag = null;

    /**
     * Tableau d'attributs Html 5 valides.
     * @var array
     */
    protected $attributs;

    /**
     * Tableau d'attributs data-* Html 5 valides.
     * @var array
     */
    protected $dataAttributs = array();

    /**
     * L'objet peut il contenir des descendants.
     * @var bool
     */
    protected $allowDescendants = true;

    /**
     * Si l'objet posséde des enfants il seront contenus dans cet attribut.
     * @var SplObjectStorage
     */
    protected $descendants;

    /**
     * Initialisation des toutes les variables de classe nécessaire à un
     * objet.
     * A chaque instantation d'un nouvel objet enfant incrémentation de la
     * variable statique self::$id.
     *
     * Tous les enfants possèdent les attributs de base contenu dans,
     * $this->baseAttributs. Les attributs supplémentaires contenus dans
     * $this->addAttributs spécifiques à chaque instance d'objet seront
     * fusionnés avec ceux de base dans $this->attributs.
     *
     * Si l'instance peut contenir des enfants, typiquement les tags HTML
     * n'ayant pas de balise autofermante, seront disponibles dans
     * $this->childs
     *
     * Tous les attributs contenu dans $this->attributs non null seront
     * présent dans la representation HTML de l'objet.
     *
     * @param  array $attributs
     * @return void
     * @abstract
     */

    /**
     * @param array $attributs
     * @param array $dataAttributs
     */
    protected function __construct($attributs = array(), $dataAttributs = array()) {
        ++static::$seed;
        $this->attributs = $attributs;
        $this->buildAttributs($attributs, __CLASS__ );
        $this->dataAttributs = $dataAttributs;
        $this->descendants = $this->initDescendants();
    }

    /**
     * Récupération de tous les ancêtres de l'instance courante.
     * 
     * @param array $class Le nom de class de l'instance courante.
     * @return array
     * @link http://www.php.net/manual/en/function.get-parent-class.php#57548 Thank you PHP DOC
     */
    protected function getAncestors ($class) {
        $classes = array($class);
        while($class = get_parent_class($class)) { $classes[] = $class; }
        return $classes;
    }
    
    /**
     * <p>Construction de tous les attributs autorisés par défaut pour la classe
     *  courante.</p>
     * <p>Merge tous les attributs définis par la famille de classe. Chaque classe héritées 
     * de Node permet d'ajouter aux attributs de base définis par 
     * <code>self::getDefaultAttributs()</code> les attributs de la classe
     *  courante définis par <code>static::getLocalAttributs()</code>.</p>
     * 
     * @param array $attributs Liste d'attributs utilisateur, sous la forme d'un
     * tableau associatif.
     * @param string $class Le nom de classe de l'instance courante <code>__CLASS__</code>
     * @return array L'ensemble des attributs autorisés par la classe courante
     * et définis par l'utilisateur.
     */
    protected function buildAttributs($attributs, $class) {
        $pool = $this->getInheritedAttributs($class);
        $knownAttributs = array_intersect_key($attributs, $pool);
        return array_merge($pool, $knownAttributs);
    }

    
    function getInheritedAttributs($class) {
        $class = $this->getAncestors($class);
        $attr = static::getDefaultAttributs();
        foreach($class as $key => $value) {
            $attr = array_merge( $value::getLocalAttributs(), $attr );
        }
        return $attr;
    }

    protected function getAttributs($getEmptyValues = false) {
        return (!$getEmptyValues) ?
                array_filter(array_merge( $this->attributs, $this->getDataAttributs()), "strlen") :
                array_merge($this->attributs, $this->getDataAttributs());
    }

    protected function getDataAttributs() {
        $dataAttributs = array();
        foreach ($this->dataAttributs as $key => $value) {
            $dataAttributs['data-' . $key] = $value;
        }

        return $dataAttributs;
    }

    static protected function getDefaultAttributs() {
        return array(
            "id" => self::getId(),
            "class" => null,
            "style" => null,
            "title" => null,
            "name" => self::getId(),
            "lang" => NULL,
            "dir" => NULL,
            "tabindex" => NULL,
            "accesskey" => NULL,
            "onclick" => NULL,
            "ondblclick" => NULL,
            "onmousedown" => NULL,
            "onmouseup" => NULL,
            "onmouseover" => NULL,
            "onmousemove" => NULL,
            "onmouseout" => NULL,
            "onkeypress" => NULL,
            "onkeydown" => NULL,
            "onkeyup" => NULL,
            "onfocus" => NULL,
            "accesskey" => NULL,
            "onblur" => NULL,
            "contenteditable"=>null,
            "contextmenu"=>null,
            "draggable"=>null,
            "dropzone"=>null,
            "hidden"=>null, // Bool
            "spellcheck"=>null,
            "translate"=>null
        );
    }

    static protected function getLocalAttributs() {
        return array();
    }

    static protected function getId($prefix = "item-") {
        return $prefix . self::$seed;
    }

    protected function initDescendants() {
        return ( $this->allowDescendants ) ? new \SplObjectStorage() : null;
    }

    /**
     * Ajoute un descendant <code>Node</code> à la classe courante.
     *
     * @param Node Un objet Node valide.
     * @return this L'instance courante
     */
    public function attach($descendant) {
        ( $this->allowDescendants ) ? $this->descendants->attach($descendant) : null;
        return $this;
    }

    /**
     * 
     */
    protected function attributsToHtml() {
        $attributs = $this->getAttributs(false);
        $html = "";
        foreach ($attributs as $key => $value) {
            $html .= ' ' . strtolower($key) . '="' . strtolower($value) . '"';
        }
        return $html;
    }

    public function openingTagToHtml() {
        $html = "<" . strtolower($this->tag);
        $html .= $this->attributsToHtml();
        $html .= ( $this->selfClosingTag ) ? ' />' . "\n" : ' >' . "\n";
        return $html;
    }

    protected function descendantsToHtml() {
        $html = "";
        if ($this->allowDescendants && $this->descendants->count() > 0) {
            $this->descendants->rewind();
            while ($this->descendants->valid()) {
                ob_start();
                echo $this->descendants->current()->toHtml();
                $html .= ob_get_clean();
                $this->descendants->next();
            }
        }
        return $html;
    }

    public function closingTagToHtml() {
        $output = (!$this->selfClosingTag) ? '</' . strtolower($this->tag) . '>' . "\n" : '' . "\n";
        return $output;
    }

    /**
     * Affiche l'objet sous forme de chaine HTML valide w3c, de manière
     * recursive.
     *
     * @param bool $echo Si vrai affichage sortie standart sinon retour chaine de caratères.
     * @return string $output
     */
    public function toHtml( $echo = false ) {
        $html = $this->openingTagToHtml();
        $html .= (!$this->descendants && isset($this->innerHtml)) ? $this->innerHtml : null;
        $html .= $this->descendantsToHtml();
        $html .= $this->closingTagToHtml();
        $cleanOutput = new CleanOutput();
        if($echo) {
            echo $cleanOutput->clean($html);
        }
        else {
            return $cleanOutput->clean($html);
        }
    }

}
