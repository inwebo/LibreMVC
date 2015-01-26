<?php
// Autoloader
include('core/autoloader/autoload.php');
include('core/string/class.string.php');
include('core/helpers.php');

use LibreMVC\Autoloader;
use LibreMVC\Autoloader\Decorators;
use LibreMVC\Autoloader\Handler;
use LibreMVC\System\Boot;
use LibreMVC\System\Boot\MVC;
use LibreMVC\System;

try {
    // Autoloader
    Handler::addDecorator(new Decorators('core'));
    spl_autoload_register( "\\LibreMVC\\Autoloader\\Handler::handle" );

    new Boot( new Mvc('config/config.ini'), System::this() );

}
catch (\Exception $e) {
    var_dump($e);
}
/**
 * songsByPlaylist : SELECT * FROM Songs AS S JOIN Playlists as P WHERE P.id = 1
 * moodsBySongId : SELECT M.id as 'id', M.name as 'name'
FROM Moods M
join Song_Moods SM ON M.id = SM.id_mood
join Songs S ON S.id = SM.id_song

where S.id = 1
group by M.id
 *
 *

 * songByMoods :
 *
 * SELECT *
FROM Songs S
join Song_Moods SM ON S.id = SM.id_song
join Moods M ON M.id = SM.id_mood

where M.id = 1
group by S.id
 *
 */

/**
 *
SELECT *
FROM Playlists AS P
NATURAL JOIN Playlist_Songs as PS
NATURAL JOIN  Songs as S
NATURAL JOIN Song_Moods as SM
JOIN Moods as M ON M.id = SM.id_mood
JOIN Moods as M2 ON SM.id_mood = M2.id
WHERE
P.id = 1

 */
