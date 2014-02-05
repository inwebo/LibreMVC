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

});