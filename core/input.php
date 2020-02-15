<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of input
 *
 * @author engin
 */
class input {

    public static function santize($dirty) {
        
        return trim(htmlentities($dirty, ENT_QUOTES, "UTF-8"));
    }

    public static function get($input) {
        if (isset($_POST[$input])) {
            return self::santize($_POST[$input]);
        } else if (isset($_GET[$input])) {
            return self::santize($_GET[$input]);
        } else {
            return false;
        }
    }

}
