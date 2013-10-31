<?php
    use \LibreMVC\Mvc\Environnement;
?>
<div class="row">
    <div class="col-md-4">
        <div class="col-container">
            <h3>Mvc</h3>
            <ul>
                <li>controller : <?php echo( LibreMVC\Mvc\Environnement::this()->controller) ?></li>
                <li>action : <?php echo( LibreMVC\Mvc\Environnement::this()->action) ?></li>
                <?php if( count(LibreMVC\Mvc\Environnement::this()->params) >  0 ) { ?>
                <li>Params :
                    <ul>
                        <?php
                            foreach(LibreMVC\Mvc\Environnement::this()->params as $k=>$v) {
                            echo $v;
                        }
                        ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="col-container"><h3>Route</h3>
            <ul>
                <li>Name  : <?php echo (Environnement::this()->routedRoute->name != "") ? Environnement::this()->routedRoute->name : "empty" ?></li>
                <li>Pattern  : <?php echo Environnement::this()->routedRoute->pattern ?></li>
                <li>Type  : <?php echo Environnement::this()->routedRoute->type ?></li>

            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-container">
            <h3>Instance</h3>
            <ul>
                <?php
                    foreach(LibreMVC\Mvc\Environnement::this()->instance as $k=>$v) {
                        echo '<li>'.$k . ' : ' . $v .'</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-container">
            <h3>Base urls</h3>
            <ul>
                <?php
                    foreach(LibreMVC\Mvc\Environnement::this()->baseUrls as $k=>$v) {
                        echo '<li>'.$k . ' : ' . $v .'</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</div>
<h2>Mvc::Environnement</h2>
<?php
    var_dump(\LibreMVC\Views\Template\ViewBag::get()->env);
?>