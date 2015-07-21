<li
    data-bookmark
    data-id="<?php echo $this->bookmark->id ?>"
    data-url="<?php echo $this->bookmark->url ?>"
    data-hash="<?php echo $this->bookmark->hash ?>"
    data-dt="<?php echo $this->bookmark->dt ?>"
    data-title="<?php echo $this->bookmark->title ?>"
    data-desc="<?php echo htmlentities($this->bookmark->description) ?>"
    data-tags="<?php echo $this->bookmark->tags ?>"
    data-isPublic="<?php echo $this->bookmark->isPublic ?>"
>

        <?php if(user()->is('Root')) { ?>
            <h2 class="text-justify">
<span class="bookmark-editor">
            <button data-type="edit" type="button">E</button>
            <button data-type="delete" type="button">X</button>
        </span>
            <a href="<?php echo $this->bookmark->url ?>" target="_blank">
                <?php echo urldecode($this->bookmark->title) ?></a>    </h2>
        <?php }else{ ?>
            <h2 class="text-justify">
            <a href="<?php echo $this->bookmark->url ?>" target="_blank"><?php echo urldecode($this->bookmark->title) ?></a>    </h2>
        <?php } ?>
    <p class="small">
        Ajouté le <?php echo date('d-m-Y T h:m:i', $this->bookmark->dt) ?>
    </p>
    <p>
        <?php echo $this->bookmark->description ?>
    </p>
    <ul data-tags="<?php echo $this->bookmark->tags ?>" class="tagsList">
        <?php $tags = $this->bookmark->getTags(); ?>
        <?php foreach($tags as $tag) {?>
            <li><a href="tag/<?php echo( $tag )?>"><?php echo( $tag )?></a></li>
        <?php } ?>
    </ul>
</li>