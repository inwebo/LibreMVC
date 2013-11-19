<?php

namespace LibreMVC\Form\Helpers;

use CustomForm;

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
 * @package    Widgets
 * @copyright  Copyright (c) 2005-2011 Inwebo (http://www.inwebo.net)
 * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version    $Id:$
 * @link       https://github.com/inwebo/My.Forms
 * @since      File available since Beta 01-10-2011
 */

/**
 * Widget typique d'un formulaire de login.
 *
 * @todo		Add anchor tag to all elemets
 * @category   My.Forms
 * @package    Custom form
 * @copyright  Copyright (c) 2005-2011 Inwebo (http://www.inwebo.net)
 * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version    $Id:$
 * @link       https://github.com/inwebo/My.Forms
 * @since      Class available since Beta 01-10-2011
 */
class Login extends CustomForm {

    public function __construct() {
        $this->form = new FormForm();
        $this->form->defaultButtons = FALSE;
        $this->form->attachChild(new FormFieldSet("Please Login"), "fieldset");
        $this->form->descendants["fieldset"]->attachChild(new FormText(), "Login");
        $this->form->descendants["fieldset"]->descendants["Login"]->setAttributs(array("name" => "login"));
        $this->form->descendants["fieldset"]->descendants["Login"]->setLabel("Login <br>");
        $this->form->descendants["fieldset"]->attachChild("<br>");
        $this->form->descendants["fieldset"]->attachChild(new FormPassword(), "Password");
        $this->form->descendants["fieldset"]->descendants["Password"]->setLabel("Password <br>", "<br>");
        $this->form->descendants["fieldset"]->descendants["Password"]->setAttributs(array("name" => "password"));
        $this->form->descendants["fieldset"]->attachChild(new FormCheckbox(), "checkbox");
        $this->form->descendants["fieldset"]->descendants["checkbox"]->setAttributs(array("name" => "keepon"));
        $this->form->descendants["fieldset"]->descendants["checkbox"]->setLabel("", "Keep me on!<br>");
        $this->form->descendants["fieldset"]->attachChild(new FormButton(), "Submit");
    }

}
