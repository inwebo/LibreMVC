<ul>
<?php foreach ($this->tags->toArray() as $v) { ?>
    <li><a href="tag/<?php echo $v ?>"><?php echo $v ?></a></li>
<?php } ?>
</ul>