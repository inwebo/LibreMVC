<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 06/08/13
 * Time: 21:10
 * To change this template use File | Settings | File Templates.
 */

//@todo Ajout des routes ajax pour les bookmarks
//@todo Le client REST doit pouvoir demander un content-type par le header HTTP Accept, les erreurs ajax devraient retournées un object LibreMVC\Errors sérialisé
//@todo RestController
//@todo Bookmarks devrait etendre Entity, dans models/ du site bookmarks
//@todo API cli
//@todo framework javascript : objet error comme LibreMVC
//@todo Framework javascript : Requêtes ajax doivent pouvoir être signées
//@todo Au boot chargement des meta donnée de la page ou alors creation de nouvelles meta datas si n'existe pas encore en base.
//@todo permaling, pingback voir wikipedia
//@todo Rest controller devrait nettoyer les données entrantes
//@todo modules font, images 
/* Exemple
$.ajax({
type: "GET",
url: "http://192.168.1.112:8080/LibreMVC/bookmark/",
data: { name: "John", location: "Boston" },
beforeSend:function(xhr){
    xhr.setRequestHeader('Timestamp', Date.now());
    xhr.setRequestHeader('Token', Date.now());
    xhr.setRequestHeader('User', Date.now());
},

}).done(function( msg ) {
console.log( "Data Saved: " + msg );
});





 */