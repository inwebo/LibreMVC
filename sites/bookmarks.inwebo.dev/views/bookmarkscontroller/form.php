<?php
    use LibreMVC\Mvc\Environnement;
?>
<script>
    $("h1").hide();
    $(".starter-template").hide();
    $("#breadcrumbs").hide();
    $("footer").css('display', 'none');
    $("header").hide();
    $("body").css('padding-top', '1em');

    $(document).ready(function(){
        //@todo sauvegarde des bookmarks
        window.LibreMVC.Config.User.login = '<?php echo $_GET['user'] ?>';
        window.LibreMVC.Config.User.publicKey = '<?php echo $_GET['publicKey'] ?>';

        $('#save').on('click',function(){
            $.ajax({
                type: "PUT",
                url: "<?php echo Environnement::this()->instance->baseUrl; ?>bookmark",
                data:$('#bookmark').serialize(),
                headers: {
                    Accept : "application/json",
                    "Content-Type": "application/json"
                },
                beforeSend:function(xhr){
                    var timestamp = Date.now();
                    xhr.setRequestHeader('User', window.LibreMVC.Config.User.login);
                    xhr.setRequestHeader('Timestamp', timestamp);
                    xhr.setRequestHeader('Token', window.LibreMVC.Config.User.publicKey);
                }
            }).error(function(msg){
                    var response = $.parseJSON(msg.responseText);
                    $('#response').html(response.msg);
                    console.log(response);
                    alert('fail');
                })
                .done(function( msg ) {
                    var response = $.parseJSON(msg);
                    alert(response.valid);
                    if( msg.valid == false ) {
                        console.log("Error");
                    }
                    else {
                        alert(msg);
                        alert('done');
                        window.close();
                    }

                });
        });
    });

</script>

<?php //var_dump( $_GET ); ?>
<div class="col-md-12">
    <div class="col-container">
        <div id="response"></div>
        <form id="bookmark" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="url" class="col-lg-2 control-label">Url</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="url" name="url" placeholder="eg : http://www.inwebo.net" value="<?php echo $_GET['url'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="title" name="title" placeholder="I'm a title" value="<?php echo $_GET['title'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="category" class="col-lg-2 control-label">Categorie</label>
                <div class="col-lg-10">
                    <select class="form-control" id="category" name="category">
                        <?php
                            foreach(vb()->Bookmarks->categories as $k => $v) {
                                echo '<option value="'.$v.'">' . $k . '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="keywords" class="col-lg-2 control-label">keywords</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="keywords" name="keywords" placeholder="eg : hello world these are keywords example" value="<?php echo $_GET['keywords'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">Description</label>
                <div class="col-lg-10">
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="A brief description of the current bookmark"><?php echo $_GET['description'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <id id="save" name="save" type="submit" class="btn btn-default">Save</id>
                </div>
            </div>
            <input id="favicon" name="favicon" type="hidden" value="<?php echo $_GET['favicon'] ?>">
            <!--
<a target="_blank" href="javascript:(function(){

    var publicKey = '';
    //@todo publicKey dynamic & restServiceDynamique
    var restService = '';

    var url = encodeURIComponent(location.href);

    var title = encodeURIComponent(document.title);

    var faviconQuery = document.evaluate('//*[contains(@rel,\'shortcut icon\')]', document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
    var favicon = (faviconQuery.snapshotLength != 0) ? faviconQuery.snapshotItem(0).getAttribute('href')  : null;

    var description;
    var keywords;


    var metas = document.getElementsByTagName('meta');
    for (var x=0,y=metas.length; x<y; x++) {
        if (metas[x].name.toLowerCase() == 'description') {
            description = metas[x].content;
        }
        if (metas[x].name.toLowerCase() == 'keywords') {
            keywords = metas[x].content;
        }
    }

    window.open(restService+'?url='+url+'&title='+title+'&description='+'&keywords='+keywords,'AddBookmaks','location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=300,height=550,left=0,top=0').focus();
})();">&hearts;</a>-->
    </form>
    </div>
</div>