<li
    data-bookmark
    data-id="<?php echo $this->bookmark->id ?>"
    data-url="<?php echo $this->bookmark->url ?>"
    data-hash="<?php echo $this->bookmark->hash ?>"
    data-dt="<?php echo $this->bookmark->dt ?>"
    data-title="<?php echo $this->bookmark->title ?>"
    data-desc="<?php echo $this->bookmark->description ?>"
    data-tags="<?php echo $this->bookmark->tags ?>"
    data-public="<?php echo $this->bookmark->public ?>"
>
    <h2>
        <?php if(user()->is('Root')) { ?>
        <span class="bookmark-editor">
            <button data-type="edit" type="button">E</button>
            <button data-type="delete" type="button">X</button>
        </span>
        <?php } ?>
        <a href="<?php echo $this->bookmark->url ?>" target="_blank"><?php echo $this->bookmark->title ?></a>
    </h2>
    <p>
        <?php echo $this->bookmark->description ?>
    </p>
    <ul data-tags="<?php echo $this->bookmark->tags ?>">
        <?php $tags = $this->bookmark->getTags(); ?>
        <?php foreach($tags as $tag) {?>
            <li><a href="tag/<?php echo( $tag )?>"><?php echo( $tag )?></a></li>
        <?php } ?>
    </ul>
</li>