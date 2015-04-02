//<![CDATA[
$(function(){

    var User = function(user, key){
        var plugin = this;
        plugin.login = user;
        plugin.publicKey = key;
    };

    User.prototype.load = function(){
        var body = document.getElementsByTagName('body')[0];
        if( body !== null ) {
            return new User(
                body.getAttribute('data-user'),
                body.getAttribute('data-key')
            );
        }
    };

    var Bookmark = function(id,url,hash,dt,title,description,isPublic){

        var plugin = this;

        plugin.id;
        plugin.url;
        plugin.hash;
        plugin.dt;
        plugin.title;
        plugin.description;
        plugin.isPublic;

        var init = function(id,url,hash,dt,title,description,isPublic){
            plugin.id = id;
            plugin.url = url;
            plugin.hash = hash;
            plugin.dt = dt;
            plugin.title = title;
            plugin.description = description;
            plugin.isPublic = isPublic;
            if(plugin.url === null || plugin.url === "null") {
                //console.log(plugin.url, plugin.title);
                //throw new DOMException('Not a bookmark');
            }
        };

        plugin.isNew = function() {
            return (plugin.id === null && plugin.hash === null);
        };

        plugin.toUri = function(uri, user){
            var objParams = {
                id:plugin.id,
                url:plugin.url,
                hash:plugin.hash,
                dt:plugin.dt,
                title:plugin.title,
                description:plugin.description,
                isPublic:plugin.isPublic,
                User:user.login,
                Key:user.publicKey,
                Timestamp:Date.now()
            };
            var buffer = uri + '?';
            var array = [];
            for(var data in objParams) {
                if(objParams.hasOwnProperty(data)) {
                    array.push(data + '=' + objParams[data]);
                }
            }
            return buffer + array.join('&')  ;
        };

        plugin.toObject = function(user){
            return {
                id      : plugin.id,
                url     : plugin.url,
                hash    : plugin.hash,
                dt      : plugin.dt,
                title   : plugin.title,
                description:plugin.description,
                isPublic:plugin.isPublic,
                User:user.login,
                Key:user.publicKey,
                Timestamp:Date.now()
            };
        };

        plugin.showPopupForm = function(uri, user){
            window.open(plugin.toUri(uri + plugin.id, user),'Save me !',
                'location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=300,height=550,left=0,top=0');
        };

        plugin.save = function(callback){

        };
        plugin.edit = function(callback){

        };
        plugin.delete = function(callback){

        };
        plugin.getHTML = function(callback){

        };

        init(id,url,hash,dt,title,description,isPublic);
    };

    Bookmark.prototype.setup = {
        User    : null,
        Key     : null
    };

    Bookmark.prototype.factory = function(id,url,hash,dt,title,description,isPublic) {
        return new Bookmark(id,url,hash,dt,title,description,isPublic);
    };

    Bookmark.prototype.loadByListItemNode = function(node) {
        return Bookmark.prototype.factory(
            node.getAttribute('data-id'),
            encodeURIComponent(node.getAttribute('data-url')),
            node.getAttribute('data-hash'),
            node.getAttribute('data-dt'),
            encodeURIComponent(node.getAttribute('data-title')),
            encodeURIComponent(node.getAttribute('data-desc')),
            node.getAttribute('data-public')
        );
    };

    Bookmark.prototype.loadBySerializedArray = function(attribute, context) {
    };

    var user    = User.prototype.load();
    var uri     = 'form/';


    $('#bookmarks-list>li[data-bookmark]').each(function(index){
        var bookmark = Bookmark.prototype.loadByListItemNode($(this).get(0));

        console.log(typeof bookmark);

        var edit    = $(this).find('button[data-type=edit]');
        var del     = $(this).find('button[data-type=delete]');

        // Ajax affichage formulaire
        edit.on('click',function(){
            bookmark.showPopupForm(uri, user);
        });

        // Ajax delete
        del.on('click', function(){
            $.ajax('form/'+bookmark.id,{
                method: "DELETE",
                data:bookmark.toObject(user),
                headers:{'User':user.login,'Key':user.publicKey,'Timestamp':Date.now()}
            }).done(function(){
                // Affichage formulaire
                //alert('Deleted');
                //window.open('form/','','width:500');
            }).fail(function(){
                alert('Fail');
            });
        });
    });

    var GetAttributes =  function(node) {

        var plugin = this;
        plugin.node;

        var init= function(node) {
            plugin.node = node;
        };

        plugin.by = function(attrs) {
            var buffer = [];
            var list  = [].slice.call(node.getElementsByTagName('*'));
            list.unshift(plugin.node);
            var i,l;
            i=0;
            l=list.length;
            // Tous les noeuds
            for(i;i<l;i++) {
                var currentNode = list[i];
                // Tous les attributs
                var j,k;
                j=0;
                k=attrs.length;
                for(j;j<=k;j++){
                    var currentAttr = attrs[j];
                    if(currentNode.getAttribute(currentAttr)) {
                        buffer[currentAttr] = currentNode.getAttribute(currentAttr);
                    }
                }
            }
            return buffer;
        };

        init(node);
    };


});
//]]>