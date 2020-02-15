<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class session {

    public function __construct() {
        return true;
    }

    public static function exists($name) {
        return isset($_SESSION[$name]) ? true : false;
    }

    public static function set($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function delete($name) {

        if (self::exists($name)) {
            unserialize($_SESSION[$name]);
            session_destroy();
        }
    }

    public static function uagent_no_version() {
        $uagent = $_SERVER["HTTP_USER_AGENT"];
        $regx = '/\/[a-zA-Z0-9.]+/';
        $newStrig = preg_replace($regx, "", $uagent);
        return $newStrig;
    }

}
