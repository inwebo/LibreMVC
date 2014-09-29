<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 15/08/13
 * Time: 21:39
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Bookmarks\Models;


use LibreMVC\Database\Entity;

class Category extends Entity{

    public $id;
    public $name;

    public function __construct() {
        parent::__construct();
    }

}