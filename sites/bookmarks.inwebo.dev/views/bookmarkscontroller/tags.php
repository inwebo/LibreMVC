<div class="row">
    <div class="col-md-12">
<div class="starter-template">
    <h1>Actuellement <?php echo $this->total ?> tags en base.</h1>
</div>
        <div class="bookmarks-list">
<ul>
<?php foreach ($this->tags->toArray() as $v) { ?>
    <li><span class="label label-primary"><a href="tag/<?php echo( $v )?>"><?php echo( $v )?></a></span></li>
<?php } ?>
</ul>
    </div></div>
</div>