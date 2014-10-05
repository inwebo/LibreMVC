<div class="bookmarks-list" data-bookmark-id="<?php echo md5( $this->url) ?>" data-bookmark-dt="<?php echo $this->dt ?>" data-bookmark-id-category="<?php echo $this->category ?>" contenteditable="false">
    <dt>
        <?php if($_SESSION['User']->login !== 'guest') { ?>
            <div class="bookmark-editor">
                <button type="button" class="bookmark-edit btn btn-warning btn-xs">E</button>
                <button type="button" class="bookmark-delete btn btn-danger btn-xs">X</button>
            </div>
        <?php } ?>
        <h2><a href="<?php echo $this->url ?>"><?php echo stripslashes($this->title) ?></a><p><small>Ajouté le <?php echo $this->dt; ?></small></p></h2>
    </dt>
    <dd>
        <p>
        <?php echo $this->description ?>
            <?php
                $tags = new \LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags($this->tags);
                $tags = $tags->toArray();
            ?>
        </p>
        <ul>
            <?php foreach($tags as $tag) {?>
                <li><span class="label label-primary"><a href="tag/<?php echo( $tag )?>"><?php echo( $tag )?></a></span></li>
            <?php } ?>
        </ul>
    </dd>
</div>