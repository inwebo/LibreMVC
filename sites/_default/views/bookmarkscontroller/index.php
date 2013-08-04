<h2>Bookmarks</h2>
<ul>
    <?php
    $i=1;
    foreach(\LibreMVC\Core\Views\ViewBag::get()->bookmarks as $k => $value) {
        echo '<h2><a href="category/' . $i++ . '' . '">'. $k .'</a></h2><ul>';
        foreach($value as $k => $v) {
            echo '<li><a href="'.$v['url'].'">'.$v['title'].'</a></li>';
        }

        echo '</ul>';
    }
    ?>
</ul>