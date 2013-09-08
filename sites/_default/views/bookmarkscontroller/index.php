<?php
use LibreMVC\Views\Template\ViewBag;
?>
<?php

    foreach(ViewBag::get()->bookmarks->categories as $name => $categorie ) {
        ViewBag::get()->bookmarks->categories->current = $categorie;
        include(TPL_BOOKMARK_CATEGORY);
    }
?>