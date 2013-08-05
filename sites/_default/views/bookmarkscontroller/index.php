<?php

use LibreMVC\Views\Template\ViewBag;

?>
<h2>Bookmarks</h2>
<ul>
    <?php
    $i=1;
    foreach(ViewBag::get()->bookmarks as $k => $value) {
        echo '<h2><a href="category/' . $i++ . '' . '">'. $k .'</a></h2><ul>';
        foreach($value as $k => $v) {
            echo '<li><a href="'.$v['url'].'">'.$v['title'].'</a></li>';
        }

        echo '</ul>';
    }
    ?>
</ul>
