<?php

$menus = \LibreMVC\Views\Template\ViewBag::get()->menus;

foreach ($menus as $v) {
    echo '<a href="http://www.inwebo.dev/LibreMVC/'.$v.'">'.$v.'</a> ';
}