<?php
$bookmark = $this->bookmark;
?>
<!DOCTYPE html>
<html lang="en" style="min-height: 100%;position: relative">
<head>
    <meta charset="utf-8">
    <title>Bookmarks agent</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <?php foreach(ev()->css as $k => $v) { ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $v; ?>">
    <?php } ?>
</head>
<body id="form" style="padding-top: 1em; vertical-align: middle">
<script>
    $(document).ready(function(){
        var login = '<?php echo $this->login ?>';
        var publicKey = '<?php echo $this->publicKey ?>';

        $('#bookmark-save').on('click',function(){
            $.ajax({
                type: "<?php echo $this->verb ?>",
                url: "<?php echo $this->restUrl ?>",
                data:$('#bookmark').serialize(),
                headers: {
                    Accept : "application/json",
                    "Content-Type": "application/json"
                },
                beforeSend:function(xhr){
                    var timestamp = Date.now();
                    xhr.setRequestHeader('User', login);
                    xhr.setRequestHeader('Timestamp', timestamp);
                    xhr.setRequestHeader('Token', publicKey);

                    $("#bookmark-save").toggle();
                    $("#bookmark-saving").toggle();

                }
            }).error(function(msg){
                $("#bookmark-saving").toggle();
                $("#bookmark-warning").toggle();
                setTimeout(function(){
                    self.close();
                },2000);
            }).done(function( msg ) {
                $("#bookmark-saving").toggle();
                $("#bookmark-success").toggle();
                setTimeout(function(){
                    self.close();
                },2000);
            });
        });
    });

</script>
<div class="row">

    <div class="container-fluid" style="">

        <div class="col-xs-12">
            <form id="bookmark" class="form-horizontal" role="form">
                <input id="id" type="hidden" name="id" value="<?php echo $bookmark->id; ?>">
                <input id="hash" type="hidden" name="hash" value="<?php echo $bookmark->hash; ?>">
                <input id="dt" type="hidden" name="dt" value="<?php echo $bookmark->dt; ?>">
                <input id="category" type="hidden" name="category" value="<?php echo $bookmark->category; ?>">
                <input id="public" type="hidden" name="public" value="<?php echo $bookmark->public; ?>">
                <input id="favicon" type="hidden" name="favicon" value="<?php echo $bookmark->favicon; ?>">
                <div class="form-group">
                    <div class="col-lg-10">
                        <div class="input-group">
                            <div class="input-group-addon"><img src="<?php echo $bookmark->favicon; ?>" width="16" height="16"></div>
                            <input type="text" class="form-control" id="url" name="url" placeholder="eg : http://www.inwebo.net" value="<?php echo $bookmark->url; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10">
                        <div class="input-group">
                            <div class="input-group-addon">Title</div>
                            <input type="text" class="form-control" id="title" name="title" placeholder="I'm a title" value="<?php echo $bookmark->title; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10">
                        <div class="input-group">
                            <div class="input-group-addon">Tags</div>
                            <input type="text" class="form-control" id="keywords" name="keywords" placeholder="spaces as separators" value="<?php echo $bookmark->tags; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10">
                        <div class="input-group">
                            <textarea class="form-control" id="description" name="description" rows="11" placeholder="A brief description of the current bookmark"><?php echo $bookmark->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10">
                        <a href="#" id="bookmark-save" class="btn btn-default btn-lg btn-block" />Save</a>
                        <a href="#" id="bookmark-saving" class="btn btn-default btn-lg btn-block" style="display: none;" disabled/>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="#428bca">
                            <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
                            <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
                                <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
                            </path>
                        </svg>
                        </a>
                        <a href="#" id="bookmark-error" class="btn btn-danger btn-lg btn-block" style="display: none;" disabled/>Network error.</a>
                        <a href="#" id="bookmark-warning" class="btn btn-warning btn-lg btn-block" style="display: none;" disabled/>Already in base !</a>
                        <a href="#" id="bookmark-success" class="btn btn-success btn-lg btn-block" style="display: none;" disabled/>Saved</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

