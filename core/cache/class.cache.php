<?php

namespace LibreMVC;

/**
 * Class Cache
 * @package LibreMVC
 */
class Cache {

    /**
     * Unique id, default file name
     * @var string
     */
    public $id;

    /**
     * File prefix
     * @var string
     */
    public $filePrefix;

    /**
     * File name
     * @var string
     */
    public $fileName;

    /**
     * File extension
     * @var string
     */
    public $fileExtension = '.html';

    /**
     * File cache header
     * @var string
     */
    public $fileHeader;

    /**
     * File cache footer
     * @var string
     */
    public $fileFooter;

    /**
     * Current file cache path
     * @var string
     */
    public $file;

    /**
     * Chemin d'accés au répertoire contenant les fichiers de cache 
     * @var string
     */
    public $pathDir = 'cache/';

    /**
     * Temps unix de creation du fichier cache
     * @var int
     */
    private $birth;

    /**
     * Temps unix de mort du cache
     * $birth + $life
     * @var int
     */
    private $death;

    /**
     * Temps unix duré de vie du fichier cache
     * en seconde
     * @var int
     */
    public $life = 5;

    /**
     * Buffer du fichier cache
     * @var int
     */
    private $buffer;

    /**
     * Ajout de commentaires HTML dans la première et dernière ligne du fichier cache
     * @var bool
     */
    public $htmlComments = true;

    /**
     * Le fichier cache est il à jour
     * @var bool
     */
    private $updating = false;

    public function __construct($params = array()) {
        $this->__setMembers($params);
        $this->id = md5($_SERVER['REQUEST_URI'] . $this->fileName);
        $this->file = $this->setCurrentFile();

        if (!file_exists($this->pathDir)) {
            throw new \Exception('Dir ' . $this->pathDir . ' doesn\'t exists ');
        } elseif (!is_writable($this->pathDir)) {
            throw new \Exception('Dir ' . $this->pathDir . ' isn\'t writable ');
        } elseif (file_exists($this->file) && !is_writable($this->file)) {
            throw new \Exception('File ' . $this->file . ' isn\'t writable ');
        }
        
        ( $this->htmlComments ) ? $this->setComments() : null;
    }

    public function start() {
        // File to cache already cached ?
        if (file_exists($this->file)) {
            $this->birth = (integer) filemtime($this->file);
            $this->death = $this->birth + $this->life;
            // File Cache is uptodate ?
            if ($this->isValidCache()) {
                // Yes it's
                readfile($this->file);
                ob_start();
            } else {
                // Nope it's not, generate new cache file
                $this->updating = 1;
                ob_start();
            }
        }
        // Cache file doesn't exists
        else {
            $this->birth = time();
            $this->death = $this->birth + $this->life;
            $this->updating = 1;
            ob_start();
            return $this->getBuffer();
        }
    }

    public function stop() {
        if ($this->updating === 1) {
            $content = fopen($this->file, 'w+');
            fputs($content, $this->getBuffer());
            fclose($content);
            ob_get_clean();
            return readfile($this->file);
        } else {
            ob_get_clean();
        }
    }

    private function isValidCache() {
        return ($this->death < (integer) time()) ? false : true;
    }

    private function setCurrentFile() {
        $buffer = $this->pathDir . $this->filePrefix;
        if (is_null($this->fileName)) {
            $buffer .= $this->id;
        } else {
            $buffer .= $this->fileName;
        }
        $buffer .= $this->fileExtension;
        return $buffer;
    }

    private function setComments() {
        $this->fileHeader = "\n" . '<!--------- ' . $this->id . ' ----------->' . "\n";
        $this->fileFooter = "\n" . '<!--------- ' . 'Generated @ : ' . strftime('%c') . ' ----------->' . "\n";
    }

    private function getBuffer() {
        if ($this->htmlComments) {
            $this->buffer = $this->fileHeader;
            $this->buffer .= ob_get_contents();
            $this->buffer .= $this->fileFooter;
        } else {
            $this->buffer = ob_get_contents();
        }
        return $this->buffer;
    }

    public function setOutdatedCache() {
        return touch($this->file, 0);
    }

    private function __setMembers($args) {
        if (is_array($args)) {
            foreach ($args as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } else {
            return false;
        }
    }

    public function __get($args) {
        return $this->$args;
    }

}
