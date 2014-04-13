<?php
//var_dump($this);

foreach ($this->tags->toArray() as $v) {
    ?>
    <a href="bookmarks/tag/<?php echo $v ?>"><?php echo $v ?></a>
<?php
}
?>