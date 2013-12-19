/**
 * Created by julien on 10/12/13.
 */
// login
var user = "inwebo";
var pwd = CryptoJS.MD5("inwebo");
var pwd = pwd.toString();
/* Exemple
 var user = 'inwebo';
 var pwd = 'inwebo';

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
$.ajax({
    type: "POST",
    url: "http://www.inwebo.dev/LibreMVC/login-in",
    data:{
        user:"inwebo",
        password:"inwebo"
    },
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
        MSG = JSON.parse(msg);
        if(MSG.valid) {
            window.history.back(-1);
        }
    });


function restSignature(user, pwd, timestamp) {
    var hash = CryptoJS.HmacSHA256(user, pwd + timestamp);
    //console.log(btoa(hash));
    return btoa(hash);
}

