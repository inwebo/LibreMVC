<?php // var_dump($this) ?>
<div class="bookmarks-list" data-bookmark-id="<?php echo md5( $this->url) ?>" data-bookmark-dt="<?php echo $this->dt ?>" data-bookmark-id-category="<?php echo $this->category ?>" contenteditable="false">
    <dt>
        <!--<img width="16" height="16" src="http://www.inwebo.dev/LibreMVC/assets/img/favicon/<?php echo md5( $this->url) ?>.png">-->
        <a href="<?php echo $this->url ?>"><?php echo stripslashes($this->title) ?></a><p>Ajouté le <?php echo $this->dt; ?></p>
    </dt>
    <dd><?php echo $this->description ?>
        <?php
            $tags = new \LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags($this->tags);
            $tags = $tags->toArray();
        ?>
        <ul>
            <!--<li><span class="label label-info"><a href="tags/"><span class="glyphicon glyphicon-tags"></span> Tags</a></span></li>-->
            <?php foreach($tags as $tag) {?>
                <li><span class="label label-primary"><a href="tag/<?php echo( $tag )?>"><?php echo( $tag )?></a></span></li>
            <?php } ?>
        </ul>
    </dd>
</div>