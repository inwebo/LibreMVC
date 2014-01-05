<?php if($_SESSION['User']->login === 'guest') {?>
    <div class="col-md-12">
        <div class="col-container">
            <h3>Error</h3>
            <div id="displayWidget" class="alert alert-danger">
                nope
            </div>

        </div>
    </div>
<?php } else {?>
    <script type="text/javascript">
        $.ready(function(){
            $('footer').hide();
        });
    </script>

    <div class="col-md-12">
        <div class="col-container">
            <h3>Widget</h3>
            <p>
                Please drag and drop to your toolbar.
            </p>
            <div id="displayWidget" class="alert alert-info">
                &#8595;<br>
                &#8594;<a href="<?php echo vb()->widget; ?>">J'aime</a>&#8592;<br>
                &#8593;
            </div>

        </div></div>
<?php } ?>
