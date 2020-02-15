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
class generallist {

    public static $value = 0;
    public static $list = [];

    //put your code here
    static function addlist($list) {
        if (is_array($list)) {
            if (!empty($list)) {
                dnd($list);
                foreach ($list as $lt) {
                    self::$list[] = $lt;
                }
            }
        }
    }

    static function cleanList() {
        self::$list = [];
    }

    static function getlist() {
        return self::$list;
    }

}
