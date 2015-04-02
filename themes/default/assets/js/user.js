//<![CDATA[
;(function(window){

    window.LibreJs.Plugins.User = function(user, key){
        var plugin = this;
        plugin.login = user;
        plugin.publicKey = key;
    };
    window.LibreJs.Plugins.User.prototype.load = function(){
        var body = document.getElementsByTagName('body')[0];
        if( body !== null ) {
            return new User(
                body.getAttribute('data-user'),
                body.getAttribute('data-key')
            );
        }
    };

    var User = window.LibreJs.Plugins.User;
})(window);
//]]>