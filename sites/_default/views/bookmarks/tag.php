<h3><?php echo $this->tag ?> <?php echo $this->total ?></h3>
<ul>
    <?php foreach($this->bookmarks as $bookmark) { ?>
        <li><a href="<?php echo $bookmark->url ?>"><?php echo $bookmark->title ?></a></li>
    <?php } ?>
</ul>