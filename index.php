<?php


include("autoload.php");
include('core/autoloader/classnamespace/class.classnamespace.php');

class AutoloadDecorator extends \FilterIterator {

    protected $extension;

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Check whether the current element of the iterator is acceptable
     * @link http://php.net/manual/en/filteriterator.accept.php
     * @return bool true if the current element is acceptable, otherwise false.
     */
    public function accept()
    {
        // TODO: Implement accept() method.
    }
}