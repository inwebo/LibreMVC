<?php

// Script Shell
/**
 * A - Sites
 *      1 - Lister
 *      2 - Ajouter
 *      3 - Supprimer
 *      4 - Modules
 *      4 - Cloner vers
 *
 * B - Modules
 *      1 - Lister
 *      2 - Ajouter à
 *      3 - Supprimer de
 */


//@todo Ajout des routes ajax pour les bookmarks
//@todo API cli
//@todo framework javascript : objet error comme LibreMVC
//@todo permalinks, pingback voir wikipedia
//@todo modules font, images
//@todo class mail
//@todo filter chain pour le nettoyage de l'uri
//@todo http://www.inwebo.dev/LibreMVC/ base controller byg

//@todo Clean Inputs au démarrage puis les placés dans $_ENV::Get(), Env::Post()
//@todo Autoload js
//@todo x-domain voit Header query Referer
/* Exemple

var user = "inwebo";
var pwd = CryptoJS.MD5("inwebo");
var pwd = pwd.toString();

$.ajax({
type: "GET",
url: "http://bookmarks.inwebo.dev/bookmark/",
// Seter le type par default par text et heriter de la methode
    headers: {
        Accept : "application/json",
        "Content-Type": "application/json"
    },
    beforeSend:function(xhr){
        var timestamp = Date.now();
        xhr.setRequestHeader('User', user);
        xhr.setRequestHeader('Timestamp', timestamp);
        xhr.setRequestHeader('Token', restSignature(user, pwd,timestamp));

    }

}).done(function( msg ) {
console.log( msg );
});


function restSignature(user, pwd, timestamp) {
    var hash = CryptoJS.HmacSHA256(user, pwd + timestamp);
    console.log(btoa(hash));
    return btoa(hash);
}
// Favicon service
$from = fopen( 'http://www.google.com/s2/favicons?domain='.$_GET['favicon'],'rb');

*/