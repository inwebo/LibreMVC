<html>
<head>
    <title><?php echo $this->_meta->title ?></title>
    <meta name="description" content="<?php echo $this->_meta->description ?>">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <base href="<?php getBaseHref(); ?>">
    <link type="text/css" rel="stylesheet" href="<?php baseCss(); ?>bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php instanceCss(); ?>style.css">
    <script src="<?php baseJs(); ?>jquery.min.js"></script>
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
        <?php renderBody( viewAction(), $this ); ?>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-10"><div class="col-container"></div></div>
            <div class="col-md-2"><div class="col-container text-center"></div></div>
        </div>
    </div>
</footer>
</body>
</html>