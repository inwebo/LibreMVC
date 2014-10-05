<div class="row">
    <div class="col-xs-12">
    <?php if($_SESSION['User']->login !== 'guest') { ?>
        <script>
            <?php
                echo $this->crud;
            ?>
        </script>
    <?php } ?>
        <div class="starter-template">
            <h1>Actuellement <?php echo $this->bookmarksCount ?> liens en base.</h1>
        </div>
    <?php renderPagination( $this->pagination , 'page/', "active", 11); ?>
        <dl>
            <?php foreach($this->bookmarks as $v) { ?>
                <?php partial(TPL_BOOKMARK_BOOKMARK, \LibreMVC\View\ViewObject::map($v) ); ?>
            <?php } ?>
        </dl>
    <?php renderPagination( $this->pagination , 'page/', "active", 11); ?>
    </div>
</div>