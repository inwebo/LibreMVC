<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <base href="<?php htmlBase() ?>">
</head>
<body>
<h1><a href="<?php htmlBase() ?>">Default site</a></h1>
<ul>
    <?php if(user()->is('Root')){ ?><li><a href="admin/">Admin</a></li><?php } ?>
    <li><a href="login/">Login</a></li>
</ul>
<?php $this->renderPartial('body'); ?>
</body>
</html>
<?php
    echo(getHtmlJsScriptTags());
    echo(getHtmlCssScriptTags());
?>