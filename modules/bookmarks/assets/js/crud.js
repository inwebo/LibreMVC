$(".bookmark-delete").on('click', function(){
    var bookmark = $(this).closest('div.bookmarks-list');

    var title =  bookmark.first().find('a').first().html();
    var hash =  bookmark.attr('data-bookmark-id');

    var r = confirm("Delete bookmark, " + title + ' ' + hash);

    if( r ) {
        $.ajax({
            type: "DELETE",
            url: "http://bookmarks.inwebo.dev/api/bookmark/",
            data:{
                hash:hash
            },
            headers: {
                Accept : "application/json",
                "Content-Type": "application/json"
            },
            beforeSend:function(xhr){
                var timestamp = Date.now();
                xhr.setRequestHeader('User', 'test');
                xhr.setRequestHeader('Timestamp', timestamp);
                xhr.setRequestHeader('Token', 'test');
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
    window.open("http://bookmarks.inwebo.dev/api/bookmark/form/" + hash);
} );