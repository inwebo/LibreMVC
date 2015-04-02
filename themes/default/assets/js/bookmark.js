//<![CDATA[
;(function(window){
    window.LibreJs.Plugins.Bookmark = function(id,url,hash,dt,title,description, tags ,isPublic){

        var plugin = this;

        plugin.id;
        plugin.url;
        plugin.hash;
        plugin.dt;
        plugin.title;
        plugin.description;
        plugin.tags;
        plugin.isPublic;

        var init = function(id,url,hash,dt,title,description,tags,isPublic){
            plugin.id = id;
            plugin.url = url;
            plugin.hash = hash;
            plugin.dt = dt;
            plugin.title = title;
            plugin.description = description;
            plugin.tags = tags;
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
                tags:plugin.tags,
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
                tags:plugin.tags,
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

        //region Helpers
        plugin.save = function(callback){

        };
        plugin.edit = function(callback){

        };
        plugin.delete = function(callback){

        };
        plugin.getHTML = function(callback){

        };
        //endregion Helpers

        init(id,url,hash,dt,title,description,tags,isPublic);
    };

    window.LibreJs.Plugins.Bookmark.prototype.factory = function(id,url,hash,dt,title,description,isPublic) {
        return new Bookmark(id,url,hash,dt,title,description,isPublic);
    };

    window.LibreJs.Plugins.Bookmark.prototype.loadByListItemNode = function(node) {
        return Bookmark.prototype.factory(
            node.getAttribute('data-id'),
            encodeURIComponent(node.getAttribute('data-url')),
            node.getAttribute('data-hash'),
            node.getAttribute('data-dt'),
            encodeURIComponent(node.getAttribute('data-title')),
            encodeURIComponent(node.getAttribute('data-desc')),
            encodeURIComponent(node.getAttribute('data-tags')),
            node.getAttribute('data-public')
        );
    };

    window.LibreJs.Plugins.Bookmark.prototype.loadBySerializedArray = function(_array) {

        var buffer = [];
        var i,j;
        i=0;
        j=_array.length;
        for (i;i<j;i++) {
            var current = _array[i];
            buffer[current.name] = current.value;

        }
        return Bookmark.prototype.factory(
            buffer['id'],
            buffer['url'],
            buffer['hash'],
            buffer['dt'],
            buffer['title'],
            buffer['description'],
            buffer['tags']
        );
    };

    var Bookmark = window.LibreJs.Plugins.Bookmark;
})(window);
//]]>