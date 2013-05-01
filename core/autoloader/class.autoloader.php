<?php

namespace LibreMVC;

// dépendance
// Pas injection possible doit etre un callback static avec 1 argument
include('includer/class.includer.php');


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
  * @package LibreMVC
  * @copyright  Copyright (c) 2005-2011 Inwebo (http://www.inwebo.net)
  * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
  * @version    $Id:$
  * @link       https://github.com/inwebo/My.Forms
  * @since      File available since Beta 01-10-2011
  */

class AutoLoader {

    /**
     * Chemin par defaut dans l'ordre.
     *
     * - Chemin courant : ./
     * - Core : ./core/
     *
     * @var array
     */
    static public $poolPaths = array("./core/", "./", "./sites/_default/");

    static public function handler( $class ) {
        $j = -1;
        $toInclude = array();
        while(isset( self::$poolPaths[++$j] )) {
            $include = new \LibreMVC\Autoloader\Includer($class, "LibreMVC", self::$poolPaths[$j] );

            // Est un fichier jamais inclus

            if( is_file( $include->getPath( self::$poolPaths[$j] ) ) ) {
                include($include->getPath(self::$poolPaths[$j]));
                return;
            }
        }
    }

    static public function addPool( $path ) {
        if( is_dir( $path ) ) {
            self::$poolPaths[] = $path;
        }
    }

    static public function registerPool( $pool ) {
        if( is_dir( $pool ) ) {
            $inodes = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $pool,
                    \FilesystemIterator::SKIP_DOTS
                ),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            $toInclude= array();
            while ($inodes->valid()) {
                if ($inodes->isFile()) {
                    $toInclude[] =  $inodes->key() ;
                }
                $inodes->next();
            }
            self::addPool($toInclude);
        }

    }

    static public function getAutoload( $file ) {
        if( is_file( $file ) ) {
            include( $file );
        }
    }
}
