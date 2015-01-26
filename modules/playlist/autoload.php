<?php

registerModule();

    use LibreMVC\Database\Drivers;
    use LibreMVC\Database\Driver\MySql;
    use LibreMVC\Modules\Playlist\Models\Playlist;
    use LibreMVC\Modules\Playlist\Models\Song;
    use LibreMVC\Modules\Playlist\Models\Mood;


    Drivers::add( "Playlist", new MySql("localhost", "playlist","root", "root") );
    var_dump(Drivers::get("Playlist"));
    $db = Drivers::get('Playlist')->toStdClass();
    Playlist::binder($db);
    Song::binder($db);
    Mood::binder($db);

    $playlist = Playlist::load(1);
//var_dump($p);
    $songs = $playlist->getSongs();
    while($songs->valid()){
        echo $songs->current()->title . '<br>';
        $moods = $songs->current()->getMoods();
        while($moods->valid()) {
            echo $moods->current()->name . ' ';
            $moods->next();
        }
        echo '<br>';
        $songs->next();
    }
