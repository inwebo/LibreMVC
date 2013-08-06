<h2>Bookmarks</h2>
page :
<?php
$total = ViewBag::get()->totalPages;
for($i=1;$i<=$total;$i++) {
echo '<a href="http://www.inwebo.dev/LibreMVC/bookmarks/category/'.ViewBag::get()->categoryId.'/page/'.$i.'">'.$i.'</a> ';
}
?>

<h3>{$categoryName}</h3>
<dl>
    <?php foreach(ViewBag::get()->bookmarks as $k => $value) { ?>
    <dt><a href="<?php echo $value['url'] ?>"><?php echo $value['title'] ?></a></dt><dd><?php echo $value['description'] ?></dd>
    <?php } ?>
</dl>