<?php
$timeStart = microtime(true);
include("autoload.php");
$a = number_format(microtime(true) - $timeStart, 5);
echo '<hr>'.$a.' s<hr>';
