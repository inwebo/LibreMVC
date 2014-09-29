<?php

namespace LibreMVC\Form\Input;

use LibreMVC\Form\Input as Input;

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
 * @package    Form
 * @subpackage Button
 * @copyright  Copyright (c) 2005-2011 Inwebo (http://www.inwebo.net)
 * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version    $Id:$
 * @link       http://www.w3.org/html/wg/drafts/html/master/single-page.html#range-state-(type=range) W3C
 * @since      File available since Beta 01-10-2011
 */
class Range extends Input {

    public $tag = "input";
    public $selfClosingTag = false;
    public $allowDescendants = false;
    public $innerHtml;

    public function __construct( $attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->innerHtml = ( is_null($innerHtml) ) ? "z" : $innerHtml;
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

    static protected function getLocalAttributs() {
        return array(
            "type" => 'range'
        );
    }

}
