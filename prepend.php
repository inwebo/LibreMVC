<?php
/*
include( dirname(__FILE__) . "/core/autoloader/class.autoloader.php" );
include('core/standart.php');
include('core/helpers.php');
if( isset($_GET['q']) ) {
    echo $_GET['q'];
}
class Get {

    public function __construct(){
        return $this;
    }

    public function __get( $key ) {
        $this->$key = $_GET[$key].'+';
        return $this->$key;
    }

}

class _Post {

}
$g = new Get();
echo $g->q;*/