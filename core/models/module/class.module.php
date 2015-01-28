<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 28/01/15
 * Time: 20:41
 */

namespace LibreMVC\Models;


use LibreMVC\Web\Instance\PathsFactory\Path;

class Module {

    protected $_name;
    /**
     * @var Path
     */
    protected $_path;

    public function __construct($name, Path $path) {
        $this->_name = strtolower($name);
        $this->_path = $path;
    }

    public function getPath(){
        return $this->_path;
    }

}