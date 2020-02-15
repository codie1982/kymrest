<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of plasebo_data
 *
 * @author engin
 */
class plasebo_data {

    public $rememberme;
    public $redirect;

    /**
     *  remember me
     * plasebo data
     * @param type $value
     */
    public function set_rememberme($value) {
        $this->rememberme = $value;
        data::addPlasebo("rememberme", $this->rememberme);
    }

    /**
     *  redirect me
     * plasebo data
     * @param type $value
     */
    public function set_redirect($value) {
        $this->redirect = $value;
        data::addPlasebo("redirect", $this->redirect);
    }

}
