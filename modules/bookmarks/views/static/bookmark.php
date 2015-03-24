<li
    data-id="<?php echo $this->bookmark->id ?>"
    data-hash="<?php echo $this->bookmark->hash ?>"
    data-dt="<?php echo $this->bookmark->dt ?>"
    contenteditable="false"
>
    <h2  contenteditable="false">
        <?php if(user()->is('Root')) { ?>
        <span class="bookmark-editor">
            <button data-type="edit" type="button">E</button>
            <button data-type="delete" type="button">X</button>
        </span>

        <?php } ?>
        <a href="<?php echo $this->bookmark->url ?>" target="_blank"><?php echo $this->bookmark->title ?></a>
    </h2>
    <p contenteditable="false">
        <?php echo $this->bookmark->description ?>
    </p>
    <ul data-tags="<?php echo $this->bookmark->tags ?>" contenteditable="false">
        <?php $tags = $this->bookmark->getTags(); ?>
        <?php foreach($tags as $tag) {?>
            <li><a href="tag/<?php echo( $tag )?>"><?php echo( $tag )?></a></li>
        <?php } ?>
    </ul>
</li>
<?php
    // If loaded === false -> post
    // if loaded === true   -> update
?>