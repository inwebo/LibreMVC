<?php
namespace LibreMVC\Modules\Bookmarks\Models;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use LibreMVC\Database\Entity;
use LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags;

/**
 * Description of class
 *
 * @author inwebo
 */
class Bookmark extends Entity{
	
    public $id;
    public $hash;
    public $url;
    public $title;
    public $tags;
    public $description;
    public $dt;
    public $category;
    public $public;
    public $favicon;
	
    public function  __construct( $url, $title = "Bookmark", $tags = "new", $description ="todo", $dt, $category, $public, $favicon ) {
        $this->url = $url;
        $this->hash = md5($this->url);
        $this->title = $title;
        $tags = new Tags($tags);
        $this->tags = $tags->toString();
        $this->description = $description;
        $this->dt = $dt;
        $this->category = $category;
        $this->public = $public;
        //@todo favicon
        //$this->favicon = $favicon;
    }
	
	public function dateHuman() {
		$buffer    = explode( ' ', $this->dt );
		$buffer[0] = implode( '-', array_reverse( explode( '-', $buffer[0] ) ) );
		$buffer    = implode( ' à ', $buffer );
		return $buffer;
	}
	
	public function dateUnix() {
		$date = new DateTime( $this->dt );
		return $date->format('U');
	}
	
	public function faviconEncode() {
		return base64_encode($this->favicon);
	}
	
	public function toNetscapeBookmark() {
		return '<DT><A HREF="'. $this->url .'" ADD_DATE="'. $this->dateUnix() .'" LAST_VISITED="0" ICON="'. $this->faviconEncode() .'">'. $this->title .'</A>' . "\n";
	}

}
