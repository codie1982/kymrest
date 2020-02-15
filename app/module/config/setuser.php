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
class setuser {

    function __construct() {
        return true;
    }

    static function checkfirstuser() {
        require_once(ROOT . DS . 'core' . DS . 'db' . '.php');
        $ndb = new db();
       
        $r = $ndb->query("SELECT * FROM customer WHERE add_state <> 'automatic' && customer_id='1' ")->one();
        if (!$r)
            return false;
        return true;
    }

    static function addfirstuser($source) {
        require_once(ROOT . DS . 'core' . DS . 'db.php');
        require_once(ROOT . DS . 'core' . DS . 'model.php');
        require_once(ROOT . DS . 'app' . DS . 'models' . DS . 'client.php');
        $nclient = new client();
        if ($nclient->newCustomer($source))
            return true;
        return false;
    }

}
