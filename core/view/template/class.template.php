<?php
namespace LibreMVC\View;

class InvalidTemplateFileException extends \Exception{}
class NotReadableTemplateFileException extends \Exception{}

class Template {

    /**
     * Chemin d'accès au fichier à parser.
     * @vars string
     */
    protected $file;

    /**
     * La représentation sous forme d'une chaine du contenu du fichier.
     * @vars string
     */
    protected $content;

    /**
     * Constructeur de l'objet
     * 
     * Place le contenu du fichier dans l'attribut $content
     */
    public function __construct($filePath) {
        $this->file = $filePath;
        if (!file_exists($this->file)) {
            throw new InvalidTemplateFileException("Template file : $this->file does not exist.");
        } elseif (!is_readable($this->file)) {
            throw new NotReadableTemplateFileException("Template file : $this->file is not readable.");
        } else {
            $this->read();
        }
    }

    /**
     * Lit le contenu du fichier et le place dans l'attribut content
     * 
     * Démarre la temporisation de sortie du buffer, inclus le fichier, récupère
     * et place dans content le contenu du buffer
     * 
     * @return void
     */
    private function read() {
        ob_start();
        include($this->file);
        $this->content = ob_get_contents();
        ob_end_clean();
    }

    public function get() {
        return $this->content;
    }

    public function set( $content ) {
        $this->content = $content;
    }

}
