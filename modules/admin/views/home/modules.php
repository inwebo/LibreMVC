<h3>Modules</h3>
<h4>Available</h4>
<ul>
    <?php foreach($this->available as $v) { ?>
        <li><?php echo $v ?></li>
    <?php } ?>
</ul>


<h4>Enabled</h4>
<ul>
    <?php foreach($this->enabled as $v) { ?>
        <li><?php echo $v->getName() ?></li>
    <?php } ?>
</ul>

