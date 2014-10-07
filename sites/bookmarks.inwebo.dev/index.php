<?php //var_dump($this) ?>
<html>
<head>
    <title><?php echo $this->_head->title ?></title>
    <meta name="description" content="<?php echo $this->_meta->description ?>">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <base href="<?php echo getBaseUrl(); ?>">
    <?php foreach(getCss() as $v) { ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $v ?>">
    <?php } ?>
    <?php foreach(getJs() as $v) { ?>
        <script src="<?php echo $v ?>"></script>
    <?php } ?>
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
    <?php $this->partial( 'body' )->render(); ?>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-container text-center"><p><a href="https://github.com/inwebo/LibreMVC" target="">Propulsé par LibreMVC</a>.</p></div>
            </div>
        </div>
    </div>
    <div id="toTop"><a class="footer-backtotop" href="#top">TOP</a></div>
</footer>
</body>
</html>