<?php
    use LibreMVC\Views;
    use LibreMVC\Views\Template\ViewBag;
    use LibreMVC\Mvc\Environnement;

    $user = new \LibreMVC\Models\User();
    $a = \LibreMVC\Models\User::getById(1);
    var_dump($a);

    $c = \LibreMVC\Models\User::isValidUser('inwebo', 'inwebo');
    var_dump($c);

    $inwebo = new \LibreMVC\Models\User(1);

    var_dump($inwebo);
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


    <div class="row navbar unfixed" id="nav1">
        <!-- Toggle for mobile navigation, targeting the <ul> -->
        <a class="toggle" gumby-trigger="#nav1 > .row > ul" href="#"><i class="icon-menu"></i></a>
        <h1 class="four columns logo">
            <a href="#">
                LibreMVC
            </a>
        </h1>
        <ul class="eight columns">
            {loop="$menus"}
            <li> <a href="{$value}">{$value}</a></li>
            {/loop}
        </ul>
    </div>

    <nav>
        <ul>

        </ul>
    </nav>
</header>
<div class="example-grid grid">
    <div class="row">
        <div class="fourteen columns">
<?php Views::render( Environnement::this()->viewPath ); ?>
        </div>
    </div>
</div>

<footer>
    Inwebo | LibreMVC framework Août 2013
</footer>
</body>
</html>