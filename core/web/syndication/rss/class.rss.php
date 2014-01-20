<?php
namespace LibreMVC\Web\Syndication;

use LibreMVC\Web\Syndication;
use LibreMVC\Web\Syndication\Meta\Rss\Channel;

class Rss extends Syndication {

    protected $title;
    protected $description;
    protected $link;
    protected $version;

    public function __construct($title, $description, $link, $version="2.0"){
        parent::__construct();
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->version = $version;

        // Demo
        $this->nodeFactory();
        echo $this->domDocument->saveXML();
    }

    protected function nodeFactory() {
        $rss = $this->domDocument->createElement('rss');
        $attribut = $this->domDocument->createAttribute('version');
        $attribut->value = $this->version;
        $rss->appendChild($attribut);
        $channel = new Channel();
        $rss->appendChild($channel);

        // Rss
        $this->domDocument->appendChild($rss);
    }

    /**
     * Ajoute un noeud item a la fin de channel
     */
    protected function addItem() {

    }

}