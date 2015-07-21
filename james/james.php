<?php
$args = $argv;
unset($args[0]);
$action = $args[1];
unset($args[1]);

function clearscreen($out = TRUE) {
    $clearscreen = chr(27)."[H".chr(27)."[2J";
    if ($out) print $clearscreen;
    else return $clearscreen;
}

function newSite($name) {
    shell_exec('cp -R ../sites/.default/ ../sites/' . $name);
}


function newModule($name) {
    shell_exec('cp -R ../modules/.default/ ../module/' . $name);
}

function activateModule($name) {
    shell_exec('ln -s ../../../modules/'.$name);
}
