<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <base href="<?php htmlBase() ?>">
    <?php
    echo(getHtmlJsScriptTags());
    echo(getHtmlCssScriptTags());
    ?>
    <style>
        body {
            background: url(../sites/_default/assets/img/logo.svg) no-repeat center center fixed;
            background-color: #101010;
        }
        body * {
            display: none;
        }
    </style>
</head>
<body>
<h1><a href="<?php htmlBase() ?>">inwebo veritas</a></h1>
<ul>
    <?php if(user()->is('Root')){ ?><li><a href="admin/">Admin</a></li><?php } ?>
    <li><a href="login/">Login</a></li>
</ul>
<?php $this->renderPartial('body'); ?>

</body>
</html>
