<html>
<head><title>Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
<h1 id="example">LibreMVC</h1>
<ul>
    {loop="$menus"}
    <li> <a href="http://www.inwebo.dev/LibreMVC/{$value}">{$value}</a></li>
    {/loop}
</ul>
<?php LibreMVC\Views::render(LibreMVC\Mvc\Environnement::this()->viewPath); ?>
<footer>
    Inwebo
</footer>
</body>
</html>