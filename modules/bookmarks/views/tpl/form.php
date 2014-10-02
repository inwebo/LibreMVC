<?php
    use LibreMVC\Mvc\Environnement;
    $bookmark = $this->bookmark;
?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script>

    $(document).ready(function(){



        var login = '<?php echo $this->login ?>';
        var publicKey = '<?php echo $this->publicKey ?>';

        $('#save').on('click',function(){
            console.log($('#bookmark').serialize());
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
                }
            }).error(function(msg){
                $('#msgRestBookmark').toggle();
                $('#msgRestBookmarkFalse').toggle();
                setTimeout(function(){
                    //self.close();
                },2000);
            }).done(function( msg ) {
                    $('#msgRestBookmark').toggle();
                    $('#msgRestBookmarkTrue').toggle();
                    setTimeout(function(){
                        //self.close();
                    },2000);
                });
        });
    });

</script>
<div id="msgRestBookmark" class="shadowBackground" style="display: none;">
    <div id="msgRestBookmarkFalse" class="msgRestCreateBookmark msgRestCreateBookmarkError" style="display: none;">
        <p>Already in base !</p>
    </div>
    <div id="msgRestBookmarkTrue" class="msgRestCreateBookmark msgRestCreateBookmarkValid" style="display: none;">
        <p>Added to the base!</p>
    </div>
</div>
<?php //var_dump( $this ); ?>
<div class="col-md-12">
    <div class="col-container">
        <form id="bookmark" class="form-horizontal" role="form">
            <input id="id" type="hidden" name="id" value="<?php echo $bookmark->id; ?>">
            <input id="hash" type="hidden" name="hash" value="<?php echo $bookmark->hash; ?>">
            <input id="dt" type="hidden" name="dt" value="<?php echo $bookmark->dt; ?>">
            <input id="category" type="hidden" name="category" value="<?php echo $bookmark->category; ?>">
            <input id="public" type="hidden" name="public" value="<?php echo $bookmark->public; ?>">
            <input id="favicon" type="hidden" name="favicon" value="<?php echo $bookmark->favicon; ?>">
            <div class="form-group">
                <label for="url" class="col-lg-2 control-label">Url</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="url" name="url" placeholder="eg : http://www.inwebo.net" value="<?php echo $bookmark->url; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="title" name="title" placeholder="I'm a title" value="<?php echo $bookmark->title; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="keywords" class="col-lg-2 control-label">keywords</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="keywords" name="keywords" placeholder="eg : hello world these are keywords example" value="<?php echo $bookmark->tags; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">Description</label>
                <div class="col-lg-10">
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="A brief description of the current bookmark"><?php echo $bookmark->description; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <a href="#" id="save" name="save" class="btn btn-default" />Save</a>
                </div>
            </div>
            <input id="favicon" name="favicon" type="hidden" value="<?php echo $bookmark->favicon ?>">
        </form>
    </div>
</div>