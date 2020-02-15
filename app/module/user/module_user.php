<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of register
 *
 * @author engin
 */



class module_user {

    public static function userlogout() {
        session::delete(CURRENT_USER_SESSION_NAME);
        if (cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        return true;
    }

}
