<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 11/11/13
 * Time: 00:56
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Controllers;

use LibreMVC\Models\User;
use LibreMVC\Mvc\Controllers\RestController;
use LibreMVC\Database;

/**
// login
var user = "inwebo";
var pwd = CryptoJS.MD5("inwebo");
var pwd = pwd.toString();

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
console.log(btoa(hash));
return btoa(hash);
}
MSG

 */
class LoginController extends RestController{

    public function __construct(){
        parent::__construct();
    }

    public function post($args) {
        $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $valid = User::isValidUser($user, $password);
        //var_dump($_POST);
        //var_dump($args);
        $this->httpReply->msg = $user;
        $this->httpReply->valid = $valid;
    }

}