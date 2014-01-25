<div class="col-md-12">
    <div class="col-container">
        <h3>Tags</h3>
        <br>
        <div class="row  bookmarks-tags-list">
            <?php $t = 0 ?>
            <?php foreach(\LibreMVC\Views\Template\ViewBag::get()->bookmarks->tags as $k=>$v) { ?>
                <div class="col-md-2">
                    <div>
                        <a href="tag/<?php echo $k ?>" data-first-letter="<?php echo (isset($k[1])) ? $k[1] : "-" ; ?>">#<?php echo $k ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>