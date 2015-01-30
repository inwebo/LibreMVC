<h2>Playlist</h2>
<?php


    $songs = $this->Playlist->getSongs();
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

?>