<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setdb
 *
 * @author engin
 */
class setmail {

    function __construct() {
        return true;
    }

    static function checkmailsettings() {
        if (file_exists(ROOT . DS . 'mailsettings.json'))
            return true;
        return false;
    }

    static function setmailfile($data) {
        $fp = fopen('mailsettings.json', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
        return true;
    }

}
