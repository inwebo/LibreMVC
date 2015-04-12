# Cache

Systéme de cache très simple, base sur les fonctions de buffering ob_*

    // Dossiers des fichiers mis en cache.
    $baseDir = "./demo/";
    // Sauvegarde dans le fichier cache.php
    $cache = new Cache($baseDir,"cache.php");
    // A partir de ce point
    $cache->start();
    var_dump($cache);
    echo strftime('%c');
    // Jusqu'ici
    $cache->stop();