<div class="col-md-12">
    <div class="col-container">
        <h3>Tags</h3>
        <br>
        <div class="text-center">
            <div class="btn-group btn-group-sm ">
                <button type="button" class="btn btn-default active">All</button>
                <button type="button" class="btn btn-default">0-9</button>
                <button type="button" class="btn btn-default">A</button>
                <button type="button" class="btn btn-default">B</button>
                <button type="button" class="btn btn-default">C</button>
                <button type="button" class="btn btn-default">D</button>
                <button type="button" class="btn btn-default">E</button>
                <button type="button" class="btn btn-default">F</button>
                <button type="button" class="btn btn-default">G</button>
                <button type="button" class="btn btn-default">H</button>
                <button type="button" class="btn btn-default">I</button>
                <button type="button" class="btn btn-default">J</button>
                <button type="button" class="btn btn-default">K</button>
                <button type="button" class="btn btn-default">L</button>
                <button type="button" class="btn btn-default">M</button>
                <button type="button" class="btn btn-default">N</button>
                <button type="button" class="btn btn-default">O</button>
                <button type="button" class="btn btn-default">P</button>
                <button type="button" class="btn btn-default">Q</button>
                <button type="button" class="btn btn-default">R</button>
                <button type="button" class="btn btn-default">S</button>
                <button type="button" class="btn btn-default">Y</button>
                <button type="button" class="btn btn-default">U</button>
                <button type="button" class="btn btn-default">V</button>
                <button type="button" class="btn btn-default">W</button>
                <button type="button" class="btn btn-default">X</button>
                <button type="button" class="btn btn-default">Y</button>
                <button type="button" class="btn btn-default">Z</button>
            </div>
        </div>
        <br>
        <div class="row  bookmarks-tags-list">
            <?php $t = 0 ?>
            <?php foreach(\LibreMVC\Views\Template\ViewBag::get()->bookmarks->tags as $k=>$v) { ?>
                <div class="col-md-2">
                    <div>
                        <a href="bookmarks/tag/<?php echo $k ?>">#<?php echo $k ?><span class="badge badge-info"><?php echo $v ?></span> </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>