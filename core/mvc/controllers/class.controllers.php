<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 31/10/13
 * Time: 11:02
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc;


class Controllers {
    /**
     * Setter
     * @param string $member
     * @param string $value
     */
    public function __set($member, $value) {
        $this->$member = $value;
    }
    /**
     * Getter
     * @param string $attribut
     * @return Mixed
     */
    public function __get($attribut) {
        if (property_exists($this, $attribut)) {
            return $this->$attribut;
        }
    }
}