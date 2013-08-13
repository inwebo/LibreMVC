<h2>Bookmarks</h2>
page :
<?php
$total = ViewBag::get()->totalPages;
for($i=1;$i<=$total;$i++) {
echo '<a href="'.\LibreMVC\Http\Context::getServer(true,true) .\LibreMVC\Http\Context::getBaseUri() . 'bookmarks/category/'.ViewBag::get()->categoryId.'/page/'.$i.'">'.$i.'</a> ';
}
//@todo fixer ceci dans les segments
echo (int) "01"==1;
?>

<h3>{$categoryName}</h3>
<dl>
    <?php foreach(ViewBag::get()->bookmarks as $k => $value) { ?>
    <dt><a href="<?php echo $value['url'] ?>"><?php echo stripcslashes($value['title']) ?></a></dt><dd><?php echo stripcslashes($value['description']) ?></dd>
    <?php } ?>
</dl>
<?php
$total = ViewBag::get()->totalPages;
for($i=1;$i<=$total;$i++) {
    echo '<a href="'.\LibreMVC\Http\Context::getServer(true,true) .\LibreMVC\Http\Context::getBaseUri() . 'bookmarks/category/'.ViewBag::get()->categoryId.'/page/'.$i.'">'.$i.'</a> ';
}
?>
