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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link rel="stylesheet" href="http://www.inwebo.dev/LibreMVC/sites/default/themes/default/css/gumby.css">
    <link rel="stylesheet" href="themes/default/css/style.css">
    <base href="<?php echo ViewBag::get()->meta->baseUrl; ?>">
    <?php
    foreach (\LibreMVC\Html\Helpers\Includer\Css::this()->assets->css as $css) {
        echo "<link rel='stylesheet' href='". Environnement::this()->instance->baseUrl . Environnement::this()->paths["base_themes"] ."default/$css'>";
        }
    ?>
</head>
<body>
<header>
    <h1 id="example">LibreMVC</h1>
    <nav>
        <ul>
        {loop="$menus"}
        <li> <a href="{$value}">{$value}</a></li>
        {/loop}
        </ul>
    </nav>
</header>
<?php Views::render( Environnement::this()->viewPath ); ?>
<?php
foreach (\LibreMVC\Html\Helpers\Includer\Css::this()->assets->js as $js) {
    echo "<script href='". Environnement::this()->instance->baseUrl . Environnement::this()->paths["base_themes"] ."default/$js'>"."\n";
}
?>
<footer>
    Inwebo | LibreMVC framework Août 2013
</footer>
</body>
</html>