<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sidebar
 *
 * @author engin
 */
class mail_action extends component {

    public function render($parameter) {
        $this->set_component_name("mail_action");
        $this->make_component($parameter["type"]);
    }

}
