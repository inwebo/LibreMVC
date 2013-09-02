<!-- One bookmark -->
<li class="oneBookmark" data-hash="<?php //echo $row->hash; ?>" data-id="<?php //echo $row -> id; ?>" data-dt="<?php echo ViewBag::get()->bookmark['dt']; ?>" data-tags="<?php echo $row -> tagsAsString; ?>" data-category="<?php echo ViewBag::get()->bookmark['category']; ?>" data-visibility="<?php echo ViewBag::get()->bookmark['public']; ?>">
    <h4><img src="<?php //echo $row->favicon; ?>" title="favicon">&nbsp;<a href="<?php echo ViewBag::get()->bookmark['url'] ?>"><span class="data-title"><?php echo stripcslashes(ViewBag::get()->bookmark['title']); ?></span></a></h4>
    <p class="data-desc"><?php echo stripcslashes(ViewBag::get()->bookmark['description']); ?></p>
    <ul class="meta">
        <?php foreach (explode(' ',ViewBag::get()->bookmark['tags']) as $key => $value) { ?>
            <li class="tags"><a href="<?php echo PATH_TAGS . $value ?>"><?php echo $value ?></a></li>
        <?php } ?>
    </ul>
</li>
<!-- /One bookmark -->