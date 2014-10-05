<div class="row">
    <div class="col-md-12">
<?php if($_SESSION['User']->login !== 'guest') { ?>
    <script>
        <?php
            echo $this->crud;
        ?>
    </script>
<?php } ?>
    <div class="starter-template">
        <h1><?php echo $this->total ?> résultats.</h1>
    </div>
<?php
foreach($this->tags as $v) { ?>
    <?php partial(TPL_BOOKMARK_BOOKMARK, \LibreMVC\View\ViewObject::map($v) ); ?>
<?php }; ?>
    </div></div>