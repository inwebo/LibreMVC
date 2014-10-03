<?php themeCssFiles() ?>
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
    <?php foreach(ev()->css as $k => $v) { ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $v; ?>">
    <?php } ?>
    <script src="<?php baseJs(); ?>jquery.min.js"></script>
    <?php foreach(ev()->js as $k => $v) { ?>
        <script src="<?php instanceJs(); ?>"></script>
    <?php } ?>
</head>
<body><div class="wrapper">

    <div class="info-bar">
        <div class="container">
            <a class="icon cmn-tut" data-title="Back To Tutorial" href="http://www.callmenick.com/?p=722"></a>
            <a class="icon cmn-prev" data-title="Pevious Demo - Simple Parallax Scrolling Effect" href="http://callmenick.com/tutorial-demos/simple-parallax-effect/"></a>
            <!-- <a class="icon cmn-next" data-title="Next Demo - " href="http://www.callmenick.com/tutorial-demos/..."></a> -->
            <a class="icon cmn-download" data-title="Download Source" href="http://www.callmenick.com/tutorial-demos/advanced-parallax-effect/advanced-parallax-effect-source.zip"></a>
            <a class="icon cmn-archive" data-title="Tutorial Archives" href="http://www.callmenick.com/category/tutorials/"></a>
        </div>
    </div>

    <main>

        <section class="module parallax parallax-1">
            <div class="container">
                <h1>Motion</h1>
            </div>
        </section>

        <section class="module content">
            <div class="container">
                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil consequuntur, nesciunt dicta, esse rem ducimus itaque quis. Adipisci ullam nam qui illum debitis sit ad in delectus, repudiandae non dolorum! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit veritatis, facere aliquid itaque tempore consequatur nihil sint enim aliquam id saepe magnam totam repellat placeat a fugit nulla molestias voluptas.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta cum distinctio eum asperiores rem enim fugit eaque voluptas est laboriosam in repudiandae architecto placeat, illum atque quasi explicabo, culpa, molestias!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit voluptas, aperiam quae provident, recusandae rem quis. Ut quaerat, quasi iste voluptate et dolorem atque sed neque voluptates, molestias dolor enim!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam odit tempore, quibusdam impedit deserunt. Natus quisquam, facilis numquam, molestias nesciunt modi, at debitis maxime sunt et quo quas labore perferendis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde delectus laborum doloremque recusandae, debitis maxime a! Nihil distinctio ex, cumque tempore ea voluptas omnis odit, quaerat natus nam excepturi corporis!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque eius harum atque unde nihil aut quam provident sunt, iste error vitae suscipit dolores cupiditate totam, eum quae alias! Dicta, nisi.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate beatae impedit officia quis odit rerum sequi, explicabo commodi illum suscipit, tempore eum doloremque quae obcaecati tempora quidem neque sapiente modi?</p>
            </div>
        </section>

        <section class="module parallax parallax-2">
            <div class="container">
                <h1>Shape</h1>
            </div>
        </section>

        <section class="module content">
            <div class="container">
                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil consequuntur, nesciunt dicta, esse rem ducimus itaque quis. Adipisci ullam nam qui illum debitis sit ad in delectus, repudiandae non dolorum! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit veritatis, facere aliquid itaque tempore consequatur nihil sint enim aliquam id saepe magnam totam repellat placeat a fugit nulla molestias voluptas.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta cum distinctio eum asperiores rem enim fugit eaque voluptas est laboriosam in repudiandae architecto placeat, illum atque quasi explicabo, culpa, molestias!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit voluptas, aperiam quae provident, recusandae rem quis. Ut quaerat, quasi iste voluptate et dolorem atque sed neque voluptates, molestias dolor enim!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam odit tempore, quibusdam impedit deserunt. Natus quisquam, facilis numquam, molestias nesciunt modi, at debitis maxime sunt et quo quas labore perferendis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde delectus laborum doloremque recusandae, debitis maxime a! Nihil distinctio ex, cumque tempore ea voluptas omnis odit, quaerat natus nam excepturi corporis!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque eius harum atque unde nihil aut quam provident sunt, iste error vitae suscipit dolores cupiditate totam, eum quae alias! Dicta, nisi.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate beatae impedit officia quis odit rerum sequi, explicabo commodi illum suscipit, tempore eum doloremque quae obcaecati tempora quidem neque sapiente modi?</p>
            </div>
        </section>

        <section class="module parallax parallax-3">
            <div class="container">
                <h1>Colour</h1>
            </div>
        </section>

        <section class="module content">
            <div class="container">
                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil consequuntur, nesciunt dicta, esse rem ducimus itaque quis. Adipisci ullam nam qui illum debitis sit ad in delectus, repudiandae non dolorum! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit veritatis, facere aliquid itaque tempore consequatur nihil sint enim aliquam id saepe magnam totam repellat placeat a fugit nulla molestias voluptas.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta cum distinctio eum asperiores rem enim fugit eaque voluptas est laboriosam in repudiandae architecto placeat, illum atque quasi explicabo, culpa, molestias!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit voluptas, aperiam quae provident, recusandae rem quis. Ut quaerat, quasi iste voluptate et dolorem atque sed neque voluptates, molestias dolor enim!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam odit tempore, quibusdam impedit deserunt. Natus quisquam, facilis numquam, molestias nesciunt modi, at debitis maxime sunt et quo quas labore perferendis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde delectus laborum doloremque recusandae, debitis maxime a! Nihil distinctio ex, cumque tempore ea voluptas omnis odit, quaerat natus nam excepturi corporis!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque eius harum atque unde nihil aut quam provident sunt, iste error vitae suscipit dolores cupiditate totam, eum quae alias! Dicta, nisi.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate beatae impedit officia quis odit rerum sequi, explicabo commodi illum suscipit, tempore eum doloremque quae obcaecati tempora quidem neque sapiente modi?</p>
            </div>
        </section>

    </main><!-- /main -->

    <footer>
        <div class="container">
            <div class="asides clearfix">
                <aside>
                    <nav>
                        <ul>
                            <li><a href="http://www.callmenick.com/">Welcome</a></li>
                            <li><a href="http://www.callmenick.com/category/tutorials">Tutorials</a></li>
                            <li><a href="http://www.callmenick.com/category/snippets">Snippets</a></li>
                            <li><a href="http://www.callmenick.com/category/articles">Articles</a></li>
                            <li><a href="http://www.callmenick.com/category/resources">Resources</a></li>
                        </ul>
                    </nav>
                </aside>
                <aside>
                    <nav>
                        <ul>
                            <li><a href="http://www.callmenick.com/archive/">Archive</a></li>
                            <li><a href="http://www.callmenick.com/about">About</a></li>
                            <li><a href="http://www.callmenick.com/contact">Contact</a></li>
                            <li><a href="http://www.callmenick.com/subscribe">Subscribe</a></li>
                        </ul>
                    </nav>
                </aside>
                <aside class="logo">
                    <a href="http://www.callmenick.com/"><img alt="Tutorials, Snippets, Resources, and Articles for Web Design and Web Development" onerror="this.src=logo-alt.png" src="img/core/logo-alt.svg"></a>
                </aside>
            </div>
            <div class="copyright">
                <small>
                    &copy; 2014, Nick Salloum<br><a href="http://callmenick.com">callmenick.com</a>
                </small>
            </div>
        </div>
    </footer><!-- /footer -->

</div><!-- /#wrapper -->
</body>
</html>