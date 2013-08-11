<?php
namespace LibreMVC\Database;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author julien
 */
interface Modifiable {
    
    public function delete();
    public function save();
    public function update();

}
