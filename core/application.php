<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application
 *
 * @author engin
 */
class application {

    public function __construct() {
        $this->_set_reporting();
       // $this->_unregister_globals();
        return true;
    }

    private function _set_reporting() {
        if (DEBUG) {
            error_reporting(E_ALL ^ E_NOTICE);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 1);
            ini_set("error_log", ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
        }
    }

    private function _unregister_globals() {
        if (ini_set('register_globals')) {
            $globals_arr = ['_SESSION', '_COOKIE', '_POST', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
            foreach ($globals_arr as $g) {
                foreach ($GLOBALS[$g] as $k => $v) {
                    if ($GLOBALS[$k] === $v) {
                        unset($GLOBALS[$k]);
                    }
                }
            }
        }
    }

}
