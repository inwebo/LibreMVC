<html>
<head>
    <title><?php echo \LibreMVC\Views\Template\ViewBag::get()->meta->title ?></title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <base href="<?php echo \LibreMVC\Views\Template\ViewBag::get()->meta->baseUrl; ?>">
</head>
<body>
<header>
    <h1 id="example">LibreMVC</h1>
    <nav>
        {loop="$menus"}
        <li> <a href="{$value}">{$value}</a></li>
        {/loop}
    </nav>
</header>
<?php LibreMVC\Views::render( LibreMVC\Mvc\Environnement::this()->viewPath ); ?>
<footer>
    Inwebo | LibreMVC framework Août 2013
</footer>
</body>
</html>