<?php
    use LibreMVC\Views;
    use LibreMVC\Views\Template\ViewBag;
    use LibreMVC\Mvc\Environnement;
/*
    $user = new \LibreMVC\Models\User();
    $a = \LibreMVC\Models\User::getById(1);
    var_dump($a);

    $c = \LibreMVC\Models\User::isValidUser('inwebo', 'inwebo');
    var_dump($c);

    $inwebo = new \LibreMVC\Models\User(1);

    var_dump($inwebo);
*/
?>
<html>
<head>
    <title><?php echo ViewBag::get()->meta->title ?></title>
    <meta name="description" content="<?php echo ViewBag::get()->meta->description ?>">
    <meta name="keywords" content="<?php echo ViewBag::get()->meta->keywords ?>">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <base href="<?php echo ViewBag::get()->meta->baseUrl; ?>">
    <?php

    foreach (Environnement::this()->Theme->assets->css as $css) {
        echo $css;
        }

    ?>
    <?php

    foreach (Environnement::this()->Theme->assets->js as $js) {
        echo $js;
    }

    ?>
</head>
<body>
<header>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Bookmarks</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav pull-right">
                    {loop="$menus"}
                    <li> <a href="{$value}">{$value}</a></li>
                    {/loop}
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</header>
<div id="parallax-wrapper">
    <div class="container">
        <div class="starter-template">
            <h1>Annuaire</h1>
            <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <?php
                    var_dump(ViewBag::get()->breadcrumbs);
                        foreach( ViewBag::get()->breadcrumbs->items as $k => $v ) {
                            if($v==="") {
                                echo '<li>'.$k.'</li>';
                            }
                            else {
                                echo '<li><a href="'.$v.'">'.$k.'</a></li>';
                            }

                        }
                    ?>
                </ol>
            </div>
                    <?php Views::render( Environnement::this()->viewPath ); ?>

        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-10"><div class="col-container"><p>Lorem</p></div></div>
            <div class="col-md-2"><div class="col-container text-center"><a class="footer-backtotop" href="">TOP</a> </div></div>
        </div>
    </div>
</footer>
</body>
</html>