<?php
    use LibreMVC\Views;
    use LibreMVC\Views\Template\ViewBag;
    use LibreMVC\Mvc\Environnement;
?>
<html>
<head>
    <title><?php echo ViewBag::get()->meta->title ?></title>
    <meta name="description" content="<?php echo ViewBag::get()->meta->description ?>">
    <meta name="keywords" content="<?php echo ViewBag::get()->meta->keywords ?>">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <base href="<?php echo ViewBag::get()->meta->baseUrl; ?>">
    <?php css() ?>
    <?php js()  ?>
    <?php echo ViewBag::get()->JsConfig; ?>
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
                <a class="navbar-brand" href="#">LibreMVC</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li> <a href="debug/">Debug</a></li>
                    <li> <a href="login/">Login</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</header>
<div id="parallax-wrapper">
    <div class="container">
        <div class="starter-template">
            <h1>Welcome <?php echo \LibreMVC\Sessions::get('User')->login ?></h1>
            <p class="lead">Default index page.</p>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="breadcrumbs" data-spy="affix" data-offset-top="100">
                        <ol class="breadcrumb">
                            <?php

                                foreach( ev()->BreadCrumbs->items as $k => $v ) {
                                    if($v=="") {
                                        echo '<li>'.$k.'</li>';
                                    }
                                    else {
                                        echo '<li><a href="'.$v.'">'.$k.'</a></li>';
                                    }
                                }
                            ?>
                        </ol>
                    </div>
                </div>
        </div>
        <?php
            if( ViewBag::get()->errors != null ) {
                var_dump(ViewBag::get()->errors);
                foreach( ViewBag::get()->errors as $k => $v ) {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-container">
                                <h4>Error</h4>
                                <p><?php echo $v->errstr; ?></p>
                                <ul>
                                    <li>No : <?php echo $v->errno; ?></li>
                                    <li>File : <?php echo $v->errfile; ?></li>
                                    <li>Line : <?php echo $v->errline; ?></li>
                                </ul>
                                <?php
                                var_dump($v->errcontext);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }
        ?>
        <?php Views::render( Environnement::this()->viewPath ); ?>
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