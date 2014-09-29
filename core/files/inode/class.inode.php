<?php

namespace LibreMVC\Files;


/**
 * Propriétés d'un inode (fichier, dossier)
 *
 * @category   LibreMVC
 * @package    Files
 * @subpackage IO
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
Class Inode extends \SplFileInfo {

    /**
     * Path's file to collect inode infos.
     * @var  String
     */
    public $wich;

    /**
     * Base name's file, directory, or link without path info.
     * @var  String
     */
    public $name;

    /**
     * Retrieves the file extension.
     * @var  String
     */
    public $extension;

    /**
     * Name file without extension
     * @var  STRING
     */
    public $nameLessExtension;

    /**
     * This method expands all symbolic links, resolves relative references
     * and returns the real path to the file.
     * @var  String
     */
    public $realPath;

    /**
     * TGets an SplFileInfo object for the path.
     * @var  String
     */
    public $pathInfo;

    /**
     * Returns the path to the file, omitting the filename and any trailing slash.
     * @var  String
     */
    public $path;

    /**
     * Gets the filename without any path information.
     * @var  String
     */
    public $fileName;

    /**
     * Last access.
     * @var  String
     */
    public $lastAccess;

    /**
     * Last changed file.
     * @var  String
     */
    public $lastChangedTime;

    /**
     * Last changed content.
     * @var  String
     */
    public $lastChangedContent;

    /**
     * Gets permissions.
     * @var  String
     */
    public $permission;

    /**
     * Returns the type of the file referenced. file || dir.
     * @var  String
     */
    public $type;

    /**
     * @var  Bool
     */
    public $writable;

    /**
     * @var  Bool
     */
    public $readable;

    /**
     * @var  Int
     */
    public $size;

    public function __construct($file_name) {
            parent::__construct($file_name);
            $this->which = $file_name;
            $this->name = $this->getBaseName();
            $this->extension = pathinfo($this->getFilename(), PATHINFO_EXTENSION);
            $this->nameLessExtension = $this->getBaseName('.' . $this->extension);
            $this->realPath = $this->getRealPath();
            $this->path = $this->getPath();
            $this->pathInfo = $this->getPathInfo();
            $this->pathName = $this->getPathName();
            $this->fileName = $this->getFilename();
            
            try {
                $this->lastAccess = strftime("%d/%m/%y", $this->getATime());
                $this->lastChangedTime = strftime("%d/%m/%y", $this->getCTime());
                $this->lastChangedContent = strftime("%d/%m/%y", $this->getMTime());
                $this->permission = substr(sprintf('%o', $this->getPerms()), -4);
                $this->type = $this->getType();
                $this->writable = $this->isWritable();
                $this->readable = $this->isReadable();
                ( $this->type == "dir" ) ? $this->size = NULL : $this->size = $this->getSize();
            }  catch ( Exception $e ) {
                $e->getMessage();
            }
    }

    public function copy( $dest ) {
        return copy($this->pathName, $dest);
    }
    
    public function rename($newname) {
        return rename($this->pathName, $newname);
    }
    
    public function move($dest) {
        if( $this->copy($dest) ) {
            unlink($this->pathName);
            return true;
        }
        else {
            return false;
        }
    }
    
    public function toNamespaceAlias() {       
        $buffer = array_diff(explode('/', $this->pathName), array( $this->name ));
        array_shift($buffer);
        $shortcut = $buffer[count($buffer)-1];
        $buffer=    array_map("ucfirst",$buffer);
        $buffer = array_merge(array("LibreMVC"), $buffer);
        $buffer = ' use \\'.implode("\\", $buffer) . " as " . ucfirst($shortcut) . "\n";
        var_dump($buffer);
    }

    public function del() {
        return unlink($this->pathName);
    }
}