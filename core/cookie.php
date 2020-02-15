<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cookie
 *
 * @author engin
 */
class cookie {

    //put your code here

    public function __construct() {
        return true;
    }

    public static function set($name, $value, $expiry) {
        if (setcookie($name, $value, time() + $expiry, "/")) {
            return true;
        } else {
            return false;
        }
    }

    public static function delete($name) {
        self::set($name, '', time() - 86400);
    }

    public static function get($name) {
        return $_COOKIE[$name];
    }
    public static function exists($name){
       
        return isset($_COOKIE[$name])? true : false;
    }

}
