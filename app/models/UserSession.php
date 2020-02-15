<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usersessions
 *
 * @author engin
 */
class UserSession extends model {

    public function __construct() {
        $table = "user_session";
        parent::__construct($table);
    }

    public static function getFromCookie() {
        if (cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            $userSession = new self();
            $uSession = $userSession->query("SELECT * FROM user_session WHERE session = ? ", [cookie::get(REMEMBER_ME_COOKIE_NAME)])->one();
        }
        if (!$uSession)
            return false;
        return $uSession;
    }

    public static function getVisitorID() {
//        if (cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
//             $userSession = new self();
//            $users_id = $userSession->query("SELECT users_id FROM user_session WHERE session = ? ", [cookie::get(REMEMBER_ME_COOKIE_NAME)])->one();
//        }
//      
//        if (!$users_id)
//            return false;
//        return $users_id;
    }

}
