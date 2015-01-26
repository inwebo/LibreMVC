<h2>tags <?php echo $this->total ?></h2>
<ul>
    <?php foreach($this->tags as $tag) { ?>
        <li><a href="tag/<?php echo $tag ?>"><?php echo $tag ?></a></li>
    <?php } ?>
</ul>
