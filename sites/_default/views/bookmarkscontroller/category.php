<h2>Bookmarks</h2>
page :
<?php

$total = ViewBag::get()->totalPages;
for($i=1;$i<=$total;$i++) {
echo '<a href="http://www.inwebo.dev/LibreMVC/bookmarks/category/'.ViewBag::get()->categoryId.'/page/'.$i.'">'.$i.'</a>';
}
?>

<?php //echo LibreMVC\Core\Views\ViewBag::get()->pageTotal ?>

<ul>
    <?php
    echo '<h3>'. ViewBag::get()->categoryName .'</h3><dl>';
    foreach(\LibreMVC\Core\Views\ViewBag::get()->bookmarks as $k => $value) {
        echo '<dt><a href="'.$value['url'].'">'. $value['title'] .'</a></dt>';
        echo '<dl>'."\t".$value['description'].'</dl>';

        echo '</dl>';
    }
    ?>
</ul>