<?php
/* @var $bookmark Bookmark */
$bookmark = $this->bookmark;
?>

    <script>
        var verb    = "<?php echo ($bookmark->isNew()) ? 'POST' : 'UPDATE'; ?>";
        var user    = window.LibreJs.Plugins.User.prototype.load();
    </script>

<div class="row">
    <form id="_bookmark" role="form">
        <input name="id" type="hidden" value="<?php echo $this->bookmark->id ?>">
        <input name="hash" type="hidden" value="<?php echo $this->bookmark->hash ?>">
        <input name="dt" type="hidden"  value="<?php echo $this->bookmark->dt ?>">
        <input name="favicon" type="hidden"  value="">
        <input name="url" type="text"  placeholder="eg : http://www.inwebo.net" value="<?php echo $this->bookmark->url ?>" required readonly>
        <input name="title" type="text" placeholder="I'm a title" value="<?php echo $this->bookmark->title ?>" required>
        <input name="tags" type="text" id="tags"  placeholder="spaces as separators" value="<?php echo $this->bookmark->tags ?>" required><br>
        <input name="public" type="checkbox" value="1"/> public <br>
        <textarea name="description" rows="11" placeholder="A brief description of the current bookmark"><?php echo $this->bookmark->description ?></textarea>
    </form>
    <input type="button" id="bookmark-save" value="Save">

    <script>
        $(function() {
            $('header').hide();
            $('#bookmark-save').on('click', function (e) {
                e.preventDefault();
                var datas = $('#_bookmark').serializeArray();
                var bookmark = window.LibreJs.Plugins.Bookmark.prototype.loadBySerializedArray(datas);
                console.log(bookmark);
                var id = (bookmark.id !=='') ? bookmark.id : '';
                $.ajax('form/'+id,{
                    method: verb,
                    data:bookmark.toObject(user)
                    //headers:bookmark.toObject(user)
                }).done(function(){
                    // Affichage formulaire
                    alert('Updated');

                    window.opener.location.reload();
                    window.opener.focus();
                    window.close();
                    //window.open('form/','','width:500');
                }).fail(function(){
                    alert('Already in base');
                    window.close();
                });

            });




        });
        /*
        $(document).ready(function(){
            $('header').hide();
            var user = '<?php //echo $this->user ?>';
            var idUser = '<?php //echo $this->user ?>';
            var publicKey = '<?php //echo $this->publicKey ?>';
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
        */
    </script>
</div>


