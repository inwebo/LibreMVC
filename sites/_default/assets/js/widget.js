/**
 * Created with JetBrains PhpStorm.
 * User: inwebo
 * Date: 15/09/13
 * Time: 02:15
 * To change this template use File | Settings | File Templates.
 */
javascript:(function(){

    var url = encodeURIComponent(location.href);
    var publicKey = "";

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

    console.log(url,title,favicon,description, keywords);

    window.open("http://localhost/LibreMVC/bookmarks/form?url="+url+"&title="+title+"&description="+"&keywords="+keywords,"AddBookmaks","location=0,titlebar=0,toolbar=0,menubar=0,resizable=0,width=300,height=550,left=0,top=0").focus();
})();