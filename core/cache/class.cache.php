<?php

namespace LibreMVC;

use Exception;

class CacheException extends \Exception{};

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
     * Chemin d'accés au répertoire contenant les fichiers de cache 
     * @var string
     */
    public $path;

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

    public $htmlCommentsHeader;
    public $htmlCommentsFooter;

    /**
     * Le fichier cache est il à jour
     * @var bool
     */
    private $updating = false;

    public function __construct($params = array()) {
        $this->__setMembers($params);
        $this->file = $this->path . $this->id;

        if (!file_exists($this->path)) {
            throw new CacheException('Dir ' . $this->path . ' doesn\'t exists ');
        } elseif (!is_writable($this->path)) {
            throw new CacheException('Dir ' . $this->path . ' isn\'t writable ');
        } elseif (file_exists($this->file) && !is_writable($this->file)) {
            throw new CacheException('File ' . $this->file . ' isn\'t writable ');
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

    private function setComments() {
        $this->htmlCommentsHeader = "\n" . '<!-- ' . $this->id . ' -->' . "\n";
        $this->htmlCommentsFooter = "\n" . '<!-- ' . 'Generated @ : ' . strftime('%c') . ' -->' . "\n";
    }

    private function getBuffer() {
        if ($this->htmlComments) {
            $buffer = ob_get_contents();
            $buffer = str_replace('<head>', '<head>' . $this->htmlCommentsHeader, $buffer);
            $buffer = str_replace('</body>', $this->htmlCommentsFooter . "</body>" , $buffer);
            $this->buffer = $buffer;
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
