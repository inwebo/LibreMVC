<?php
namespace LibreMVC\Modules\Bookmarks\Models {

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
        public $id_user = 1;
        public $public = 1;

        static public function build($idUser, $url, $title , $tags, $description, $public=true){
            $bookmark = new Bookmark();
            $bookmark->hash = md5($url);
            $bookmark->url = $url;
            $bookmark->title = $title;
            $tags = new Tags($tags);
            $bookmark->tags = $tags->toString();
            $bookmark->description = $description;
            $bookmark->dt = $_SERVER['REQUEST_TIME'];
            $bookmark->id_user = $idUser;
            $bookmark->public = $public;
            return $bookmark;
        }

        public function getTags() {
            $tags = new Tags($this->tags);
            return $tags->toArray();
        }

        public function dateUnix() {
            $date = new \DateTime( $this->dt );
            return $date->format('U');
        }

        public function toSqlTimeStamp() {
            $date = new \DateTime( $this->dt );
            return $date->format('Y:m:d H:i:s');
        }

        public function faviconEncode() {
            return base64_encode($this->favicon);
        }

        public function toNetscapeBookmark() {
            return '<DT><A HREF="'. $this->url .'" ADD_DATE="'. $this->dateUnix() .'" LAST_VISITED="0" ICON="'. $this->faviconEncode() .'">'. $this->title .'</A>' . "\n";
        }

    }
}
