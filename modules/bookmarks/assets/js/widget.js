javascript:(function(){

    var user, publicKey, restService, bookmark, xpathFavicon, metas, bookmark, x;

    user            = '%user%';
    publicKey       = '%publicKey%';
    restService     = '%restService%';
    xpathFavicon    = document.evaluate('//*[contains(@rel,\'shortcut icon\')]', document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);

    bookmark        = new Object();
    bookmark.url    = encodeURIComponent(location.href);
    bookmark.title  = encodeURIComponent(document.title);
    bookmark.favicon= (xpathFavicon.snapshotLength != 0) ? encodeURIComponent(xpathFavicon.snapshotItem(0).getAttribute('href'))  : null;

    metas = document.getElementsByTagName('meta');
    var y = metas.length;
    for (x=0 ; x<y; x++) {
        if (metas[x].name.toLowerCase() === 'description') {
            bookmark.description = encodeURIComponent(metas[x].content);
        }
        if (metas[x].name.toLowerCase() === 'keywords') {
            bookmark.keywords = encodeURIComponent(metas[x].content);
        }
    }

    window.open(
        restService +   '?user=' + user +
                        '&publicKey=' + publicKey +
                        '&url=' + bookmark.url +
                        '&title=' + bookmark.title +
                        '&description=' + bookmark.description +
                        '&keywords=' + bookmark.keywords +
                        '&favicon=' + bookmark.favicon,
        'BookmarksForm',
        'location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=640,height=490,left=0,top=0'
    ).focus();
})();
