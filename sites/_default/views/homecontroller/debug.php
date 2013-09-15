<div class="row">
    <div class="col-md-4">
        <div class="col-container">
            <h3>Mvc::Environnement</h3>
            <ul>
                <li><?php var_dump( LibreMVC\Mvc\Environnement::this()->routedRoute) ?></li>
            </ul>
        </div>
    </div>
    <div class="col-md-4"><div class="col-container"><h3>Distribution par domaine</h3><p>Distribution par domaine</p></div></div>
    <div class="col-md-4"><div class="col-container"><h3>Stats</h3><p>Lorem</p></div></div>
</div>
<h2>Mvc::Environnement</h2>
<?php
    var_dump(\LibreMVC\Views\Template\ViewBag::get()->env);
?>