<?php

namespace LibreMVC\Files;

use LibreMVC\Files\Inode as Inode;

/**
 * Liste tous les dossiers et fichiers d'une arborescence.
 *
 * Retourne tous les fichiers et dossiers d'une arborescence sous forme de tableau,
 * de manière récursive.
 *
 *
 * @category   LibreMVC
 * @package    Files
 * @subpackage IO
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/My.Files
 * @since      File available since Beta
 */
Class RecursiveDirectory {

    /**
     * Folder to iterate
     * @var String
     */
    public $path;

    /**
     * Folders list
     * @var SplObjectStorage
     */
    public $folders;

    /**
     * Files list
     * @var SplObjectStorage
     */
    public $files;

    /**
     * Current path size (octet)
     * @var Int
     */
    public $size;
  
    /**
     * Count folders & files
     * @var StdClass
     */
    public $count;    
    
    /**
     * Will recursively iterate through a path.
     * @param String $path
     * @throws Exception if $path doesnt exist
     */
    public function __construct( $path ) {
        if( !is_dir($path) ) {
            throw new Exception("Unknow path : $path");
        }
        $this->path = $path;
        $inodes = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator(
                                $this->path,
                                \FilesystemIterator::SKIP_DOTS
                        ),
                        \RecursiveIteratorIterator::CHILD_FIRST
        );
        //$this->folders = new \SplObjectStorage();
        $this->folders = array();
        //$this->files = new \SplObjectStorage();
        $this->files = array();
        $this->size = 0;
        
        while ($inodes->valid()) {
            if ($inodes->isDir()) {
                $this->folders[] =new Inode($inodes->key());
            } elseif ($inodes->isFile()) {
                $inode = new Inode($inodes->key());
                $this->files[] = $inode;
                $this->size += $inode->size;
            }
            $inodes->next();
        }

        $this->count = new \stdClass();
        $this->count->files = count($this->files);
        $this->count->folders = count($this->folders);
    }

    /**
     * Return Files
     * @return SplObjectStorage
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * Return Folders
     * @return SplObjectStorage
     */
    public function getFolders() {
        return $this->folders;
    }

    /**
     * Return Folders & Files
     * @return SplObjectStorage
     */
    public function get() {
        return self::mergeSplObjectStorage( $this->getFolders(), $this->getFiles() );
    }

    /**
     * Merge SplObjectStorage
     *
     * @param how many SplObjectStorage segment as you want
     * @return SplObjectStorage
     */
    static protected function mergeSplObjectStorage() {

        $buffer = new SplObjectStorage();

        if (func_num_args() > 0) {
            $args = func_get_args();
            foreach ($args as $objectStorage) {
                foreach ($objectStorage as $object) {
                    if (is_object($object)) {
                        $buffer->attach($object);
                    }
                }
            }
        } else {
            return FALSE;
        }
        return $buffer;
    }

}