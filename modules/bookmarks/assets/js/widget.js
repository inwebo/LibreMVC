javascript:(function(){

    var user='%user%';
    var publicKey ='%publicKey%';

    var restService = '%restService%';

    var url = encodeURIComponent(location.href);

    var title = encodeURIComponent(document.title);

    var faviconQuery = document.evaluate('//*[contains(@rel,\'shortcut icon\')]', document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
    var favicon = (faviconQuery.snapshotLength != 0) ? encodeURIComponent(faviconQuery.snapshotItem(0).getAttribute('href'))  : null;

    var description;
    var keywords;

    var metas = document.getElementsByTagName('meta');
    var y = metas.length;
    for (var x=0 ; x<y; x++) {
        if (metas[x].name.toLowerCase() == 'description') {
            description = encodeURIComponent(metas[x].content);
        }
        if (metas[x].name.toLowerCase() == 'keywords') {
            keywords = encodeURIComponent(metas[x].content);
        }
    }

    window.open(restService+'?user='+user+'&publicKey='+publicKey+'&url='+url+'&title='+title+'&description='+'&keywords='+keywords+'&favicon='+favicon,'AddBookmaks','location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=300,height=550,left=0,top=0').focus();
})();