<?php if($_SESSION['User']->login !== 'guest') { ?>
    <script>
        <?php
            echo $this->crud;
        ?>
    </script>
<?php } ?>
<?php
foreach($this->tags as $v) { ?>
    <?php partial(TPL_BOOKMARK_BOOKMARK, \LibreMVC\View\ViewObject::map($v) ); ?>
<?php }; ?>