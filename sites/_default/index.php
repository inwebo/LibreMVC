<html>
<head>
    <title><?php echo $this->_meta->title ?></title>
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
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">LibreMVC</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li> <a href="debug/">Dump</a></li>
                    <li> <a href="page/about/">About</a></li>
                    <li> <a href="page/debug/">Debug</a></li>
                    <li> <a href="logme/">Login (<?php echo $_SESSION['User']->login ?>)</a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</header>
<div id="parallax-wrapper">
    <div class="container">
        <div class="row">
                <div class="col-md-12">
                    <div id="breadcrumbs" data-spy="affix" data-offset-top="100">
                        <ol class="breadcrumb">
                            <li>Index</li>
                        </ol>
                    </div>
                </div>
        </div>
        <?php $this->partial( 'body' )->render(); ?>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12"><div class="col-container"></div></div>
        </div>
    </div>
</footer>
</body>
</html>