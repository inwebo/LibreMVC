<?php

namespace LibreMVC\Files;

/**
 * Liste le contenu d'un dossier
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
Class Directory extends \DirectoryIterator {

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
     * Get inodes into folder
     * @param String $path
     * @throws Exception if $path doesnt exist
     */
    public function __construct($path) {
        parent::__construct($path);
        $this->path = $path;
        $this->folders = new \SplObjectStorage();
        $this->files = new \SplObjectStorage();
        $this->size = 0;
        
        while ($this->valid()) {
            if ($this->isDir() && !$this->isDot()) {
                $this->folders->attach( new Inode($this->path.$this->current()->getFilename()));
            } elseif ($this->isFile()) {
                $inode = new Inode($this->path.$this->getFilename());
                $this->files->attach($inode);
                $this->size += $inode->size;
            }
            $this->next();
        }
        
        $this->count = new \stdClass();
        $this->count->files = $this->files->count();
        $this->count->folders = $this->folders->count();
    }

    public function __get($key) {
        if( $key === $this->files ) {
            return $this->files->rewind();
        }
        if( $key === $this->folders) {
            return $this->folders->rewind();
        }
    }

}
