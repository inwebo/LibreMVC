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

//@todo API cli
//@todo framework javascript : objet error comme LibreMVC
//@todo permalinks, pingback voir wikipedia
//@todo modules font, images
//@todo class mail
//@todo filter chain pour le nettoyage de l'uri
//@todo http://www.inwebo.dev/LibreMVC/ base controller byg
//@todo Clean Inputs au démarrage puis les placés dans $_ENV::Get(), Env::Post()

//@todo x-domain voir Header query Referer et alternatives

//@todo Normalisé les tables sqlite entre les instances !important;

//@todo Les requêtes ajax doivent être faites depuis le widget !
//@todo Configuration widget correctement.
/* Exemple
var user = 'inwebo';
var pwd = 'inwebo';

//$.post("http://bookmarks.inwebo.dev/bookmark/",{user:"qsd"}).done().fail().always();

$.ajax({
type: "GET",
url: "http://bookmarks.inwebo.dev/",
    headers: {
        Accept : "application/json",
        "Content-Type": "application/json"
    },
    crossDomain: true,
    beforeSend:function(xhr){
        var timestamp = Date.now();
        xhr.setRequestHeader('User', user);
        xhr.setRequestHeader('Timestamp', timestamp);
        xhr.setRequestHeader('Token', 'test');
    }

}).done(function( msg ) {
console.log( msg.responsetext );
});
// Favicon service
$from = fopen( 'http://www.google.com/s2/favicons?domain='.$_GET['favicon'],'rb');

*/