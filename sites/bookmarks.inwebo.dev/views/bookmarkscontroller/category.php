<?php
use LibreMVC\Views\Template\ViewBag;
$pagination = ViewBag::get()->bookmarks->pagination;
?>
<?php if($_SESSION['User']->login !== 'guest') { ?>
    <script></script>
<?php } ?>

<div class="text-center">
    <ul class="pagination pagination-sm pagination">
        <?php
            echo '<li><a href="category/' . ViewBag::get()->bookmarks->categories->current->id . '/page/'. $pagination->min .'">&laquo;</a></li>';
        ?>
        <?php
            $j = $pagination->min;
            while($j <= $pagination->max) {
                $active = ($j==$pagination->index) ? ' class="active" ' : '';
                echo '<li'. $active .'><a href="category/' . ViewBag::get()->bookmarks->categories->current->id . '/page/'. $j .'">'. $j .'</a></li>';
                ++$j;
            }
        ?>
        <?php
            echo '<li><a href="category/' . ViewBag::get()->bookmarks->categories->current->id . '/page/'. $pagination->max .'">&raquo;</a></li>';
        ?>
    </ul>
</div>
<div class="col-md-12">
    <div class="col-container">
    <h3>
        <a href="category/<?php echo ViewBag::get()->bookmarks->categories->current->id?>"><?php echo ViewBag::get()->bookmarks->categories->current->name ?></a> <span class="badge"><?php echo ViewBag::get()->bookmarks->categories->current->total ?></span></h3>
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