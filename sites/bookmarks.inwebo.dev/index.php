<?php //var_dump($this) ?>
<html>
<head>
    <title><?php echo $this->_head->title ?></title>
    <meta name="description" content="<?php echo $this->_meta->description ?>">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <base href="<?php getBaseHref(); ?>">
    <link type="text/css" rel="stylesheet" href="<?php baseCss(); ?>bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php instanceCss(); ?>style.css">
    <?php foreach(ev()->css as $k => $v) { ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $v; ?>">
    <?php } ?>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
<header>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Bookmarks</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li> <a href="tags/">Tags</a></li>
                    <?php if($_SESSION['User']->login != "guest") { ?>
                        <li> <a href="widget">Widget</a></li>
                    <?php } ?>
                    <li> <a href="logme/">Login (<?php echo $_SESSION['User']->login ?>)</a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</header>
<div class="fadeTop">&nbsp;</div>
<div id="body" class="container"><a name="top"></a>
    <?php renderBody( viewAction(), $this ); ?>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center">
                <div class="col-container"><p>Propulsé par LibreMVC.</p></div>
            </div>
            <div class="col-md-4 text-center"><div class="col-container text-center"> <div id="toTop"><a class="footer-backtotop" href="#top">TOP</a></div></div></div>
        </div>
    </div>
</footer>
</body>
</html>