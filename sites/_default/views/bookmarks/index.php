<?php

/**
 * $this->total         : Total bookmarks
 * $this->bookmarks     : Les bookmarks paginés
 * $this->pagination    : Informations pages paginées.
 */

?>
<h3>Bookmarks <?php echo $this->total ?></h3>
<ul>
    <?php for($i=1;$i < $this->pagination->max;$i++) { ?>
        <li><a href="bookmarks/page/<?php echo $i ?>"><?php echo $i ?></a></li>
    <?php } ?>
</ul>
<ul>
<?php foreach($this->bookmarks as $bookmark) { ?>
    <li><a href="<?php echo $bookmark->url ?>"><?php echo $bookmark->title ?></a></li>
<?php } ?>
</ul>