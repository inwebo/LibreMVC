<?php
use LibreMVC\Views\Template\ViewBag;
?>
<div class="col-md-12">
    <div class="col-container">
    <h3>
        <a href="bookmarks/category/<?php echo ViewBag::get()->bookmarks->categories->current->id?>"><?php echo ViewBag::get()->bookmarks->categories->current->name ?></a> <span class="badge"><?php echo ViewBag::get()->bookmarks->categories->current->total ?></span><span class="label label-warning pull-right">RSS</span></h3>
        <dl class="bookmarks-list ">

                <?php
                    ViewBag::get()->bookmarks->current ="";
                    foreach(ViewBag::get()->bookmarks->categories->current->bookmarks as $bookmark) {
                        ViewBag::get()->bookmarks->current = (object)$bookmark;
                        include(TPL_BOOKMARK_BOOKMARK);
                    }
                ?>
        </dl>
    </div>
</div>
