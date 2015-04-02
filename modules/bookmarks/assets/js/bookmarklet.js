javascript:(function(){

    var user, publicKey, restService, bookmark, xpathFavicon, metas, timestamp;

    user            = '<?php echo $this->user ?>';
    publicKey       = '<?php echo $this->publicKey ?>';
    restService     = '<?php echo $this->restService ?>';
    xpathFavicon    = document.evaluate('//*[contains(@rel,\'shortcut icon\')]', document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
    timestamp       = Date.now();
    bookmark        = {
        url:null,
        title:null,
        description:null,
        favicon:null,
        tags:null
    } ;
    bookmark.url    = encodeURIComponent(location.href);
    bookmark.title  = encodeURIComponent(document.title);
    bookmark.favicon= (xpathFavicon.snapshotLength != 0) ? encodeURIComponent(xpathFavicon.snapshotItem(0).getAttribute('href'))  : null;
    metas = document.getElementsByTagName('meta');
    var y = metas.length;
    for (var x=0 ; x<y; x++) {
        if (metas[x].name.toLowerCase() === 'description') {
            bookmark.description = encodeURIComponent(metas[x].content);
        }
        if (metas[x].name.toLowerCase() === 'keywords') {
            bookmark.tags = encodeURIComponent(metas[x].content);
        }
    }
    window.open(
        restService +
        '?User=' + user +
        '&Key=' + publicKey +
        '&Timestamp=' + timestamp +
        '&url=' + bookmark.url +
        '&title=' + bookmark.title +
        '&description=' + bookmark.description +
        '&tags=' + bookmark.tags +
        '&favicon='+ bookmark.favicon,
            'Save me !',
            'location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=300,height=550,left=0,top=0'
    ).focus();
})();