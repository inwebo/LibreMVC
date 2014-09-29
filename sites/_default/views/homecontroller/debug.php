<?php
    use LibreMVC\Routing\RoutesCollection;

    $path = getcwd() . '/sites/';
    $pathNewSite = $path . 'new';
    $pathInstance = $path . 'instance';
?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h3>Content</h3>
            <ul>
                <li><a href="debug/#instance">Instance</a></li>
                <li><a href="debug/#user">User</a></li>
                <li><a href="debug/#routes">Registered routes</a></li>
                <li><a href="debug/#route">Current route</a></li>
                <li><a href="debug/#this">Context : $this</a></li>
                <li><a href="debug/#ev">Registre::ev()</a></li>
                <li><a href="debug/#config">Config file loaded</a></li>
                <li><a href="debug/#modules">Loaded modules</a></li>
                <li><a href="debug/#themes">Loaded themes</a></li>
            </ul>
        </div>
    </div>

    <a name="instance"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>Instance</h3>
            <?php
                var_dump(ev()->instance);
            ?>
        </div>
    </div>

    <a name="user"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>Instance</h3>
            <?php
                var_dump(ev()->instance);
            ?>
        </div>
    </div>


    <a name="routes"></a>
    <div class="row">
        <div class="col-md-8">
            <h3>Registered routes</h3>
            <?php
                $routes = RoutesCollection::get( 'default' );
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Pattern</th>
                        <th>Controller</th>
                        <th>Action</th>
                        <th>Params</th>
                    </tr>
                    <?php
                        foreach($routes->routes as $k => $v) { ?>
                            <tr>
                                <td><?php echo $v->name ?></td>
                                <td><?php echo $v->pattern ?></td>
                                <td><?php echo $v->controller ?></td>
                                <td><?php echo $v->action ?></td>
                                <td><?php print_r( $v->params ) ?></td>
                            </tr>
                    <?php
                        }
                    ?>
                </thead>
            </table>
        </div>
        <a name="route"></a>
        <div class="col-md-4">
            <h3>Current route</h3>
            <?php
            var_dump(ev()->route);
            ?>
        </div>
    </div>

    <a name="this"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>$this</h3>
            <?php
                var_dump($this);
            ?>
        </div>
    </div>

    <a name="ev"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>Registre environnement</h3>
            <?php
            var_dump(ev());
            ?>
        </div>
    </div>

    <a name="config"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>Config files</h3>
            <?php
            var_dump(\LibreMVC\System\Boot\Mvc::$config);
            ?>
        </div>
    </div>

    <a name="modules"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>Module(s)</h3>
            <?php
            var_dump(\LibreMVC\System\Boot\Mvc::$config->modules);
            ?>
        </div>
    </div>

    <a name="themes"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>Theme(s)</h3>
            <?php
            var_dump(ev()->themes);
            ?>
        </div>
    </div>

    <a name="users"></a>
    <div class="row">
        <div class="col-md-12">
            <h3>User(s)</h3>
            <?php
                var_dump($this->_user);
            ?>
        </div>
    </div>
</div>

<script>

    $( '#submit' ).on( 'click' , function() {
        var user, token, timestamp, verb, restService,ctype;

        user = $('#User').val();
        token = $('#Token').val();
        timestamp = Date.now();

        verb = $('input[type=radio][name=verb]:checked').attr('value');
        restService = "http://www.inwebo.dev/libremvc/rest"
        ctype = $('input[type=radio][name=ctype]:checked').attr('value');

        console.log(user, token, timestamp, verb, restService, ctype);

        $.ajax({
            type: verb,
            url: restService,
            headers: {
                "Accept" : ctype,
                "Content-Type": ctype,
                "User": user,
                "Token": token,
                "Timestamp": timestamp
            }
        }).done(function( msg) {
            console.log( msg );
            $("#response").html();
            $("#response").html(msg);

        }).fail(function(msg){
            console.log(msg);
            $("#response").html();
            $("#response").html(msg);
        });

    });

</script>