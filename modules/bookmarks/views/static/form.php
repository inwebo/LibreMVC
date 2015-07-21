<?php
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
/* @var $bookmark Bookmark */
$bookmark = $this->bookmark;
?>
<script>
    var verb    = "<?php echo ($bookmark->isNew()) ? 'POST' : 'UPDATE'; ?>";
    var user    = window.LibreJs.Plugins.User.prototype.load();
    var url     = '<?php echo $this->bookmark->url ?>';
</script>
<!--
    <form id="_bookmark" role="form">
        <input name="id" type="hidden" value="<?php echo $this->bookmark->id ?>">
        <input name="hash" type="hidden" value="<?php echo $this->bookmark->hash ?>">
        <input name="dt" type="hidden"  value="<?php echo $this->bookmark->dt ?>">
        <input name="favicon" type="hidden"  value="">
        <input name="url" type="text"  placeholder="eg : http://www.inwebo.net" value="<?php echo $this->bookmark->url ?>" required readonly><br>
        <input name="title" type="text" placeholder="I'm a title" value="<?php echo ($this->bookmark->title==="null") ? "" : $this->bookmark->title ?>" required><br>
        <a id="clearTags" href="#" class="clear">x</a>&nbsp;
        <input name="tags" type="text" id="tags"  placeholder="spaces as separators" value="<?php echo ($this->bookmark->tags==="null") ? "" : $this->bookmark->tags ?>" list="listTags" required>
        <datalist id="listTags">
            <?php foreach($this->tags as $tag) { ?>
            <option value="<?php echo $tag ?>">
            <?php } ?>
        </datalist>
        <br>
        <input name="isPublic" type="checkbox" <?php echo ($bookmark->isPublic()) ? "checked":""; ?>> public <br>
        <textarea id="description" name="description" rows="11" placeholder="A brief description of the current bookmark"><?php echo ($this->bookmark->description==="null") ? "" : $this->bookmark->description ?></textarea>
        <br>
        <input type="submit" id="bookmark-save" value="Save">
    </form>-->
    <form  id="_bookmark" role="form"><br>
        <input name="id" type="hidden" value="<?php echo $this->bookmark->id ?>">
        <input name="hash" type="hidden" value="<?php echo $this->bookmark->hash ?>">
        <input name="dt" type="hidden"  value="<?php echo $this->bookmark->dt ?>">
        <input name="favicon" type="hidden"  value="">
        <div class="form-group">
            <input type="text" name="url" class="form-control" placeholder="eg : http://www.inwebo.net" value="<?php echo $this->bookmark->url ?>" required readonly>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input id="title" type="text" name="title" class="form-control"  placeholder="I'm a title" value="<?php echo ($this->bookmark->title==="null") ? "" : $this->bookmark->title ?>" required>
                <div class="input-group-addon"><a id="clearTitle" href="#" class="clear">clear</a></div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input id="tags" type="text" name="tags"  class="form-control" placeholder="space as separator" value="<?php echo ($this->bookmark->tags==="null") ? "" : $this->bookmark->tags ?>" list="listTags" required>
                <datalist id="listTags">
                    <?php foreach($this->tags as $tag) { ?>
                    <option value="<?php echo $tag ?>">
                        <?php } ?>
                </datalist>
                <div class="input-group-addon"><a id="clearTags" href="#" class="clear">clear</a></div>
            </div>
        </div><textarea  id="description" name="description" class="form-control" rows="10" placeholder="A brief description of the current bookmark"><?php echo ($this->bookmark->description==="null") ? "" : $this->bookmark->description ?></textarea>

        <div class="form-group text-center">

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="isPublic" <?php echo ($bookmark->isPublic()) ? "checked":""; ?>> Public
                </label>
            </div>
        </div>
        <button id="bookmark-save" type="submit" class="btn btn-primary" value="Save">Save</button>

    </form>
<div id="bookmarkFormLoader">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="100%" height="100%" fill="#428bca">
        <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
        <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
            <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
        </path>
    </svg>
</div>
<div id="bookmarkFormResponseText">loading</div>
    <script>
        $(function() {
            var isVideo =parseVideoURL(url);

            if( isVideo.provider === "youtube" )
            {
                $('#description').val(isVideo.getEmbed());
            }

            $('header').hide();
            $('#clearTags').on('click',function(e){
                e.preventDefault();
                $('#tags').val('');
            });
            $('#clearTitle').on('click',function(e){
                e.preventDefault();
                $('#title').val('');
            });

            $('#bookmark-save').on('click', function (e) {
                e.preventDefault();
                var loader = $('#bookmarkFormLoader');
                var responseText = $('#bookmarkFormResponseText');

                loader.show();
                responseText.show();
                responseText[0].innerHTML = "Loading";

                var form = $('#_bookmark');
                var isValidForm = form[0].checkValidity();
                if(isValidForm) {
                    var datas = $('#_bookmark').serializeArray();
                    var bookmark = window.LibreJs.Plugins.Bookmark.prototype.loadBySerializedArray(datas);
                    var id = (bookmark.id !=='') ? bookmark.id : '';
                    $.ajax('form/'+id,{
                        method: verb,
                        data:bookmark.toObject(user)
                    }).done(function(){
                        //alert('Updated');
                        responseText[0].innerHTML = 'Saved';
                        setTimeout(
                            function()
                            {
                                window.opener.focus();
                                window.close();
                                window.opener.location.reload();
                            }, 1000);

                    }).fail(function(){
                        responseText[0].innerHTML = 'Already in base !';
                        setTimeout(
                            function()
                            {
                                loader.hide();
                                responseText.hide();
                                window.close();

                            }, 1000);

                    });
                }
                else {
                    var array = [];
                    if( $('input[name=title]').val() === '' )
                    {
                        array.push('title');
                    }
                    if( $('#tags').val() === '' )
                    {
                        array.push('tags');
                    }

                    var string = 'Empty fields : '+ array.join(',') +' !';
                    responseText[0].innerHTML = string;
                    //alert(string);

                    setTimeout(
                        function()
                        {
                            loader.hide();
                            responseText.hide();

                        }, 1000);
                    //
                }
            });

        });

        videoObject=function(url,provider,id)
        {
            this.url = url;
            this.provider =provider;
            this.id =id;

            this.getEmbed = function()
            {
                switch (this.provider){
                    case 'youtube':
                        var str ='<iframe width="420" height="315" src="https://www.youtube.com/embed/%" frameborder="0" allowfullscreen></iframe>';
                        return str.replace('%',this.id);
                        break;
                }
            }


        }

        function parseVideoURL(url) {

            function getParm(url, base) {
                var re = new RegExp("(\\?|&)" + base + "\\=([^&]*)(&|$)");
                var matches = url.match(re);
                if (matches) {
                    return(matches[2]);
                } else {
                    return("");
                }
            }


            var retVal = [];
            var matches;

            if (url.indexOf("youtube.com/watch") != -1) {
                return new videoObject(url,"youtube",getParm(url, "v") );
            } else if (matches = url.match(/vimeo.com\/(\d+)/)) {
                return new videoObject(url,"vimeo", matches[1] );
            }
            return(retVal);
        }
    </script>

</div>


