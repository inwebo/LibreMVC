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
    <?php foreach(ev()->css as $k => $v) { ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $v; ?>">
    <?php } ?>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        $(document).ready(function(){
            // cache the window object
            $window = $(window);

            var px = window.innerHeight - $('.navbar.navbar-inverse.navbar-fixed-top').height();
            $('#intro').height(px);
            console.log(px);
            $('section[data-type="background"]').each(function(){
                // declare the variable to affect the defined data-type
                var $scroll = $(this);

                $(window).scroll(function() {
                    // HTML5 proves useful for helping with creating JS functions!
                    // also, negative value because we're scrolling upwards
                    var yPos = -($window.scrollTop() / $scroll.data('speed'));

                    // background position
                    var coords = '50% '+ yPos + 'px';

                    // move the background
                    $scroll.css({ backgroundPosition: coords });
                }); // end window scroll
            });  // end section function
        }); // close out script
    </script>
</head>
<body>
<header>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Julien Hannotin</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li> <a href="wam/">Wam</a></li>
                    <li> <a href="musicophagie/">Musicophagie</a></li>
                    <li> <a href="curriculum-vitae/">Pro</a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</header>
<!-- Section 1 -->
<section id="intro" data-speed="6" data-type="background">
    <div class="container">
        Content goes here!
    </div>
</section>
<!-- Section 2 -->
<section id="home" data-speed="4" data-type="background">
    <div class="container">
        More content goes here!
    </div>
</section>
<!-- Section 3 -->
<section id="about" data-speed="2" data-type="background">
    <div class="container">
        This is the final section!
    </div>
</section>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                contact
            </div>
        </div>
    </div>
</footer>
</body>
</html>