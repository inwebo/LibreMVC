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
    <?php css() ?>
    <?php js()  ?>
    <?php
        echo ViewBag::get()->JsConfig;
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php
                                foreach(ViewBag::get()->categories as $k => $v) {
                                    echo '<li><a href="category/' . $v['id'] . '">' . $v['name'] . '</a></li>';
                                }
                            ?>
                        </ul>
                    </li>
                    {loop="$menus"}
                    <li> <a href="{$value}">{$key}</a></li>
                    {/loop}
                    <?php if($_SESSION['User']->login === 'guest') { ?>
                        <li><a href="/login">Login</a></li>
                    <?php } else {?>
                        <li><a href="/login">Logout : "<em><?php echo $_SESSION['User']->login ?></em>"</a></li>
                    <?php } ?>


                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</header>
<div id="parallax-wrapper">
    <div class="container">

<br>
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
