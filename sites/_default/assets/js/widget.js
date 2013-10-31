javascript:(function(){

    var publicKey = '';
    var restService = 'http://localhost/LibreMVC/bookmarks/form';

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
})();