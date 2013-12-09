/**
 * Default javascript autoloader.
 */
$(document).ready(function() {
    // Namespace
    LibreMVC = window.LibreMVC = window.LibreMVC || {};
    LibreMVC.Modules = LibreMVC.Modules || {};
    LibreMVC.Config = LibreMVC.Config || {};
    LibreMVC.Config = LibreMVC.Config || {};

    LibreMVC.Modules.Bookmarks = {
        Config: {
            RestService:""
        },
        Ajax: function(verb, _data){
            $.ajax({
                type: verb,
                url: "http://www.inwebo.dev/LibreMVC/bookmark/",
                // Seter le type par default par text et heriter de la methode
                headers: {
                    Accept : "application/json",
                    "Content-Type": "application/json"
                },
                data:_data,
                beforeSend:function(xhr){
                    var timestamp = Date.now();
                    xhr.setRequestHeader('User', window.LibreMVC.Config.login);
                    xhr.setRequestHeader('Timestamp', timestamp);
                    xhr.setRequestHeader('Token', "");

                }

            }).done(function( msg ) {
                console.log( msg );
            });
        },
        Create: {

        },
        Read: {

        },
        Update: {

        },
        Delete: {

        }
    };

    $('#breadcrumbs').affix({});
    //LibreMVC.Modules.Bookmarks.Ajax('GET');
});