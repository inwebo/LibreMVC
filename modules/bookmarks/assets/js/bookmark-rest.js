var user = "inwebo";
var pwd = CryptoJS.MD5("inwebo");
var pwd = pwd.toString();

var t =$.ajax({
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