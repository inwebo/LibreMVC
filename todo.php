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
/* Exemple
$.ajax({
type: "GET",
url: "http://www.inwebo.dev/LibreMVC/bookmark/",
data: { name: "John", location: "Boston" },
// Seter le type par default par text et heriter de la methode
    headers: {
        Accept : "application/json",
        "Content-Type": "application/json"
    },
    beforeSend:function(xhr){
        xhr.setRequestHeader('Timestamp', Date.now());
        xhr.setRequestHeader('Token', Date.now());
        xhr.setRequestHeader('User', Date.now());
    }

}).done(function( msg ) {
console.log( msg );
});
 */