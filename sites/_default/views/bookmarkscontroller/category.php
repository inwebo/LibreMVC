<h2>Bookmarks</h2>
<?php
$total = ViewBag::get()->totalPages;
$menus = "";
for($i=1;$i<=$total;$i++) {
$menus .= '<a href="bookmarks/category/'.ViewBag::get()->categoryId.'/page/'.$i.'">'.$i.'</a> ';
}
echo $menus;
?>
<h3>{$categoryName}</h3>
<ul>
    <?php foreach(ViewBag::get()->bookmarks as $k => $value) { ?>
        <?php \LibreMVC\Views\Template\ViewBag::get()->bookmark = $value; ?>
        <?php include(TPL_BOOKMARK); ?>
    <!--<dt><a href="<?php echo $value['url'] ?>"><?php echo stripcslashes($value['title']) ?></a></dt><dd><?php echo stripcslashes($value['description']) ?></dd>-->
    <?php } ?>
</ul>
<?php
echo $menus;
?>
