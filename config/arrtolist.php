<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of arrtolist
 *
 * @author engin
 */
class arrtolist {

    public static $value = 0;
    public static $arrlist = [];

    //put your code here
    static function setList($val) {
        self::$arrlist[] = $val;
    }

    static function cleanList() {
        self::$arrlist = [];
    }

    static function get_List() {
        return self::$arrlist;
    }

    static function setrepeat($value) {
        return self::$value = 0;
    }

    static function repeat($value) {
        self::$value = self::$value + $value;
    }

    static function getrepeatvalue() {
        return self::$value;
    }

}
