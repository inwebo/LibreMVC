<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h3>Ajax</h3>
            <div class="col-container">

                <form>
                    <fieldset>
                        <legend>Verb</legend>
                        <div class="radio">
                            <label>
                                <input type="radio" name="verb" id="verbGet" value="get" checked>
                                get
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="verb" id="verbPost" value="post">
                                post
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="verb" id="verbUpdate" value="update">
                                update
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="verb" id="verbDelete" value="delete">
                                delete
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Content type</legend>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ctype" value="application/json" checked>
                                application/json
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ctype" value="text/xml">
                                text/xml
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ctype" value="text/html">
                                text/html
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="ctype" value="text/plain">
                                text/plain
                            </label>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <h3>User</h3>
            <div class="col-container">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="User" class="col-sm-2 control-label">User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="User" placeholder="eg : inwebo" value="inwebo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Token" placeholder="md5 hash" value="5e24ec4339ab1bb6b16e24658b94754add7c9a4c">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="submit" type="button" class="btn btn-default">execute</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-md-4">
            <h3>Response</h3>
            <div class="col-container">

                <textarea id="response" class="form-control" rows="10"></textarea>

            </div>
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