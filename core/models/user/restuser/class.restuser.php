<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 07/04/14
 * Time: 23:41
 */

namespace LibreMVC\Models\User;

class RestUser {

    public $user;
    public $token;
    public $timeStamp;

    public function __construct($user,$token,$timeStamp) {
        $this->user = $user;
        $this->token = $token;
        $this->timeStamp = $timeStamp;
    }

}