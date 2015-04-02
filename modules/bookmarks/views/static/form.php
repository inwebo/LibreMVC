<?php
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
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
        <input name="title" type="text" placeholder="I'm a title" value="<?php echo ($this->bookmark->title==="null") ? "" : $this->bookmark->title ?>" required>
        <input name="tags" type="text" id="tags"  placeholder="spaces as separators" value="<?php echo ($this->bookmark->tags==="null") ? "" : $this->bookmark->tags ?>" required><br>
        <input name="isPublic" type="checkbox" <?php echo ($bookmark->isPublic()) ? "checked":""; ?>> public <br>
        <textarea name="description" rows="11" placeholder="A brief description of the current bookmark"><?php echo ($this->bookmark->description==="null") ? "" : $this->bookmark->description ?></textarea>
        <input type="submit" id="bookmark-save" value="Save">
    </form>

    <script>
        $(function() {
            $('header').hide();
            $('#bookmark-save').on('click', function (e) {
                e.preventDefault();
                var datas = $('#_bookmark').serializeArray();
                var bookmark = window.LibreJs.Plugins.Bookmark.prototype.loadBySerializedArray(datas);
                var id = (bookmark.id !=='') ? bookmark.id : '';
                $.ajax('form/'+id,{
                    method: verb,
                    data:bookmark.toObject(user)
                }).done(function(){
                    alert('Updated');
                    window.opener.location.reload();
                    window.opener.focus();
                    window.close();
                }).fail(function(){
                    alert('Already in base');
                    window.close();
                });
            });
        });
    </script>
</div>


