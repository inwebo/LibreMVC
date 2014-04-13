<?php
//var_dump($this->bookmarks);?>
<?php renderPagination( $this->pagination , 'bookmarks/', "active"); ?>
<?php
foreach($this->bookmarks as $v) { ?>
    <?php //var_dump(is_file(TPL_BOOKMARK_BOOKMARK)) ?>
    <?php partial(TPL_BOOKMARK_BOOKMARK, \LibreMVC\View\ViewObject::map($v) ); ?>
<?php } ?>
<?php renderPagination( $this->pagination , 'bookmarks/', "active"); ?>