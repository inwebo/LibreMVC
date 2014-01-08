<?php
use LibreMVC\Views\Template\ViewBag;
?>

<div data-bookmark-id="<?php echo md5( ViewBag::get()->bookmarks->current->url) ?>" data-bookmark-dt="<?php echo ViewBag::get()->bookmarks->current->dt ?>" data-bookmark-id-category="<?php echo ViewBag::get()->bookmarks->current->category ?>">
    <dt>
        <img width="16" height="16" src="http://www.inwebo.dev/LibreMVC/assets/img/favicon/<?php echo md5( ViewBag::get()->bookmarks->current->url) ?>.png">
        <a href="<?php echo ViewBag::get()->bookmarks->current->url ?>"><?php echo stripslashes(ViewBag::get()->bookmarks->current->title) ?></a>
                                <span class="bookmark-panel">
                                    <span class="label label-danger pull-right"><a href="">X</a></span>
                                    <span class="label label-info pull-right"><a href="">Edit</a></span>
                                </span>

    </dt>
    <dd><?php echo ViewBag::get()->bookmarks->current->description ?>
        <?php
            $tags = new \LibreMVC\Modules\Bookmarks\Models\Bookmark\Tags(ViewBag::get()->bookmarks->current->tags);
            $tags = $tags->toArray();
        ?>
        <ul class="">
            <li><span class="label label-info"><a href="tags/"><span class="glyphicon glyphicon-tags"></span> Tags</a></span></li>
            <?php foreach($tags as $tag) {?>
                <li><span class="label label-primary"><a href="tag/<?php echo( $tag )?>"><?php echo( $tag )?></a></span></li>
            <?php } ?>
        </ul>
    </dd>
</div>