<!DOCTYPE html>
<html>
<head>
    <title>Oups</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="./themes/default/css/style.css" rel="stylesheet" media="screen">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./assets/js/bootstrap.min.js"></script>
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
                <a class="navbar-brand" href="#">Oups</a>
            </div>
        </div>
    </div>
</header>
<div id="parallax-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12"><div class="col-container"><h3><?php echo get_class( \LibreMVC\Views\Template\ViewBag::get()->exception ) ?></h3>            <p class="lead">From <?php echo $e->getFile() ?>, line <?php echo $e->getLine() ?></p>
                    <p><?php echo $e->getMessage() ?></p><p><?php var_dump(LibreMVC\Views\Template\ViewBag::get()->exception ) ?></p></div></div>
        </div>
    </div>


</div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-10"><div class="col-container"><p>Lorem</p></div></div>
            <div class="col-md-2"><div class="col-container text-center"><a class="footer-backtotop" href="">TOP</a> </div></div>
        </div>
    </div>
</footer>
</body>
</html>
