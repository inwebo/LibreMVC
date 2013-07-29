<h2>Bookmarks</h2>
<ul>
    <?php
    foreach(\LibreMVC\Core\Views\ViewBag::get()->bookmarks as $k => $value) {
        echo '<h2>'. $k .'</h2><ul>';
        foreach($value as $k => $v) {
            echo '<li>'.$v['title'].'</li>';
        }

        echo '</ul>';
    }
    ?>
</ul>