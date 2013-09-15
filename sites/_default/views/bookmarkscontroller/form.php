<script>
    $("h1").hide();
    $(".starter-template").hide();
    $("#breadcrumbs").hide();
    $("footer").hide();

    $(document).ready(function(){

        $('#bookmark-save').click(function(){

            var user = "inwebo";
            var pwd = CryptoJS.MD5("inwebo");
            var pwd = pwd.toString();



            $.ajax({
                type: "GET",
                url: "http://www.inwebo.dev/LibreMVC/bookmark/",
                // Seter le type par default par text et heriter de la methode
                headers: {
                    Accept : "application/json",
                    "Content-Type": "application/json"
                },
                beforeSend:function(xhr){
                    var timestamp = Date.now();
                    xhr.setRequestHeader('User', user);
                    xhr.setRequestHeader('Timestamp', timestamp);
                    xhr.setRequestHeader('Token', restSignature(user, pwd,timestamp));

                }

            }).done(function( msg ) {
                    console.log( msg );
                });


            function restSignature(user, pwd, timestamp) {
                var hash = CryptoJS.HmacSHA256(user, pwd + timestamp);
                console.log(btoa(hash));
                return btoa(hash);
            }
            return false;
        });

    });

</script>
<?php //var_dump( $_GET ); ?>
<div class="col-md-12">
    <div class="col-container">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Url</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputEmail1" placeholder="eg : http://www.inwebo.net" value="<?php echo $_GET['url'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword1" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputPassword1" placeholder="I'm a title" value="<?php echo $_GET['title'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Categorie</label>
                <div class="col-lg-10">
                    <select class="form-control">
                        <?php
                            foreach(vb()->Bookmarks->categories as $k => $v) {
                                echo '<option value="'.$v.'">' . $k . '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword1" class="col-lg-2 control-label">keywords</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputPassword1" placeholder="eg : hello world these are keywords example" value="<?php echo $_GET['keywords'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword1" class="col-lg-2 control-label">Description</label>
                <div class="col-lg-10">
                    <textarea class="form-control" rows="3" placeholder="A brief description of the current bookmark"><?php echo $_GET['description'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <id id="bookmark-save" type="submit" class="btn btn-default">Save</id>
                </div>
            </div>
        </form>

    </div>
</div>