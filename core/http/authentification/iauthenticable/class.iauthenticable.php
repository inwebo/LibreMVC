<?php

namespace LibreMVC\Http\Authentification {

    interface IAuthenticable {

        public function header();
        public function validateRequest();
        public function addUsers($user);

    }
}