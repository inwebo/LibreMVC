$( document ).ready(function() {

    $(".bookmark-delete").on('click', function(){
        var bookmark = $(this).closest('div.bookmarks-list');

        var title =  bookmark.first().find('a').first().html();
        var hash =  bookmark.attr('data-bookmark-id');

        var r = confirm("Delete bookmark, " + title + ' ' + hash);

        if( r ) {
            $.ajax({
                type: "DELETE",
                url: "%restService%",
                data:{
                    hash:hash
                },
                headers: {
                    Accept : "application/json",
                    "Content-Type": "application/json"
                },
                beforeSend:function(xhr){
                    var timestamp = Date.now();
                    xhr.setRequestHeader('User', '%user%');
                    xhr.setRequestHeader('Token', '%publicKey%');
                    xhr.setRequestHeader('Timestamp', timestamp);
                }
            }).error(function(msg){
                console.log(msg);
            }).done(function( msg ) {
                console.log(msg);
                bookmark.remove();
            });
        }

    } );

    $(".bookmark-edit").on('click', function(){
        var bookmark = $(this).closest('div.bookmarks-list');
        var hash =  bookmark.attr('data-bookmark-id');
        window.open(
            "%restService%form/" + hash,
            'BookmarksForm',
            'location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=640,height=490,left=0,top=0'
        );
    } );
});
