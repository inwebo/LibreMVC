//<![CDATA[
$(function(){
    var user    = window.LibreJs.Plugins.User.prototype.load();
    var uri     = 'form/';

    $('#bookmarks-list>li[data-bookmark]').each(function(index){
        var bookmark =  window.LibreJs.Plugins.Bookmark.prototype.loadByListItemNode($(this).get(0));
        var edit    = $(this).find('button[data-type=edit]');
        var del     = $(this).find('button[data-type=delete]');
        var li      = $(this);
        console.log(li);
        // Ajax affichage formulaire
        edit.on('click',function(){
            bookmark.showPopupForm(uri, user);
        });

        del.on('click', function(){
            $.ajax('form/'+bookmark.id,{
                method: "DELETE",
                data:bookmark.toObject(user),
                headers:{'User':user.login,'Key':user.publicKey,'Timestamp':Date.now()}
            }).done(function(){
                // Affichage formulaire
                li.hide();
            }).fail(function(){
                alert('Fail');
            });
        });

    });

    var Bookmark = window.LibreJs.Plugins.Bookmark;

});
//]]>