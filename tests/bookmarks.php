<hr>
<?php
ini_set('display_errors', 'on');
include "../core/database/autoload.php";
include('../modules/bookmarks/models/bookmark/tags/class.tags.php');
include('../modules/bookmarks/models/bookmark/class.bookmark.php');
use LibreMVC\Database\Driver\MySql;
try {
    $driver = new MySql('localhost','Bookmarks','root','root');
    $bookmarkClass = "\\LibreMVC\\Modules\\Bookmarks\\Models\\Bookmark";
    \LibreMVC\Modules\Bookmarks\Models\Bookmark::binder($driver,'id','Bookmarks');

    $input = "aze zz ze zz d d aze,rte-r re    , ret  rertre re;:trs dfg";
    $tags = new \LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags($input);
    var_dump($tags->toString());
    $driver->toObject($bookmarkClass);

    $b = \LibreMVC\Modules\Bookmarks\Models\Bookmark::load(1);
    $b->description="test";
    $b->save();
    var_dump($b);
}
catch(\Exception $e) {
    var_dump($e);
}
try {
    $bookmark = \LibreMVC\Modules\Bookmarks\Models\Bookmark::build(1,"http://www.inwebo.dev/",'test','arf; ffsd, d','description');
    $bookmark->save();
}
catch(\Exception $e) {
    echo 'already in db';
}
?>


<hr>