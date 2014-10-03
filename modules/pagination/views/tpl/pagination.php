<ul class="pagination">
    <li><a href="<?php echo $this->baseUri . $this->min; ?>">&laquo;</a></li>
    <?php if( $this->hasPrev ) { ?>
        <li><a href="<?php echo $this->baseUri . $this->prev; ?>">&LeftArrow;</a></li>
    <?php } ?>
    <?php for($v =$this->interval->start;$v <= $this->interval->stop ;$v++) { ?>
    <li class="<?php echo (($v == $this->index) ? $this->activeClass : "") ; ?>"><a href="<?php echo $this->baseUri . $v; ?>" ><?php echo $v ?></a></li>
    <?php } ?>
    <?php if( $this->hasNext ) { ?>
        <li><a href="<?php echo $this->baseUri . $this->next; ?>">&rightarrow;</a></li>
    <?php } ?>
    <li><a href="<?php echo $this->baseUri . $this->max; ?>">&raquo;</a></li>
</ul>