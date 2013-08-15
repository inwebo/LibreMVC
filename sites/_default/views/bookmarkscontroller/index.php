<?php

use LibreMVC\Views\Template\ViewBag;

?>
<h2><a href="bookmarks/">Bookmarks</a></h2>

    <?php
    $i=1;
    foreach(ViewBag::get()->categories as $id => $categorie) {
        echo '<h2><a href="bookmarks/category/' . $categorie['id']  .  '">'. $categorie['name'] .'</a></h2><ul>';
        foreach(ViewBag::get()->bookmarks->$categorie['name'] as $k => $v) {
            echo '<li><a href="bookmarks/'.$v['url'].'">'.$v['title'].'</a></li>';
        }
        echo '</ul>';
    }

    ?>
