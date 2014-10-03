<h2>Debug</h2>
<?php
use LibreMVC\Database;
use LibreMVC\Modules\Bookmarks\Models\Bookmark;
$user = new \LibreMVC\Models\User();

$tpUser = new \StdClass();
$tpUser->login = "test";
$tpUser->pswd = "test";
$tpUser->passphrase = "test";
$tpUser->pubKey = "";
$tpUser->prvKey = "";
$tpUser->id_role = 1;

//var_dump($tpUser);

$u = \LibreMVC\Models\User::factory("test","test","test",1);
//$u->save();
//var_dump($u);

$restU = new \LibreMVC\Models\User\RestUser($u,$u->publicKey,time());

//var_dump($restU);

Database\Provider::add( "bookmarks",
    new Database\Driver\MySql(
        "localhost",
        "inwebourl",
        "root",
        "root" )
);

$_db = Database\Provider::get("bookmarks");
$_db->toStdClass();





Bookmark::binder( $_db, "my_tables_bookmarks", 'id' );

try {
    $newBookmark = new Bookmark("http://www.yahoo.fr/");
    $newBookmark->title="";
    $newBookmark->description="";
    $newBookmark->category=1;
    $newBookmark->public=1;
    //$newBookmark->save();

} catch (\Exception $e) {
    var_dump($e);
}

$loaded = Bookmark::load("1cc92b9792fc5c488b3b3613a02f7a6b",'hash');
//var_dump($loaded);
//$loaded->delete();
//var_dump($loaded);

class String {

    /**
     * Substitue string by string with tokens.
     *
     * @param $subject Input string
     * @param $patterns Array of patterns to search for.
     * @param $replacement Array of replacement values.
     * @return mixed
     */
    static public function replace($subject, $patterns, $replacement) {
        $buffer = $subject;
        $j = -1;
        if( is_array($patterns) && is_array($replacement) ) {
            while( isset( $patterns[++$j] ) && isset( $replacement[$j] ) ) {
                $buffer = str_replace( $patterns[$j], $replacement[$j], $buffer );
            }
        }
        return $buffer;
    }

}

$foo = "Je suis un texte %foo%, par %bar%, %test%";
$p = array("%foo%","%bar%","%test%");
$r = array("formate", " une class",' arf');

echo String::replace($foo,$p,$r);