<?php

//@todo Ajout des routes ajax pour les bookmarks
//@todo Le client REST doit pouvoir demander un content-type par le header HTTP Accept, les erreurs ajax devraient retournées un object LibreMVC\Errors sérialisé
//@todo RestController
//@todo Bookmarks devrait etendre Entity, dans models/ du site bookmarks
//@todo API cli
//@todo framework javascript : objet error comme LibreMVC
//@todo Framework javascript : Requêtes ajax doivent pouvoir être signées
//@todo permaling, pingback voir wikipedia
//@todo modules font, images
//@todo Themes
//@todo class mail
//@todo base_controller inutile
//@todo _db->query("SELECT * FROM my_tables_bookmarks",array("my_tables_")); plante car pas de ?
//@todo filter chain pour le nettoyage de l'uri
//@todo http://www.inwebo.dev/LibreMVC/ base controller byg

//@todo Widget bookmarks
//@todo Clean Inputs au démarrage puis les placés dans $_ENV::Get(), Env::Post()
//@todo Clean controllers bookmarks
//@todo Autoload js
//@todo Charger l'autoload du site AVANT celui des modules
/* Exemple

var user = "inwebo";
var pwd = CryptoJS.MD5("inwebo");
var pwd = pwd.toString();



$.ajax({
type: "GET",
url: "http://www.inwebo.dev/LibreMVC/bookmark/",
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