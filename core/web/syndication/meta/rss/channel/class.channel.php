<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 18/01/14
 * Time: 16:20
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Web\Syndication\Meta\Rss;

/**
 * Class RssChannel
 *
 * Est un DOMFragement contenant des DOMFragments provenant d'une classe de description Meta
 *
 * Pour chaque elt de METE on crée un DOMFragment avec comme valeur la valeur de l'instance courante.
 *
 * @package LibreMVC\Web\Syndication\Meta\Rss
 */
class Channel {

    public $title;
    public $link;
    public $description;

    public $language;
    public $copyright;
    public $managingEditor;
    public $webMaster;
    public $pubDate;
    public $lastBuildDate;
    public $category;
    public $generator;
    public $docs = "http://blogs.law.harvard.edu/tech/rss";
    public $ttl;
    public $image;
    public $rating;
    public $skipHours;
    public $skipDays;

    public function __construct() {
        $dom = new \DOMDocument;
        $channel = $dom->createElement('channel');
        $title = $dom->createElement('title', $this->title);
        $channel->appendChild($title);


        return $channel;
    }

}