<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 19:25
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Autoloader;

use \LibreMCV\Files\RecursiveDirectory;

/**
 * Class ClassMap
 *
 * @package LibreMVC\Autoloader
 */

class ClassMap {

    protected $_dirs;

    public function __construct( $pool ) {
        $classFiles = new \LibreMVC\Files\RecursiveDirectory( $pool );
        foreach($classFiles->files as $inode) {
            var_dump($inode);
        }
    }

}