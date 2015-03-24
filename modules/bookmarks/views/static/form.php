<!DOCTYPE html>
<html lang="en" style="min-height: 100%;position: relative">
<head>
    <meta charset="utf-8">
    <title>Bookmarks agent</title>
    <?php echo(getHtmlJsScriptTags()); ?>
</head>
<body>
<div class="row">
    <form id="bookmark" class="form-horizontal" role="form">
        <input id="id" type="hidden" name="id" value="<?php echo $this->bookmark->id ?>">
        <input id="hash" type="hidden" name="hash" value="<?php echo $this->bookmark->hash ?>">
        <input id="dt" type="hidden" name="dt" value="<?php echo $this->bookmark->dt ?>">
        <input id="favicon" type="hidden" name="favicon" value="">
        <input type="text" id="url" name="url" placeholder="eg : http://www.inwebo.net" value="<?php echo $this->bookmark->url ?>" required readonly>
        <input type="text" id="title" name="title" placeholder="I'm a title" value="<?php echo $this->bookmark->title ?>" required>
        <input type="text" id="tags" name="tags" placeholder="spaces as separators" value="test" required><br>
        <input type="checkbox" id="public" name="public" value="1"/> public <br>
        <textarea id="description" name="description" rows="11" placeholder="A brief description of the current bookmark"><?php echo $this->bookmark->description ?></textarea>
        <br><a href="#" id="bookmark-save" class="btn btn-default btn-lg btn-block" />Save</a>
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
    </form>

    <script>
        $(document).ready(function(){
            var user = '<?php echo $this->user ?>';
            var idUser = '<?php echo $this->user ?>';
            var publicKey = '<?php echo $this->publicKey ?>';
            $('#bookmark-save').on('click',function(){
                $.ajax({
                    type: "<?php echo $this->verb ?>",
                    url: "http://bookmarks.inwebo.dev/api/bookmark",
                    data:{
                        User:user,
                        Key:publicKey,
                        Timestamp : Date.now(),
                        id:$('#id').val(),
                        hash:$('#hash').val(),
                        url:$('#url').val(),
                        title:$('#title').val(),
                        tags:$('#tags').val(),
                        description:$('#description').val(),
                        public:$('#public').val()

                    },
                    headers: {
                        Accept : "text/html",
                        "Content-Type": "text/html"
                    },
                    beforeSend:function(xhr){
                        var timestamp = Date.now();
                        xhr.setRequestHeader('User', user);
                        xhr.setRequestHeader('Timestamp', timestamp);
                        xhr.setRequestHeader('Key', publicKey);

                        $("#bookmark-save").toggle();
                        $("#bookmark-saving").toggle();

                    }
                }).error(function(msg){
                    $("#bookmark-saving").toggle();
                    $("#bookmark-warning").toggle();
                    setTimeout(function(){
                        //self.close();
                    },2000);
                }).done(function( msg ) {
                    $("#bookmark-saving").toggle();
                    $("#bookmark-success").toggle();
                    setTimeout(function(){
                        //self.close();
                    },2000);
                });
            });
        });
    </script>
</div>
</body>
</html>

