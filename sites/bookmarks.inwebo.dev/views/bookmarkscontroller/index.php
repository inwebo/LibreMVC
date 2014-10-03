<?php if($_SESSION['User']->login !== 'guest') { ?>
    <script>
        <?php
            echo $this->crud;
        ?>
    </script>
<?php } ?>
<?php renderPagination( $this->pagination , 'page/', "active", 11); ?>
<?php
foreach($this->bookmarks as $v) { ?>
    <?php partial(TPL_BOOKMARK_BOOKMARK, \LibreMVC\View\ViewObject::map($v) ); ?>
<?php } ?>
<?php renderPagination( $this->pagination , 'page/', "active", 11); ?>